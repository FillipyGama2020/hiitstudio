<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

final class ProfileController extends Controller
{
    public function show(): string
    {
        Auth::requireLogin();

        return $this->view('dashboard.perfil', ['user' => $this->user()], layout: null);
    }

    public function update(): never
    {
        Auth::requireLogin();

        $userId = Auth::id();
        $novaSenha = (string) $this->input('password', '');
        $confirmacao = (string) $this->input('confirm_password', '');

        User::update($userId, [
            'nome' => trim($this->input('nome', '')),
            'telefone' => trim($this->input('telefone', '')),
            'cpf' => trim($this->input('cpf', '')),
        ]);

        if ($novaSenha !== '') {
            if ($novaSenha !== $confirmacao) {
                flash('erro', 'As senhas nao coincidem.');
                redirect('editar-perfil');
            }

            if (strlen($novaSenha) < 6) {
                flash('erro', 'A senha deve ter pelo menos 6 caracteres.');
                redirect('editar-perfil');
            }

            User::updateSenha($userId, $novaSenha);
        }

        flash('sucesso', 'Dados atualizados com sucesso!');
        redirect('editar-perfil');
    }
}
