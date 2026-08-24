<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Compra confirmada</title>
</head>
<body style="margin:0; padding:0; background-color:#eef1f5;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef1f5; padding: 30px 0;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 520px; background-color: #ffffff; border-radius: 12px; overflow: hidden; font-family: Arial, sans-serif;">
                <tr>
                    <td style="background-color: #071a3d; padding: 28px 30px; text-align: center;">
                        <span style="font-size: 22px; font-weight: bold; color: #ffffff; letter-spacing: 1px;">HIIT<span style="color: #ff6A00;">STUDIO</span></span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 36px 30px 10px 30px; text-align: center;">
                        <div style="width: 64px; height: 64px; background-color: #e8f7ee; border-radius: 50%; margin: 0 auto 18px auto; line-height: 64px; font-size: 32px; color: #28a745;">&#10003;</div>
                        <h1 style="margin: 0; font-size: 22px; color: #071a3d;">Compra realizada com sucesso!</h1>
                        <p style="font-size: 15px; color: #555; margin: 10px 0 0 0;">Ola, <?= e($primeiroNome) ?>! Confirmamos o pagamento e suas fichas ja estao disponiveis.</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 30px 0 30px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f8fa; border-radius: 10px;">
                            <tr>
                                <td style="padding: 20px 24px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px; color: #333;">
                                        <tr>
                                            <td style="padding: 6px 0; color: #888;">Pacote</td>
                                            <td style="padding: 6px 0; text-align: right; font-weight: bold;"><?= e($pacote) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 6px 0; color: #888; border-top: 1px solid #e5e5e5;">Valor pago</td>
                                            <td style="padding: 6px 0; text-align: right; font-weight: bold; border-top: 1px solid #e5e5e5;"><?= money($valor) ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 6px 0; color: #888; border-top: 1px solid #e5e5e5;">Fichas creditadas</td>
                                            <td style="padding: 6px 0; text-align: right; font-weight: bold; color: #ff6A00; border-top: 1px solid #e5e5e5;"><?= (int) $fichas ?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 6px 0; color: #888; border-top: 1px solid #e5e5e5;">Valido ate</td>
                                            <td style="padding: 6px 0; text-align: right; font-weight: bold; border-top: 1px solid #e5e5e5;"><?= e($validade) ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php if ($ehAssinatura): ?>
                <tr>
                    <td style="padding: 20px 30px 0 30px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #fff8f0; border: 1px solid #ffdcb8; border-radius: 8px;">
                            <tr>
                                <td style="padding: 16px 20px; font-size: 14px; color: #663c00; line-height: 1.5;">
                                    <strong>Lembrete:</strong> este pacote e uma assinatura com renovacao automatica. A proxima cobranca sera feita direto no seu cartao, e voce recebera um e-mail como este a cada renovacao.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td style="padding: 30px 30px 36px 30px; text-align: center;">
                        <a href="<?= url('dashboard') ?>" style="display: inline-block; background-color: #ff6A00; color: #ffffff; text-decoration: none; font-weight: bold; font-size: 14px; padding: 14px 32px; border-radius: 8px;">IR PARA O PAINEL</a>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #071a3d; padding: 18px 30px; text-align: center;">
                        <p style="margin: 0; font-size: 12px; color: #a9b3c4;">Hiitstudio &middot; Se voce nao reconhece esta compra, entre em contato com o suporte.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
