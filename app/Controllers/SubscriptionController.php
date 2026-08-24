<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\User;
use App\Services\PagarmeGateway;
use App\Services\PurchaseMailer;

final class SubscriptionController extends Controller
{
    public function ativar(): never
    {
        Auth::requireLogin();

        $tokenRecebido = (string) $this->input('checkout_token', '');

        if ($tokenRecebido === '' || empty($_SESSION['checkout_token']) || !hash_equals($_SESSION['checkout_token'], $tokenRecebido)) {
            redirect('comprar-fichas?erro=sessao_expirada');
        }
        unset($_SESSION['checkout_token']);

        $userId = Auth::id();
        $pacote = Package::find((int) $this->input('pacote'));

        if (!$pacote || empty($pacote['mp_plan_id'])) {
            exit('Este pacote nao esta configurado como uma assinatura valida.');
        }

        $user = User::find($userId);
        $gateway = new PagarmeGateway();

        if (!empty($user['mp_subscription_id'])) {
            $gateway->cancelarAssinatura($user['mp_subscription_id']);
        }

        $cpfLimpo = preg_replace('/\D/', '', $user['cpf'] ?? '');

        if (empty($user['nome']) || empty($user['email']) || empty($cpfLimpo)) {
            redirect('editar-perfil?erro=complete_cadastro');
        }

        [$valorAssinatura, $descontoCentavos, $cupomId] = $this->aplicarCupom($pacote, $userId);

        $payload = [
            'code' => (string) $userId,
            'plan_id' => trim($pacote['mp_plan_id']),
            'payment_method' => 'credit_card',
            'customer' => [
                'name' => substr(trim($user['nome']), 0, 64),
                'email' => trim($user['email']),
                'document' => $cpfLimpo,
                'type' => 'individual',
            ],
            'card' => [
                'number' => (string) $this->input('card_number'),
                'holder_name' => trim(strtoupper((string) $this->input('card_holder_name'))),
                'exp_month' => (int) explode('/', (string) $this->input('card_exp'))[0],
                'exp_year' => (int) ('20' . (explode('/', (string) $this->input('card_exp'))[1] ?? '')),
                'cvv' => (string) $this->input('card_cvv'),
                'billing_address' => [
                    'zip_code' => '29000000',
                    'line_1' => 'Rua Padrao, 123',
                    'city' => 'Vitoria',
                    'state' => 'ES',
                    'country' => 'BR',
                ],
            ],
        ];

        if ($cupomId && $descontoCentavos > 0) {
            $payload['discounts'] = [['value' => $descontoCentavos, 'discount_type' => 'flat', 'cycles' => 1]];
        }

        $resposta = $gateway->criarAssinatura($payload);

        if ($resposta['status_code'] === 0) {
            redirect('status-pagamento?status=erro_conexao');
        }

        $body = $resposta['body'];

        if ($resposta['status_code'] >= 400 || isset($body['errors'])) {
            $mensagem = isset($body['errors'])
                ? ($body['errors'][array_key_first($body['errors'])][0] ?? 'Erro nos dados.')
                : ($body['message'] ?? 'Erro API.');

            redirect('status-pagamento?status=erro_pagarme&origem=pagarme&motivo=' . urlencode($mensagem));
        }

        $statusAssinatura = $body['status'] ?? null;

        if (!in_array($statusAssinatura, ['active', 'paid', 'pending', 'trialing'], true)) {
            $mensagem = $body['last_transaction']['gateway_message'] ?? 'Pagamento nao autorizado pelo banco.';
            redirect('status-pagamento?status=erro_pagarme&origem=pagarme&motivo=' . urlencode($mensagem));
        }

        try {
            User::beginTransaction();

            if ($cupomId) {
                Coupon::registrarUso($cupomId, $userId);
            }

            $novaValidade = date('Y-m-d H:i:s', strtotime('+' . (int) $pacote['validade_dias'] . ' days'));

            User::ativarAssinatura($userId, [
                'fichas' => (int) $pacote['fichas'],
                'validade_fichas' => $novaValidade,
                'mp_plan_id' => $pacote['mp_plan_id'],
                'mp_subscription_id' => $body['id'],
                'mp_customer_id' => $body['customer']['id'] ?? null,
                'mp_card_token' => $body['card']['id'] ?? null,
            ]);

            User::commit();

            PurchaseMailer::enviarConfirmacao($user['email'], $user['nome'], $pacote['nome'], $valorAssinatura, (int) $pacote['fichas'], $novaValidade, ehAssinatura: true);

            redirect('status-pagamento?status=sucesso');
        } catch (\Throwable) {
            User::rollBack();
            redirect('status-pagamento?status=pago_sem_credito');
        }
    }

    public function cancelar(): never
    {
        Auth::requireLogin();

        $user = User::find(Auth::id());
        $subscriptionId = $user['mp_subscription_id'] ?? null;

        if (!$subscriptionId) {
            redirect('status-pagamento?status=erro_cancelamento');
        }

        $gateway = new PagarmeGateway();
        $resposta = $gateway->cancelarAssinatura($subscriptionId);
        $jaCancelada = ($resposta['body']['message'] ?? '') === 'This subscription is canceled.';

        if ($resposta['status_code'] === 200 || $jaCancelada) {
            User::cancelarAssinatura($user['id']);
            redirect('status-pagamento?status=cancelado');
        }

        redirect('status-pagamento?status=erro_cancelamento');
    }

    private function aplicarCupom(array $pacote, int $userId): array
    {
        $codigo = strtoupper(trim((string) $this->input('cupom_codigo', '')));
        $valorOriginal = (float) $pacote['preco'];

        if ($codigo === '') {
            return [$valorOriginal, 0, null];
        }

        $cupom = Coupon::ativoParaResgate($codigo);

        if (!$cupom || !Coupon::estaDentroDaValidade($cupom)) {
            return [$valorOriginal, 0, null];
        }

        if (Coupon::jaUsadoPor($cupom['id'], $userId)) {
            redirect('status-pagamento?status=cupom_ja_usado');
        }

        $descontoCentavos = (int) round(Coupon::calcularDesconto($cupom, $valorOriginal) * 100);
        $valorOriginalCentavos = (int) round($valorOriginal * 100);

        if ($descontoCentavos >= $valorOriginalCentavos) {
            $descontoCentavos = $valorOriginalCentavos - 1;
        }

        $valorFinal = round(($valorOriginalCentavos - $descontoCentavos) / 100, 2);

        return [$valorFinal, $descontoCentavos, $cupom['id']];
    }
}
