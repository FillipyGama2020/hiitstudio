<?php

namespace App\Models;

use App\Core\Model;

final class PasswordReset extends Model
{
    protected static string $table = 'recuperacao_senha';

    public static function gerar(string $email): string
    {
        $token = bin2hex(random_bytes(32));
        $expiraEm = date('Y-m-d H:i:s', strtotime('+1 hour'));

        static::query('DELETE FROM recuperacao_senha WHERE email = ?', [$email]);
        static::insert(['email' => $email, 'token' => $token, 'expira_em' => $expiraEm]);

        return $token;
    }

    public static function valido(string $token): ?array
    {
        $registro = static::query(
            'SELECT * FROM recuperacao_senha WHERE token = ? AND usado = 0 AND expira_em > NOW()',
            [$token]
        )->fetch();

        return $registro ?: null;
    }

    public static function marcarUsado(string $token): void
    {
        static::query('UPDATE recuperacao_senha SET usado = 1 WHERE token = ?', [$token]);
    }
}
