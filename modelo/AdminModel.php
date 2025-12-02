<?php
require_once __DIR__ . '/Modelo.php';

class AdminModel extends Modelo
{
    public function __construct()
    {
        parent::__construct();

        $this->asegurarEstructuraInventario();
    }

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
             WHERE stock_actual <= 10
             ORDER BY stock_actual ASC, nombre_producto'
        )->fetchAll(PDO::FETCH_ASSOC);

        $proximosVencimientos = [];
        if ($this->tablaExiste('lote')) {
            $proximosVencimientos = $this->conexion->query(
                "SELECT l.id_lote, l.fecha_vencimiento, l.fecha_ingreso, p.nombre_producto
                 FROM lote l
                 INNER JOIN producto p ON p.id_producto = l.id_producto
                 WHERE l.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 20 DAY)
                 ORDER BY l.fecha_vencimiento ASC"
            )->fetchAll(PDO::FETCH_ASSOC);
        }

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

    private function asegurarEstructuraInventario(): void
    {
        $schema = $this->conexion->query('SELECT DATABASE()')->fetchColumn();

        if (!$this->columnaExiste('descripcion', $schema)) {
            $this->conexion->exec("ALTER TABLE producto ADD COLUMN descripcion VARCHAR(255) NOT NULL DEFAULT '' AFTER nombre_producto");
        }

        if (!$this->columnaExiste('stock_actual', $schema)) {
            $this->conexion->exec("ALTER TABLE producto ADD COLUMN stock_actual INT(11) NOT NULL DEFAULT 0 AFTER descripcion");
            $this->conexion->exec('UPDATE producto SET stock_actual = cantidad');
        }

        if (!$this->tablaExiste('lote', $schema)) {
            $this->conexion->exec(
                "CREATE TABLE lote (
                    id_lote INT NOT NULL AUTO_INCREMENT,
                    id_producto INT NOT NULL,
                    cantidad_recibida INT NOT NULL DEFAULT 0,
                    fecha_vencimiento DATE NOT NULL,
                    fecha_ingreso DATE NOT NULL DEFAULT (CURRENT_DATE),
                    PRIMARY KEY (id_lote),
                    KEY idx_lote_producto (id_producto),
                    CONSTRAINT fk_lote_producto FOREIGN KEY (id_producto) REFERENCES producto (id_producto) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
            );
        }
    }

    private function tablaExiste(string $tabla, ?string $schema = null): bool
    {
        $schema = $schema ?: $this->conexion->query('SELECT DATABASE()')->fetchColumn();

        $consulta = $this->conexion->prepare(
            'SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = :tabla'
        );
        $consulta->execute([
            ':schema' => $schema,
            ':tabla' => $tabla,
        ]);

        return (bool) $consulta->fetchColumn();
    }

    private function columnaExiste(string $columna, string $schema): bool
    {
        $consulta = $this->conexion->prepare(
            'SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :schema AND TABLE_NAME = "producto" AND COLUMN_NAME = :columna'
        );
        $consulta->execute([
            ':schema' => $schema,
            ':columna' => $columna,
        ]);

        return (bool) $consulta->fetchColumn();
    }
}
