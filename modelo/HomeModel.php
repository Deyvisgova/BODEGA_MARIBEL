<?php
require_once __DIR__ . '/Modelo.php';

class HomeModel extends Modelo
{
    public function obtenerCategoriasPrincipales(): array
    {
        $consulta = $this->conexion->query(
            "SELECT TRIM(categoria) AS categoria, COUNT(*) AS total_productos, SUM(stock_actual) AS total_unidades
             FROM producto
             WHERE activo = 'activo'
             GROUP BY TRIM(categoria)
             ORDER BY total_productos DESC"
        );

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerProductosDestacados(int $limite = 3): array
    {
        $consulta = $this->conexion->prepare(
            "SELECT id_producto, nombre_producto, precio_producto, stock_actual AS cantidad, descripcion, categoria
             FROM producto
             WHERE activo = 'activo'
             ORDER BY stock_actual DESC
             LIMIT :limite"
        );
        $consulta->bindValue(':limite', $limite, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerResumenInventario(): array
    {
        $consulta = $this->conexion->query(
            "SELECT COUNT(*) AS total_productos,
                    SUM(stock_actual) AS total_unidades,
                    SUM(precio_producto * stock_actual) AS valor_estimado
             FROM producto
             WHERE activo = 'activo'"
        );

        $resumen = $consulta->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'total_productos' => (int) ($resumen['total_productos'] ?? 0),
            'total_unidades' => (int) ($resumen['total_unidades'] ?? 0),
            'valor_estimado' => (float) ($resumen['valor_estimado'] ?? 0),
        ];
    }

    public function obtenerServicios(): array
    {
        return [
            'Recepción y control de mercadería',
            'Inventarios cíclicos semanales',
            'Preparación de pedidos y picking',
            'Distribución a puntos de venta de Bodega Maribel',
        ];
    }

    public function obtenerHorarios(): array
    {
        return [
            'Lunes a Viernes' => '08:00 - 20:00 hrs',
            'Sábados' => '09:00 - 18:00 hrs',
            'Domingos' => '10:00 - 14:00 hrs',
        ];
    }

    public function obtenerContacto(): array
    {
        return [
            'telefono' => '+51 913 123 456',
            'correo' => 'logistica@bodegamaribel.com',
            'direccion' => 'Av. San Martín 123, Lima, Perú',
        ];
    }
}
