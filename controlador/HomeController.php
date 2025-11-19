<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../modelo/HomeModel.php';

class HomeController extends Controller
{
    private HomeModel $model;

    public function __construct()
    {
        $this->model = new HomeModel();
    }

    public function index(): void
    {
        $this->render(__DIR__ . '/../vista/home/index.php', [
            'categorias' => $this->model->obtenerCategoriasPrincipales(),
            'productosDestacados' => $this->model->obtenerProductosDestacados(),
            'resumenInventario' => $this->model->obtenerResumenInventario(),
            'servicios' => $this->model->obtenerServicios(),
            'horarios' => $this->model->obtenerHorarios(),
            'contacto' => $this->model->obtenerContacto(),
        ]);
    }
}
