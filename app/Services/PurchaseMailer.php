<?php

namespace App\Services;

use App\Core\View;

final class PurchaseMailer
{
    public static function enviarConfirmacao(
        string $email,
        string $nome,
        string $pacote,
        float $valor,
        int $fichas,
        ?string $validade,
        bool $ehAssinatura = false
    ): bool {
        $html = View::render('emails.compra-confirmada', [
            'primeiroNome' => explode(' ', trim($nome))[0] ?? $nome,
            'pacote' => $pacote,
            'valor' => $valor,
            'fichas' => $fichas,
            'validade' => $validade ? date('d/m/Y', strtotime($validade)) : 'Sem validade definida',
            'ehAssinatura' => $ehAssinatura,
        ], layout: null);

        $texto = "Compra realizada com sucesso!\nPacote: $pacote\nValor: " . money($valor)
            . "\nFichas creditadas: $fichas\nValido ate: " . ($validade ? date('d/m/Y', strtotime($validade)) : 'sem validade');

        return Mailer::send($email, $nome, 'Compra confirmada - Hiitstudio', $html, $texto);
    }
}
