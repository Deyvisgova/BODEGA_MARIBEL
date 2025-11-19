<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../modelo/conexion.php';

class ProductoController extends Controller
{
    private PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->Conexion();
    }

    public function index(): void
    {
        $consulta = $this->conexion->prepare('SELECT id_producto, nombre_producto, descripcion_producto, precio_producto FROM producto WHERE activo = 1');
        $consulta->execute();
        $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->render(__DIR__ . '/../vista/productos/listado.php', [
            'productos' => $productos,
        ]);
    }
}
