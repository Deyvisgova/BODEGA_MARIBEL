<?php
require_once __DIR__ . '/Modelo.php';

class ProductoModel extends Modelo
{
    public function obtenerActivos(): array
    {
        $consulta = $this->conexion->prepare(
            'SELECT id_producto, nombre_producto, precio_producto, categoria, stock_actual AS cantidad, descripcion
             FROM producto
             WHERE activo = :activo'
        );
        $consulta->execute(['activo' => 'activo']);

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
