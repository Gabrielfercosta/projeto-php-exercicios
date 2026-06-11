<?php
declare(strict_types=1);

namespace App\Http;

class Router{
    private array $routes = [];

    public function get(string $path, callable $handler): void{
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void{
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler): void{
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable $handler): void{
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? '/';

        foreach ($this->routes[$method] as $route => $handler) {
            $pattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $route);
            if (preg_match("#^{$pattern}$#", $path, $matches)) {
                [$controller, $action] = $handler;
                array_shift($matches); 
                echo json_encode($controller->$action($matches));
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }

}