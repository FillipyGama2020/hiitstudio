<?php

namespace App\Models;

use App\Core\Model;

final class Package extends Model
{
    protected static string $table = 'pacotes';

    public static function byCategory(string $category): array
    {
        $stmt = static::query('SELECT * FROM pacotes WHERE categoria = ? ORDER BY preco ASC', [$category]);

        return $stmt->fetchAll();
    }

    public static function precoPorAula(array $package): float
    {
        return $package['fichas'] > 0 ? $package['preco'] / $package['fichas'] : 0.0;
    }

    public static function limitarParcelas(array $package, int $parcelasEscolhidas): int
    {
        return max(1, min($parcelasEscolhidas, (int) $package['max_parcelas']));
    }
}
