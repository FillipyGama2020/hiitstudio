<?php

namespace App\Services;

final class PaymentErrorTranslator
{
    private const MERCADOPAGO_CODES = [
        'cc_rejected_insufficient_amount' => 'Saldo insuficiente no cartao.',
        'cc_rejected_bad_filled_card_number' => 'Numero do cartao invalido. Confira os dados.',
        'cc_rejected_bad_filled_date' => 'Data de validade do cartao invalida.',
        'cc_rejected_bad_filled_security_code' => 'Codigo de seguranca (CVV) invalido.',
        'cc_rejected_bad_filled_other' => 'Revise os dados informados e tente novamente.',
        'cc_rejected_call_for_authorize' => 'Seu banco pediu uma autorizacao adicional. Entre em contato com ele ou tente outro cartao.',
        'cc_rejected_card_disabled' => 'Cartao desabilitado para compras online. Entre em contato com seu banco.',
        'cc_rejected_duplicated_payment' => 'Ja identificamos um pagamento igual a este recentemente.',
        'cc_rejected_high_risk' => 'Pagamento recusado por seguranca.',
        'cc_rejected_blacklist' => 'Pagamento recusado por seguranca.',
        'cc_rejected_max_attempts' => 'Numero maximo de tentativas excedido. Tente novamente mais tarde.',
        'cc_rejected_card_type_not_allowed' => 'Esse tipo de cartao nao e aceito.',
        'cc_rejected_invalid_installments' => 'Quantidade de parcelas invalida.',
        'expired' => 'O pagamento expirou antes de ser concluido.',
    ];

    private const PADROES_TEXTO_LIVRE = [
        'insufficient' => 'Saldo insuficiente no cartao.',
        'saldo' => 'Saldo insuficiente no cartao.',
        'expired' => 'Cartao expirado.',
        'expirad' => 'Cartao expirado.',
        'invalid card' => 'Numero do cartao invalido.',
        'invalid number' => 'Numero do cartao invalido.',
        'security code' => 'Codigo de seguranca (CVV) incorreto.',
        'cvv' => 'Codigo de seguranca (CVV) incorreto.',
        'stolen' => 'Cartao recusado pelo banco emissor.',
        'lost' => 'Cartao recusado pelo banco emissor.',
        'fraud' => 'Pagamento recusado por suspeita de fraude.',
        'suspeita' => 'Pagamento recusado por suspeita de fraude.',
        'do not honor' => 'Pagamento recusado pelo banco emissor do cartao.',
        'not honor' => 'Pagamento recusado pelo banco emissor do cartao.',
        'declined' => 'Pagamento recusado pelo banco emissor do cartao.',
        'denied' => 'Pagamento recusado pelo banco emissor do cartao.',
        'recusad' => 'Pagamento recusado pelo banco emissor do cartao.',
        'document' => 'Verifique se o CPF informado esta correto.',
        'cpf' => 'Verifique se o CPF informado esta correto.',
        'limit' => 'Limite do cartao excedido.',
        'limite' => 'Limite do cartao excedido.',
    ];

    public static function traduzir(string $origem, ?string $mensagem): string
    {
        $mensagem = trim((string) $mensagem);

        if ($mensagem === '') {
            return 'Nao foi possivel autorizar o pagamento. Verifique os dados e tente novamente.';
        }

        if ($origem === 'mercadopago' && isset(self::MERCADOPAGO_CODES[$mensagem])) {
            return self::MERCADOPAGO_CODES[$mensagem];
        }

        $textoEmMinusculas = mb_strtolower($mensagem, 'UTF-8');

        foreach (self::PADROES_TEXTO_LIVRE as $trecho => $traducao) {
            if (str_contains($textoEmMinusculas, $trecho)) {
                return $traducao;
            }
        }

        return 'Nao foi possivel autorizar o pagamento. Verifique os dados do cartao ou tente outro cartao.';
    }
}
