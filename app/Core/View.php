<?php

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = [], ?string $layout = null): string
    {
        $content = self::renderTemplate($view, $data);

        if ($layout === null) {
            return $content;
        }

        return self::renderTemplate($layout, [...$data, 'slot' => $content]);
    }

    private static function renderTemplate(string $view, array $data): string
    {
        $path = base_path('resources/views/' . str_replace('.', '/', $view) . '.php');

        if (!is_file($path)) {
            throw new \RuntimeException("View nao encontrada: $view");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $path;

        return ob_get_clean();
    }
}
