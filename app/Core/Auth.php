<?php

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findBy('email', $email);

        if (!$user || !password_verify($password, $user['senha'])) {
            return false;
        }

        if ((int) $user['status'] !== 1) {
            return false;
        }

        self::login($user);

        return true;
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function user(): ?array
    {
        static $cached = null;

        if (!self::check()) {
            return null;
        }

        if ($cached === null || $cached['id'] !== self::id()) {
            $cached = User::find(self::id());
        }

        return $cached;
    }

    public static function isAdmin(): bool
    {
        $user = self::user();

        return $user && $user['nivel_acesso'] === 'admin';
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            redirect('login');
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!self::isAdmin()) {
            http_response_code(403);
            exit('Acesso negado.');
        }
    }
}
