<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;

final class GoogleAuthController extends Controller
{
    private function client(): GoogleClient
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->addScope('email');
        $client->addScope('profile');

        return $client;
    }

    public function redirectToGoogle(): never
    {
        header('Location: ' . $this->client()->createAuthUrl());
        exit;
    }

    public function callback(): never
    {
        $code = $this->input('code');

        if (!$code) {
            redirect('login');
        }

        try {
            $client = $this->client();
            $token = $client->fetchAccessTokenWithAuthCode($code);
            $client->setAccessToken($token);

            $oauth = new Oauth2($client);
            $email = $oauth->userinfo->get()->email;

            $user = User::findBy('email', $email);

            if (!$user) {
                exit("O e-mail <strong>$email</strong> nao esta cadastrado no Hiitstudio.");
            }

            if ((int) $user['status'] !== 1) {
                exit('Sua conta esta inativa. Entre em contato com o administrador.');
            }

            Auth::login($user);
            redirect('dashboard');
        } catch (\Throwable $exception) {
            error_log('Erro na autenticacao Google: ' . $exception->getMessage());
            exit('Erro na autenticacao.');
        }
    }
}
