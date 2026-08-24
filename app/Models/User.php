<?php

namespace App\Models;

use App\Core\Model;
use PDO;

final class User extends Model
{
    protected static string $table = 'usuarios';

    public static function create(array $data): int
    {
        return static::insert([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => password_hash($data['senha'], PASSWORD_DEFAULT),
            'telefone' => $data['telefone'] ?? null,
            'cpf' => $data['cpf'] ?? null,
            'data_nascimento' => $data['data_nascimento'] ?? null,
        ]);
    }

    public static function emailExists(string $email): bool
    {
        return static::findBy('email', $email) !== null;
    }

    public static function updateSenha(int $id, string $novaSenha): bool
    {
        return static::update($id, ['senha' => password_hash($novaSenha, PASSWORD_DEFAULT)]);
    }

    public static function creditarFichasAvulso(int $userId, int $fichas, int $validadeDias): void
    {
        $stmt = static::query('SELECT fichas, validade_fichas FROM usuarios WHERE id = ? FOR UPDATE', [$userId]);
        $user = $stmt->fetch();

        $hoje = date('Y-m-d H:i:s');
        $validadeAtual = $user['validade_fichas'] ?? null;
        $referencia = ($validadeAtual && strtotime($validadeAtual) > strtotime($hoje)) ? $validadeAtual : $hoje;
        $novaValidade = date('Y-m-d H:i:s', strtotime($referencia . " +$validadeDias days"));

        static::query(
            'UPDATE usuarios SET fichas = fichas + ?, validade_fichas = ? WHERE id = ?',
            [$fichas, $novaValidade, $userId]
        );
    }

    public static function renovarFichasAssinatura(int $userId, int $fichas, int $validadeDias): void
    {
        $novaValidade = date('Y-m-d', strtotime("+$validadeDias days"));

        static::query(
            "UPDATE usuarios SET fichas = ?, validade_fichas = ?, assinatura_status = 'active' WHERE id = ?",
            [$fichas, $novaValidade, $userId]
        );
    }

    public static function debitarFicha(int $userId): void
    {
        static::query('UPDATE usuarios SET fichas = fichas - 1 WHERE id = ?', [$userId]);
    }

    public static function creditarFicha(int $userId): void
    {
        static::query('UPDATE usuarios SET fichas = fichas + 1 WHERE id = ?', [$userId]);
    }

    public static function expirarFichasVencidas(): int
    {
        $stmt = static::query(
            "UPDATE usuarios SET fichas = 0, validade_fichas = NULL WHERE validade_fichas IS NOT NULL AND validade_fichas < CURDATE()"
        );

        return $stmt->rowCount();
    }

    public static function fichasAindaValidas(array $user): bool
    {
        if (empty($user['validade_fichas'])) {
            return $user['fichas'] > 0;
        }

        return $user['fichas'] > 0 && $user['validade_fichas'] >= date('Y-m-d');
    }

    public static function lockForUpdate(int $userId): array
    {
        $stmt = static::query('SELECT * FROM usuarios WHERE id = ? FOR UPDATE', [$userId]);

        return $stmt->fetch();
    }

    public static function buscarPorAssinatura(string $subscriptionId): ?array
    {
        return static::findBy('mp_subscription_id', $subscriptionId);
    }

    public static function ativarAssinatura(int $userId, array $dados): void
    {
        static::update($userId, [
            'fichas' => $dados['fichas'],
            'validade_fichas' => $dados['validade_fichas'],
            'assinatura_status' => 'active',
            'mp_plan_id' => $dados['mp_plan_id'],
            'mp_subscription_id' => $dados['mp_subscription_id'],
            'mp_customer_id' => $dados['mp_customer_id'] ?? null,
            'mp_card_token' => $dados['mp_card_token'] ?? null,
        ]);
    }

    public static function cancelarAssinatura(int $userId): void
    {
        static::update($userId, [
            'assinatura_status' => 'canceled',
            'mp_subscription_id' => null,
            'mp_plan_id' => null,
        ]);
    }

    public static function search(string $term): array
    {
        $like = "%$term%";
        $stmt = static::query(
            "SELECT * FROM usuarios WHERE (nome LIKE ? OR email LIKE ?) AND nome != 'MANUTENCAO' ORDER BY nome ASC",
            [$like, $like]
        );

        return $stmt->fetchAll();
    }

    public static function assinantesDoPlano(string $planoId): array
    {
        return static::query(
            "SELECT id, mp_subscription_id FROM usuarios WHERE mp_plan_id = ? AND mp_subscription_id IS NOT NULL AND mp_subscription_id != ''",
            [$planoId]
        )->fetchAll();
    }

    public static function setStatus(int $userId, int $status): void
    {
        static::update($userId, ['status' => $status]);
    }
}
