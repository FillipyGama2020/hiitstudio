<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Purchase;
use App\Models\User;
use App\Services\MercadoPagoGateway;
use App\Services\PagarmeGateway;
use App\Services\PurchaseMailer;

final class PaymentController extends Controller
{
    public function cartaoAvulso(): never
    {
        Auth::requireLogin();

        $tokenRecebido = (string) $this->input('checkout_token', '');

        if ($tokenRecebido === '' || empty($_SESSION['checkout_token']) || !hash_equals($_SESSION['checkout_token'], $tokenRecebido)) {
            redirect('comprar-fichas?erro=sessao_expirada');
        }
        unset($_SESSION['checkout_token']);

        $userId = Auth::id();
        $pacote = Package::find((int) $this->input('pacote_id'));

        if (!$pacote) {
            redirect('comprar-fichas?erro=pacote_invalido');
        }

        $user = User::find($userId);
        $parcelas = Package::limitarParcelas($pacote, (int) $this->input('parcelas', 1));

        [$valorFinal, $cupomId] = $this->aplicarCupom($pacote, $userId);

        $cpfLimpo = preg_replace('/\D/', '', $user['cpf'] ?? '');

        if (empty($user['nome']) || empty($user['email']) || empty($cpfLimpo)) {
            redirect('editar-perfil?erro=complete_cadastro');
        }

        $gateway = new PagarmeGateway();
        $resposta = $gateway->criarPedido([
            'items' => [[
                'code' => (string) $pacote['id'],
                'amount' => (int) round($valorFinal * 100),
                'description' => $pacote['nome'],
                'quantity' => 1,
            ]],
            'customer' => [
                'name' => $user['nome'],
                'email' => $user['email'],
                'type' => 'individual',
                'document' => $cpfLimpo,
                'phones' => ['mobile_phone' => ['country_code' => '55', 'area_code' => '27', 'number' => '999999999']],
            ],
            'payments' => [[
                'payment_method' => 'credit_card',
                'credit_card' => [
                    'installments' => $parcelas,
                    'statement_descriptor' => 'HIITSTUDIO',
                    'card' => [
                        'number' => (string) $this->input('card_number'),
                        'holder_name' => strtoupper(trim((string) $this->input('card_holder_name'))),
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
                ],
            ]],
        ]);

        if ($resposta['status_code'] === 0) {
            redirect('status-pagamento?status=erro_conexao');
        }

        $body = $resposta['body'];
        $status = $body['charges'][0]['last_transaction']['status'] ?? null;
        $aprovado = in_array($status, ['captured', 'paid'], true);

        if (!$aprovado) {
            $motivo = $body['charges'][0]['last_transaction']['gateway_message']
                ?? $body['charges'][0]['last_transaction']['acquirer_message']
                ?? $body['message']
                ?? null;

            $destino = 'status-pagamento?status=erro_pagarme&origem=pagarme';
            redirect($motivo ? $destino . '&motivo=' . urlencode($motivo) : $destino);
        }

        try {
            User::beginTransaction();

            if ($cupomId) {
                Coupon::registrarUso($cupomId, $userId);
            }

            User::creditarFichasAvulso($userId, (int) $pacote['fichas'], (int) $pacote['validade_dias']);
            Purchase::registrar($userId, $pacote['id'], $body['id'], $valorFinal);

            User::commit();

            $userAtualizado = User::find($userId);
            PurchaseMailer::enviarConfirmacao($user['email'], $user['nome'], $pacote['nome'], $valorFinal, (int) $pacote['fichas'], $userAtualizado['validade_fichas']);

            redirect('status-pagamento?status=sucesso');
        } catch (\Throwable) {
            User::rollBack();
            redirect('status-pagamento?status=pago_sem_credito');
        }
    }

    public function pix(): never
    {
        Auth::requireLogin();

        $userId = Auth::id();
        $pacote = Package::find((int) $this->input('pacote'));

        if (!$pacote) {
            exit('Pacote nao encontrado.');
        }

        $user = User::find($userId);
        [$valorFinal, $cupomId, $nomeCupom] = $this->aplicarCupomPix($pacote, $userId);
        $cpfLimpo = preg_replace('/[^0-9]/', '', $user['cpf'] ?? '');

        if (empty($user['nome']) || empty($user['email']) || empty($cpfLimpo)) {
            redirect('editar-perfil?erro=complete_cadastro');
        }

        $gateway = new MercadoPagoGateway();
        $externalRef = $userId . '-' . $pacote['id'] . '-' . ($cupomId ?? 'NULL');

        $resposta = $gateway->criarPagamentoPix([
            'transaction_amount' => (float) number_format($valorFinal, 2, '.', ''),
            'description' => 'Compra de Fichas - ' . $pacote['nome'],
            'payment_method_id' => 'pix',
            'external_reference' => $externalRef,
            'notification_url' => url('webhooks/mercadopago'),
            'payer' => [
                'email' => $user['email'],
                'first_name' => explode(' ', $user['nome'])[0],
                'last_name' => strstr($user['nome'], ' ') ?: '',
                'identification' => ['type' => 'CPF', 'number' => $cpfLimpo],
            ],
        ]);

        if ($resposta['status_code'] === 0) {
            redirect('status-pagamento?status=erro_conexao');
        }

        $body = $resposta['body'];
        $statusPagamento = $body['status'] ?? null;

        if (!in_array($statusPagamento, ['pending', 'in_process'], true)) {
            $motivo = $body['status_detail'] ?? $body['message'] ?? ($body['cause'][0]['description'] ?? null);
            $destino = 'status-pagamento?status=erro_pix';
            redirect($motivo ? $destino . '&origem=mercadopago&motivo=' . urlencode($motivo) : $destino);
        }

        $idTransacao = (string) $body['id'];
        $dadosTransacao = $body['point_of_interaction']['transaction_data'] ?? null;

        try {
            Purchase::registrarPendente($userId, $pacote['id'], $idTransacao, $valorFinal);
        } catch (\PDOException) {
        }

        $_SESSION['pix_id'] = $idTransacao;
        $_SESSION['pix_qr_base64'] = $dadosTransacao['qr_code_base64'] ?? '';
        $_SESSION['pix_copia_cola'] = $dadosTransacao['qr_code'] ?? '';
        $_SESSION['pix_valor_original'] = (float) $pacote['preco'];
        $_SESSION['pix_valor_final'] = $valorFinal;
        $_SESSION['pix_cupom'] = $nomeCupom;

        redirect('pagar-pix');
    }

    public function statusPix(): never
    {
        Auth::requireLogin();
        header('Content-Type: application/json');

        $paymentId = (string) $this->input('id', '');

        if ($paymentId === '' || $paymentId === 'N/A') {
            echo json_encode(['status' => 'pending']);
            exit;
        }

        $status = Purchase::statusPorPaymentId($paymentId);
        echo json_encode(['status' => $status ?? 'pending']);
        exit;
    }

    private function aplicarCupom(array $pacote, int $userId): array
    {
        $codigo = strtoupper(trim((string) $this->input('cupom_codigo', '')));
        $valorFinal = (float) $pacote['preco'];

        if ($codigo === '') {
            return [$valorFinal, null];
        }

        $cupom = Coupon::ativoParaResgate($codigo);

        if (!$cupom || !Coupon::estaDentroDaValidade($cupom)) {
            exit('Cupom invalido ou expirado.');
        }

        if (Coupon::jaUsadoPor($cupom['id'], $userId)) {
            redirect('status-pagamento?status=cupom_ja_usado');
        }

        $desconto = Coupon::calcularDesconto($cupom, $valorFinal);

        return [max(0, $valorFinal - $desconto), $cupom['id']];
    }

    private function aplicarCupomPix(array $pacote, int $userId): array
    {
        $codigo = strtoupper(trim((string) $this->input('cupom_codigo', '')));
        $valorFinal = (float) $pacote['preco'];

        if ($codigo === '') {
            return [$valorFinal, null, null];
        }

        $cupom = Coupon::ativoParaResgate($codigo);

        if (!$cupom || !Coupon::estaDentroDaValidade($cupom)) {
            return [$valorFinal, null, null];
        }

        if (Coupon::jaUsadoPor($cupom['id'], $userId)) {
            redirect('status-pagamento?status=cupom_ja_usado');
        }

        $desconto = Coupon::calcularDesconto($cupom, $valorFinal);

        return [max(0, $valorFinal - $desconto), $cupom['id'], $cupom['codigo']];
    }
}
