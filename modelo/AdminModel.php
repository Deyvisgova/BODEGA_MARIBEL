<?php
require_once __DIR__ . '/Modelo.php';

class AdminModel extends Modelo
{
    public function obtenerResumenTablas(): array
    {
        $tablas = [
            'administradores' => ['tabla' => 'administrador', 'columna' => 'id_adm'],
            'proveedores' => ['tabla' => 'provedor', 'columna' => 'id_provedor'],
            'categorias' => ['tabla' => 'categoria', 'columna' => 'id_categoria'],
            'colaboradores' => ['tabla' => 'colaborador', 'columna' => 'id_colab'],
            'productos' => ['tabla' => 'producto', 'columna' => 'id_producto'],
        ];

        $resumen = [];
        foreach ($tablas as $clave => $info) {
            $stmt = $this->conexion->query(
                sprintf('SELECT COUNT(%s) AS total FROM %s', $info['columna'], $info['tabla'])
            );
            $resumen[$clave] = (int) $stmt->fetchColumn();
        }

        return $resumen;
    }

    public function obtenerProductosInventario(): array
    {
        $stmt = $this->conexion->query(
            'SELECT nombre_producto AS nombre, stock_actual AS cantidad FROM producto ORDER BY nombre_producto'
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAlertas(): array
    {
        $bajoStock = $this->conexion->query(
            'SELECT id_producto, nombre_producto, stock_actual
             FROM producto
             WHERE stock_actual < 10
             ORDER BY stock_actual ASC, nombre_producto'
        )->fetchAll(PDO::FETCH_ASSOC);

        $proximosVencimientos = $this->conexion->query(
            "SELECT l.id_lote, l.fecha_vencimiento, l.fecha_ingreso, p.nombre_producto
             FROM lote l
             INNER JOIN producto p ON p.id_producto = l.id_producto
             WHERE l.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
             ORDER BY l.fecha_vencimiento ASC"
        )->fetchAll(PDO::FETCH_ASSOC);

        return [
            'bajoStock' => $bajoStock,
            'vencimientos' => $proximosVencimientos,
        ];
    }

    public function obtenerSalidasPorFecha(): array
    {
        return $this->obtenerMovimientosAgrupados(
            'guia_de_salida',
            'fecha_salida',
            'cantidad_salida'
        );
    }

    public function obtenerEntradasPorFecha(): array
    {
        return $this->obtenerMovimientosAgrupados(
            'guia_de_entrada',
            'fecha_entrada',
            'cantidad_entrada'
        );
    }

    private function obtenerMovimientosAgrupados(string $tabla, string $columnaFecha, string $columnaCantidad): array
    {
        $productos = $this->conexion
            ->query(sprintf('SELECT DISTINCT producto FROM %s ORDER BY producto', $tabla))
            ->fetchAll(PDO::FETCH_COLUMN);

        $stmt = $this->conexion->query(
            sprintf(
                'SELECT %1$s AS fecha, producto, SUM(%2$s) AS cantidad
                FROM %3$s
                GROUP BY %1$s, producto
                ORDER BY %1$s',
                $columnaFecha,
                $columnaCantidad,
                $tabla
            )
        );

        $valores = [];
        $fechas = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fechaNormalizada = (new DateTime($fila['fecha']))->format('Y-m-d');
            $valores[$fechaNormalizada][$fila['producto']] = (int) $fila['cantidad'];
            $fechas[$fechaNormalizada] = true;
        }

        $fechasOrdenadas = array_keys($fechas);
        sort($fechasOrdenadas);

        return [
            'productos' => $productos,
            'fechas' => $fechasOrdenadas,
            'valores' => $valores,
        ];
    }
}
