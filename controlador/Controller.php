<?php
abstract class Controller
{
    protected function render(string $viewPath, array $data = []): void
    {
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo '<h1>Error 500</h1><p>Vista no encontrada.</p>';
            return;
        }

        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        require $viewPath;
    }
}
