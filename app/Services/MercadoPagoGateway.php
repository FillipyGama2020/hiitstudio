<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

final class MercadoPagoGateway
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.mercadopago.com/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('services.mercadopago.access_token'),
            ],
            'http_errors' => false,
        ]);

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function criarPagamentoPix(array $payload): array
    {
        try {
            $response = $this->client->post('v1/payments', [
                'json' => $payload,
                'headers' => ['X-Idempotency-Key' => uniqid('', true)],
            ]);
        } catch (GuzzleException) {
            return ['status_code' => 0, 'body' => []];
        }

        $body = json_decode((string) $response->getBody(), true) ?? [];

        return ['status_code' => $response->getStatusCode(), 'body' => $body];
    }

    public function buscarPagamento(string $paymentId): ?object
    {
        $paymentClient = new PaymentClient();

        return $paymentClient->get($paymentId);
    }
}
