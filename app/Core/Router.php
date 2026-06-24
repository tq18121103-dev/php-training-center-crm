<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];

            $controllerInstance = new $controller();
            $controllerInstance->$action();

            return;
        }

        if ($this->pathExists($path)) {
            http_response_code(405);
            view('errors/405');
            return;
        }

        http_response_code(404);
        view('errors/404');
    }

    private function pathExists(string $path): bool
    {
        foreach ($this->routes as $methodRoutes) {
            if (isset($methodRoutes[$path])) {
                return true;
            }
        }

        return false;
    }
}