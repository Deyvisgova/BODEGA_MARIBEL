<?php
class Router
{
    private array $routes = [];

    public function get(string $route, $action): void
    {
        $this->routes['GET'][$this->normalize($route)] = $action;
    }

    public function dispatch(?string $route, string $method = 'GET'): void
    {
        $method = strtoupper($method);
        $normalizedRoute = $this->normalize($route);
        $action = $this->routes[$method][$normalizedRoute] ?? null;

        if ($action === null) {
            http_response_code(404);
            echo '<h1>Error 404</h1><p>Ruta no encontrada.</p>';
            return;
        }

        $this->invoke($action);
    }

    private function normalize(?string $route): string
    {
        if ($route === null) {
            return 'inicio';
        }

        $route = trim($route);
        $route = trim($route, "/\\");

        return $route === '' ? 'inicio' : $route;
    }

    private function invoke($action): void
    {
        if (is_array($action)) {
            $controller = $action[0];
            $method = $action[1] ?? null;

            if (is_string($controller) && class_exists($controller)) {
                $controller = new $controller();
            }

            if (!is_object($controller) || !method_exists($controller, $method)) {
                throw new RuntimeException('Controlador o método inválido.');
            }

            $controller->$method();
            return;
        }

        if (!is_callable($action)) {
            throw new RuntimeException('Ruta mal configurada.');
        }

        call_user_func($action);
    }
}
