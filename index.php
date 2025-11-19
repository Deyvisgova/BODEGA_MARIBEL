<?php
declare(strict_types=1);

require_once __DIR__ . '/controlador/Router.php';
require_once __DIR__ . '/controlador/HomeController.php';
require_once __DIR__ . '/controlador/ProductoController.php';
require_once __DIR__ . '/controlador/AdminController.php';

$router = new Router();
$router->get('inicio', [HomeController::class, 'index']);
$router->get('productos', [ProductoController::class, 'index']);
$router->get('admin/dashboard', [AdminController::class, 'dashboard']);

$rutaSolicitada = $_GET['ruta'] ?? 'inicio';
$router->dispatch($rutaSolicitada, $_SERVER['REQUEST_METHOD'] ?? 'GET');
