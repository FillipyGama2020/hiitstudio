<?php

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    public static function send(string $toEmail, string $toName, string $subject, string $htmlBody, string $textBody): bool
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = config('mail.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.username');
            $mail->Password = config('mail.password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = config('mail.port');

            $mail->setFrom(config('mail.username'), config('mail.from_name'));
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $htmlBody;
            $mail->AltBody = $textBody;

            $mail->send();

            return true;
        } catch (Exception $exception) {
            error_log('Falha ao enviar e-mail: ' . $mail->ErrorInfo);

            return false;
        }
    }
}
