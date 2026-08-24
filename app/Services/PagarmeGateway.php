<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class PagarmeGateway
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.pagarme.base_url') . '/',
            'auth' => [config('services.pagarme.secret_key'), ''],
            'headers' => ['Content-Type' => 'application/json'],
            'http_errors' => false,
        ]);
    }

    public function criarPedido(array $payload): array
    {
        return $this->request('POST', 'orders', $payload);
    }

    public function criarAssinatura(array $payload): array
    {
        return $this->request('POST', 'subscriptions', $payload);
    }

    public function cancelarAssinatura(string $subscriptionId): array
    {
        return $this->request('DELETE', "subscriptions/$subscriptionId");
    }

    public function criarPlano(array $payload): array
    {
        return $this->request('POST', 'plans', $payload);
    }

    public function atualizarPlano(string $planId, array $payload): array
    {
        return $this->request('PUT', "plans/$planId", $payload);
    }

    public function buscarPlano(string $planId): array
    {
        return $this->request('GET', "plans/$planId");
    }

    private function request(string $method, string $uri, ?array $payload = null): array
    {
        $options = $payload !== null ? ['json' => $payload] : [];

        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (GuzzleException) {
            return ['status_code' => 0, 'body' => []];
        }

        $body = json_decode((string) $response->getBody(), true) ?? [];

        return ['status_code' => $response->getStatusCode(), 'body' => $body];
    }
}
