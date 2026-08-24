<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Purchase;
use App\Models\User;
use App\Services\MercadoPagoGateway;
use App\Services\PurchaseMailer;

final class WebhookController extends Controller
{
    public function mercadoPago(): never
    {
        $payloadBruto = file_get_contents('php://input');
        $body = json_decode($payloadBruto, true);
        $id = $body['data']['id'] ?? ($this->input('id') ?? null);
        $topic = $body['type'] ?? ($this->input('topic') ?? 'payment');

        if ($topic === 'payment' && !empty($id)) {
            $this->processarPagamentoPix((string) $id);
        }

        http_response_code(200);
        echo json_encode(['status' => 'ok']);
        exit;
    }

    private function processarPagamentoPix(string $paymentId): void
    {
        try {
            $gateway = new MercadoPagoGateway();
            $payment = $gateway->buscarPagamento($paymentId);

            if (!$payment || !isset($payment->id)) {
                return;
            }

            Purchase::atualizarStatus($paymentId, $payment->status);

            if ($payment->status !== 'approved') {
                return;
            }

            $referencia = explode('-', $payment->external_reference);

            if (count($referencia) < 2) {
                return;
            }

            $userId = (int) $referencia[0];
            $pacoteId = (int) $referencia[1];
            $cupomId = isset($referencia[2]) && $referencia[2] !== 'NULL' ? (int) $referencia[2] : 0;

            if (Purchase::jaProcessada($paymentId)) {
                return;
            }

            $pacote = Package::find($pacoteId);

            if (!$pacote) {
                return;
            }

            $user = User::find($userId);

            try {
                User::beginTransaction();

                User::lockForUpdate($userId);
                User::creditarFichasAvulso($userId, (int) $pacote['fichas'], (int) $pacote['validade_dias']);
                Purchase::registrar($userId, $pacoteId, $paymentId, (float) $payment->transaction_amount);

                if ($cupomId > 0) {
                    Coupon::registrarUso($cupomId, $userId);
                }

                User::commit();

                $userAtualizado = User::find($userId);
                PurchaseMailer::enviarConfirmacao($user['email'], $user['nome'], $pacote['nome'], (float) $payment->transaction_amount, (int) $pacote['fichas'], $userAtualizado['validade_fichas']);
            } catch (\Throwable) {
                User::rollBack();
            }
        } catch (\Throwable $exception) {
            error_log('Erro no webhook Mercado Pago: ' . $exception->getMessage());
        }
    }

    public function pagarmeAssinatura(): never
    {
        date_default_timezone_set('America/Sao_Paulo');

        $tokenRecebido = $this->input('token', '');

        if (!hash_equals(config('services.pagarme.webhook_token'), (string) $tokenRecebido)) {
            http_response_code(401);
            echo json_encode(['status' => 'erro', 'message' => 'Token invalido']);
            exit;
        }

        $json = file_get_contents('php://input');

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['status' => 'sucesso', 'message' => 'Webhook recebido']);

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        if ($json === '') {
            exit;
        }

        $data = json_decode($json, true);

        if (!$data || !isset($data['type'])) {
            exit;
        }

        if (in_array($data['type'], ['invoice.paid', 'charge.paid'], true)) {
            $this->processarRenovacaoAssinatura($data);
        }

        exit;
    }

    private function processarRenovacaoAssinatura(array $data): void
    {
        try {
            $subscriptionId = $data['data']['subscription']['id'] ?? $data['data']['subscription_id'] ?? '';
            $chargeId = $data['data']['id'] ?? null;

            $usuario = null;
            $planoId = '';

            if (!empty($subscriptionId)) {
                $usuario = User::buscarPorAssinatura($subscriptionId);
                $planoId = $usuario['mp_plan_id'] ?? '';
            }

            if (!$usuario) {
                $usuarioId = (int) ($data['data']['subscription']['code'] ?? $data['data']['customer']['code'] ?? 0);
                $planoId = $data['data']['subscription']['plan']['id'] ?? $data['data']['plan']['id'] ?? '';

                if ($usuarioId > 0) {
                    $usuario = User::find($usuarioId);
                }
            }

            if (!$usuario || empty($planoId)) {
                return;
            }

            if ($chargeId && $usuario['ultima_cobranca_assinatura_id'] === $chargeId) {
                return;
            }

            $pacote = Package::findBy('mp_plan_id', $planoId);

            if (!$pacote) {
                return;
            }

            User::beginTransaction();

            $novaValidade = date('Y-m-d', strtotime('+' . (int) $pacote['validade_dias'] . ' days'));
            User::renovarFichasAssinatura($usuario['id'], (int) $pacote['fichas'], (int) $pacote['validade_dias']);

            if ($chargeId) {
                User::update($usuario['id'], ['ultima_cobranca_assinatura_id' => $chargeId]);
            }

            User::commit();

            PurchaseMailer::enviarConfirmacao($usuario['email'], $usuario['nome'], $pacote['nome'], (float) $pacote['preco'], (int) $pacote['fichas'], $novaValidade, ehAssinatura: true);
        } catch (\Throwable $exception) {
            User::rollBack();
            error_log('Erro no webhook de assinatura Pagar.me: ' . $exception->getMessage());
        }
    }
}
