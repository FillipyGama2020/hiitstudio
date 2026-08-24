<?php

namespace App\Models;

use App\Core\Model;

final class Purchase extends Model
{
    protected static string $table = 'historico_compras';

    public static function registrar(int $userId, int $packageId, string $transactionId, float $valor): void
    {
        static::insert([
            'usuario_id' => $userId,
            'pacote_id' => $packageId,
            'transacao_id' => $transactionId,
            'valor' => $valor,
            'data_compra' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function jaProcessada(string $transactionId): bool
    {
        return static::findBy('transacao_id', $transactionId) !== null;
    }

    public static function registrarPendente(int $userId, int $packageId, string $paymentId, float $valor): void
    {
        static::query(
            "INSERT INTO pagamentos_historico (usuario_id, pacote_id, pagarme_id, valor, status, data_criacao) VALUES (?, ?, ?, ?, 'pending', NOW())",
            [$userId, $packageId, $paymentId, $valor]
        );
    }

    public static function atualizarStatus(string $paymentId, string $status): void
    {
        static::query(
            'UPDATE pagamentos_historico SET status = ? WHERE pagarme_id = ?',
            [$status, $paymentId]
        );
    }

    public static function statusPorPaymentId(string $paymentId): ?string
    {
        $registro = static::query(
            'SELECT status FROM pagamentos_historico WHERE pagarme_id = ?',
            [$paymentId]
        )->fetch();

        return $registro['status'] ?? null;
    }
}
