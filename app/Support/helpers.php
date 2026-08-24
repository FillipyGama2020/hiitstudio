<?php

function env(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false) {
        return $default;
    }

    return match (strtolower((string) $value)) {
        'true', '(true)' => true,
        'false', '(false)' => false,
        'null', '(null)' => null,
        default => $value,
    };
}

function config(string $key, mixed $default = null): mixed
{
    static $items = [];

    if (empty($items)) {
        foreach (glob(__DIR__ . '/../../config/*.php') as $file) {
            $items[basename($file, '.php')] = require $file;
        }
    }

    $segments = explode('.', $key);
    $value = $items;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function base_path(string $path = ''): string
{
    return rtrim(dirname(__DIR__, 2) . '/' . ltrim($path, '/'), '/');
}

function asset(string $path): string
{
    return rtrim(config('app.url'), '/') . '/assets/' . ltrim($path, '/');
}

function url(string $path = ''): string
{
    return rtrim(config('app.url'), '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old_input'][$key] ?? $default;
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function money(float $value): string
{
    return 'R$ ' . number_format($value, 2, ',', '.');
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);

    return $value;
}
