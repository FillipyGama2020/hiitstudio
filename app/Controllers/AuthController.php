<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

final class AuthController extends Controller
{
    public function showLogin(): string
    {
        if (Auth::check()) {
            redirect('dashboard');
        }

        return $this->view('auth.login', [], layout: null);
    }

    public function login(): never
    {
        $email = trim($this->input('email', ''));
        $senha = (string) $this->input('password', '');

        if ($email !== '' && $senha !== '' && Auth::attempt($email, $senha)) {
            redirect('dashboard');
        }

        flash('erro', 'E-mail ou senha invalidos, ou conta inativa.');
        redirect('login');
    }

    public function showCadastro(): string
    {
        return $this->view('auth.cadastro', [], layout: null);
    }

    public function cadastrar(): never
    {
        $nome = trim($this->input('nome', ''));
        $email = filter_var(trim($this->input('email', '')), FILTER_VALIDATE_EMAIL);
        $senha = (string) $this->input('password', '');

        if (!$email) {
            flash('erro', 'E-mail invalido.');
            redirect('cadastro');
        }

        if (strlen($senha) < 6) {
            flash('erro', 'A senha deve ter pelo menos 6 caracteres.');
            redirect('cadastro');
        }

        if (User::emailExists($email)) {
            flash('erro', 'Este e-mail ja esta cadastrado.');
            redirect('cadastro');
        }

        try {
            User::create([
                'nome' => $nome,
                'email' => $email,
                'senha' => $senha,
                'telefone' => trim($this->input('telefone', '')),
                'cpf' => trim($this->input('cpf', '')),
                'data_nascimento' => trim($this->input('data', '')) ?: null,
            ]);

            flash('sucesso', 'Cadastro realizado com sucesso! Faca login para continuar.');
            redirect('login');
        } catch (\PDOException $exception) {
            error_log('Erro no cadastro: ' . $exception->getMessage());
            flash('erro', 'Nao foi possivel concluir o cadastro no momento. Tente novamente.');
            redirect('cadastro');
        }
    }

    public function logout(): never
    {
        Auth::logout();
        redirect('login');
    }
}
