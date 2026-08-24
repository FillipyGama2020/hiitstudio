<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\User;
use App\Services\PaymentErrorTranslator;

final class CheckoutController extends Controller
{
    public function pacotes(): string
    {
        $user = Auth::user();

        return $this->view('checkout.pacotes', [
            'user' => $user,
            'avulsos' => Package::byCategory('avulso'),
            'assinaturas' => Package::byCategory('assinatura'),
        ], layout: null);
    }

    public function formularioCartao(): string
    {
        Auth::requireLogin();

        $pacoteId = (int) $this->input('pacote');
        $pacote = Package::find($pacoteId);

        if (!$pacote) {
            http_response_code(404);
            exit('Pacote invalido.');
        }

        $token = bin2hex(random_bytes(16));
        $_SESSION['checkout_token'] = $token;

        return $this->view('checkout.cartao', [
            'pacote' => $pacote,
            'ehAssinatura' => !empty($pacote['mp_plan_id']),
            'checkoutToken' => $token,
        ], layout: null);
    }

    public function pagarPix(): string
    {
        Auth::requireLogin();

        if (empty($_SESSION['pix_id'])) {
            http_response_code(400);
            exit('Nenhum pagamento Pix em andamento.');
        }

        return $this->view('checkout.pix', [
            'pixId' => $_SESSION['pix_id'],
            'qrBase64' => $_SESSION['pix_qr_base64'],
            'copiaCola' => $_SESSION['pix_copia_cola'],
            'valorOriginal' => $_SESSION['pix_valor_original'],
            'valorFinal' => $_SESSION['pix_valor_final'],
            'cupom' => $_SESSION['pix_cupom'],
        ], layout: null);
    }

    public function validarCupom(): never
    {
        Auth::requireLogin();
        header('Content-Type: application/json');

        $codigo = strtoupper(trim((string) $this->input('codigo', '')));
        $pacoteId = (int) $this->input('pacote_id');
        $pacote = Package::find($pacoteId);

        if (!$pacote) {
            echo json_encode(['sucesso' => false, 'erro' => 'Pacote invalido.']);
            exit;
        }

        $cupom = Coupon::ativoParaResgate($codigo);

        if (!$cupom) {
            echo json_encode(['sucesso' => false, 'erro' => 'Cupom invalido ou expirado.']);
            exit;
        }

        if (Coupon::jaUsadoPor($cupom['id'], Auth::id())) {
            echo json_encode(['sucesso' => false, 'erro' => 'Voce ja utilizou este cupom anteriormente.']);
            exit;
        }

        if (!Coupon::estaDentroDaValidade($cupom)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Este cupom expirou ou atingiu o limite de usos.']);
            exit;
        }

        $desconto = Coupon::calcularDesconto($cupom, (float) $pacote['preco']);
        $valorFinal = max(0, $pacote['preco'] - $desconto);

        echo json_encode([
            'sucesso' => true,
            'desconto_formatado' => money($desconto),
            'valor_desconto' => $desconto,
            'valor_final' => $valorFinal,
        ]);
        exit;
    }

    public function status(): string
    {
        Auth::requireLogin();

        $status = $this->input('status', '');
        $origem = $this->input('origem', '');
        $motivo = $this->input('motivo', '');

        $statusComRetentativa = ['recusado', 'erro_pagarme', 'erro_pix', 'erro_conexao'];
        $mostrarBotao = false;

        switch (true) {
            case $status === 'sucesso':
                $titulo = 'Pagamento concluido!';
                $subtitulo = 'Suas fichas foram creditadas com sucesso. Seu treino te espera!';
                $cor = '#28a745';
                $icone = 'fa-check-circle';
                break;
            case $status === 'cancelado':
                $titulo = 'Assinatura cancelada';
                $subtitulo = 'Sua assinatura foi encerrada e suas fichas foram removidas com sucesso.';
                $cor = '#dc3545';
                $icone = 'fa-info-circle';
                break;
            case $status === 'pago_sem_credito':
                $titulo = 'Pagamento recebido';
                $subtitulo = 'Identificamos seu pagamento, mas houve um problema tecnico ao liberar suas fichas automaticamente. Nao e necessario pagar novamente. Entre em contato com o administrador informando o horario desta compra.';
                $cor = '#ffc107';
                $icone = 'fa-exclamation-triangle';
                break;
            case $status === 'erro_conexao':
                $titulo = 'Problema de conexao';
                $subtitulo = 'Tivemos um problema de conexao ao processar seu pagamento e nenhuma cobranca foi realizada. Tente novamente.';
                $cor = '#ffc107';
                $icone = 'fa-exclamation-triangle';
                $mostrarBotao = true;
                break;
            case in_array($status, $statusComRetentativa, true):
                $titulo = 'Pagamento nao concluido';
                $subtitulo = PaymentErrorTranslator::traduzir($origem, $motivo);
                $cor = '#ffc107';
                $icone = 'fa-exclamation-triangle';
                $mostrarBotao = true;
                break;
            case $status === 'cupom_ja_usado':
                $titulo = 'Cupom ja utilizado';
                $subtitulo = 'Voce ja usou este cupom anteriormente. Cada cupom pode ser usado apenas uma vez por aluno.';
                $cor = '#ffc107';
                $icone = 'fa-exclamation-triangle';
                $mostrarBotao = true;
                break;
            case $status === 'erro_cancelamento':
                $titulo = 'Ops! Algo deu errado';
                $subtitulo = 'Nao conseguimos processar o cancelamento na API. Verifique se a assinatura ja foi cancelada ou tente novamente.';
                $cor = '#ffc107';
                $icone = 'fa-exclamation-triangle';
                break;
            default:
                $titulo = 'Erro no processamento';
                $subtitulo = 'Nao foi possivel processar a transacao no momento. Por favor, tente novamente mais tarde.';
                $cor = '#666';
                $icone = 'fa-times-circle';
                $mostrarBotao = true;
        }

        return $this->view('checkout.status', compact('titulo', 'subtitulo', 'cor', 'icone', 'mostrarBotao'), layout: null);
    }
}
