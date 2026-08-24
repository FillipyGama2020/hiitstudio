<?php

namespace App\Models;

use App\Core\Model;

final class Coupon extends Model
{
    protected static string $table = 'cupons';

    public static function ativoParaResgate(string $codigo): ?array
    {
        return static::query(
            "SELECT * FROM cupons WHERE codigo = ? AND status = 'ativo'",
            [$codigo]
        )->fetch() ?: null;
    }

    public static function estaDentroDaValidade(array $cupom): bool
    {
        $dentroDoPrazo = !$cupom['validade'] || $cupom['validade'] >= date('Y-m-d');
        $dentroDoLimite = !$cupom['uso_limite'] || $cupom['uso_contagem'] < $cupom['uso_limite'];

        return $dentroDoPrazo && $dentroDoLimite;
    }

    public static function jaUsadoPor(int $cupomId, int $userId): bool
    {
        $registro = static::query(
            'SELECT id FROM cupom_usos WHERE cupom_id = ? AND usuario_id = ?',
            [$cupomId, $userId]
        )->fetch();

        return (bool) $registro;
    }

    public static function calcularDesconto(array $cupom, float $valorOriginal): float
    {
        $desconto = $cupom['tipo'] === 'porcentagem'
            ? $valorOriginal * ((float) $cupom['valor'] / 100)
            : (float) $cupom['valor'];

        return min($desconto, $valorOriginal);
    }

    public static function registrarUso(int $cupomId, int $userId): bool
    {
        $statement = static::query(
            'UPDATE cupons SET uso_contagem = uso_contagem + 1 WHERE id = ? AND (uso_limite IS NULL OR uso_contagem < uso_limite)',
            [$cupomId]
        );

        if ($statement->rowCount() !== 1) {
            return false;
        }

        static::query(
            'INSERT INTO cupom_usos (cupom_id, usuario_id, data_uso) VALUES (?, ?, NOW())',
            [$cupomId, $userId]
        );

        return true;
    }
}
