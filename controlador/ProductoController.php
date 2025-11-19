<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../modelo/ProductoModel.php';

class ProductoController extends Controller
{
    private ProductoModel $model;

    public function __construct()
    {
        $this->model = new ProductoModel();
    }

    public function index(): void
    {
        $productos = $this->model->obtenerActivos();

        $this->render(__DIR__ . '/../vista/productos/listado.php', [
            'productos' => $productos,
        ]);
    }
}
