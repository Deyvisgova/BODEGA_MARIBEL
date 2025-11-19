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
            'SELECT nombre_producto AS nombre, cantidad FROM producto ORDER BY nombre_producto'
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
