<?php

namespace App\Core;

final class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get(string $path, array $action): void
    {
        $this->routes['GET'][$this->normalize($path)] = $action;
    }

    public function post(string $path, array $action): void
    {
        $this->routes['POST'][$this->normalize($path)] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = $this->normalize(parse_url($uri, PHP_URL_PATH) ?? '/');

        foreach ($this->routes[$method] ?? [] as $pattern => $action) {
            $params = $this->match($pattern, $path);

            if ($params !== null) {
                $this->invoke($action, $params);
                return;
            }
        }

        http_response_code(404);
        echo View::render('errors.404', [], null);
    }

    private function match(string $pattern, string $path): ?array
    {
        $patternSegments = explode('/', trim($pattern, '/'));
        $pathSegments = explode('/', trim($path, '/'));

        if (count($patternSegments) !== count($pathSegments)) {
            return null;
        }

        $params = [];

        foreach ($patternSegments as $index => $segment) {
            if (str_starts_with($segment, '{') && str_ends_with($segment, '}')) {
                $params[trim($segment, '{}')] = $pathSegments[$index];
                continue;
            }

            if ($segment !== $pathSegments[$index]) {
                return null;
            }
        }

        return $params;
    }

    private function invoke(array $action, array $params): void
    {
        [$controllerClass, $method] = $action;
        $controller = new $controllerClass();

        echo call_user_func_array([$controller, $method], $params);
    }

    private function normalize(string $path): string
    {
        $normalized = '/' . trim($path, '/');

        return $normalized === '//' ? '/' : $normalized;
    }
}
