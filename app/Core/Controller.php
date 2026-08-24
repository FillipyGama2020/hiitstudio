<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = [], ?string $layout = null): string
    {
        return View::render($view, $data, $layout);
    }

    protected function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function user(): ?array
    {
        return Auth::user();
    }
}
