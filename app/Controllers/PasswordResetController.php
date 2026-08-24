<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\Mailer;

final class PasswordResetController extends Controller
{
    public function show(): string
    {
        return $this->view('auth.recuperar-senha', [], layout: null);
    }

    public function send(): never
    {
        $email = filter_var(trim($this->input('email', '')), FILTER_SANITIZE_EMAIL);
        $user = User::findBy('email', $email);

        if ($user) {
            $token = PasswordReset::gerar($email);
            $link = url("redefinir-senha?token=$token");

            $html = "<h2>Recuperacao de Senha</h2>"
                . "<p>Voce solicitou a redefinicao de senha para sua conta no Hiitstudio.</p>"
                . "<p><a href='$link' style='background:#000;color:#fff;padding:10px;text-decoration:none;'>Redefinir Minha Senha</a></p>"
                . "<p>Se voce nao solicitou isso, ignore este e-mail. O link expira em 1 hora.</p>";

            if (!Mailer::send($email, $user['nome'], 'Recuperacao de Senha - Hiitstudio', $html, strip_tags($html))) {
                error_log('Falha ao enviar e-mail de recuperacao para ' . $email);
            }
        }

        flash('sucesso', 'Se o e-mail estiver cadastrado, um link foi enviado!');
        redirect('recuperar-senha');
    }

    public function showReset(): string
    {
        $token = $this->input('token', '');
        $pedido = $token ? PasswordReset::valido($token) : null;

        return $this->view('auth.redefinir-senha', ['token' => $token, 'pedido' => $pedido], layout: null);
    }

    public function reset(): never
    {
        $token = $this->input('token', '');
        $pedido = PasswordReset::valido($token);

        if (!$pedido) {
            flash('erro', 'Este link de recuperacao e invalido ou ja expirou.');
            redirect("redefinir-senha?token=$token");
        }

        $senha = (string) $this->input('password', '');
        $confirmacao = (string) $this->input('confirm_password', '');

        if (strlen($senha) < 6) {
            flash('erro', 'A senha deve ter no minimo 6 caracteres.');
            redirect("redefinir-senha?token=$token");
        }

        if ($senha !== $confirmacao) {
            flash('erro', 'As senhas nao coincidem.');
            redirect("redefinir-senha?token=$token");
        }

        $user = User::findBy('email', $pedido['email']);
        User::updateSenha($user['id'], $senha);
        PasswordReset::marcarUsado($token);

        flash('sucesso', 'Senha alterada com sucesso!');
        redirect("redefinir-senha?token=$token");
    }
}
