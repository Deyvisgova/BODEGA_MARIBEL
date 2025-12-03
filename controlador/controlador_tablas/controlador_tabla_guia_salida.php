<?php
@include '../../modelo/config.php';
require_once __DIR__ . '/../kardex_helper.php';

$crearTabla = function (string $sql) use ($conn) {
    mysqli_query($conn, $sql);
};

function asegurarTablaGuiaSalida(mysqli $conn, callable $crearTabla): void
{
    $existe = mysqli_query($conn, "SHOW TABLES LIKE 'guia_de_salida'");
    if ($existe && mysqli_num_rows($existe) > 0) {
        return;
    }

    $crearTabla("CREATE TABLE IF NOT EXISTS guia_de_salida (
        id_guia_salida INT(20) NOT NULL AUTO_INCREMENT,
        fecha_salida DATE NOT NULL,
        descripcion VARCHAR(200) NOT NULL,
        cantidad_salida INT(11) NOT NULL,
        producto VARCHAR(200) NOT NULL,
        destino VARCHAR(50) NOT NULL,
        encargado VARCHAR(50) NOT NULL,
        activo VARCHAR(20) NOT NULL,
        numero_documento VARCHAR(30) DEFAULT NULL,
        domicilio_fiscal VARCHAR(255) DEFAULT NULL,
        fecha_inicio_traslado DATE DEFAULT NULL,
        destinatario VARCHAR(150) DEFAULT NULL,
        ruc_dni_destinatario VARCHAR(30) DEFAULT NULL,
        punto_partida VARCHAR(150) DEFAULT NULL,
        punto_llegada VARCHAR(150) DEFAULT NULL,
        motivo_traslado VARCHAR(60) DEFAULT NULL,
        modalidad_transporte VARCHAR(30) DEFAULT NULL,
        marca_placa VARCHAR(60) DEFAULT NULL,
        licencia_conducir VARCHAR(60) DEFAULT NULL,
        ruc_transporte VARCHAR(30) DEFAULT NULL,
        denominacion_conductor VARCHAR(150) DEFAULT NULL,
        PRIMARY KEY (id_guia_salida)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}

function asegurarTablaDetalleGuiaSalida(mysqli $conn, callable $crearTabla): void
{
    $existe = mysqli_query($conn, "SHOW TABLES LIKE 'guia_de_salida_detalle'");
    if ($existe && mysqli_num_rows($existe) > 0) {
        return;
    }

    $crearTabla("CREATE TABLE IF NOT EXISTS guia_de_salida_detalle (
        id_detalle_salida INT(11) NOT NULL AUTO_INCREMENT,
        id_guia_salida INT(11) NOT NULL,
        id_producto INT(11) NOT NULL,
        id_lote INT(11) NOT NULL,
        descripcion VARCHAR(255) NOT NULL,
        cantidad INT(11) NOT NULL,
        unidad_medida VARCHAR(50) DEFAULT NULL,
        peso_total DECIMAL(10,2) DEFAULT NULL,
        PRIMARY KEY (id_detalle_salida),
        KEY idx_guia_salida (id_guia_salida),
        CONSTRAINT fk_detalle_salida_guia FOREIGN KEY (id_guia_salida) REFERENCES guia_de_salida(id_guia_salida) ON UPDATE CASCADE ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
}

asegurarTablaGuiaSalida($conn, $crearTabla);
asegurarTablaDetalleGuiaSalida($conn, $crearTabla);

$id_guia_salida = (isset($_POST['id_guia_salida'])) ? $_POST['id_guia_salida'] : "";
$fecha_salida = (isset($_POST['fecha_salida'])) ? $_POST['fecha_salida'] : "";
$descripcion = (isset($_POST['descripcion'])) ? mysqli_real_escape_string($conn, $_POST['descripcion']) : "";
$destino = (isset($_POST['destino'])) ? mysqli_real_escape_string($conn, $_POST['destino']) : "";
$encargado = (isset($_POST['encargado'])) ? mysqli_real_escape_string($conn, $_POST['encargado']) : "";
$activo = (isset($_POST['activo'])) ? $_POST['activo'] : "pendiente";

$numero_documento = (isset($_POST['numero_documento'])) ? mysqli_real_escape_string($conn, $_POST['numero_documento']) : "";
$domicilio_fiscal = (isset($_POST['domicilio_fiscal'])) ? mysqli_real_escape_string($conn, $_POST['domicilio_fiscal']) : "";
$fecha_inicio_traslado = (isset($_POST['fecha_inicio_traslado'])) ? $_POST['fecha_inicio_traslado'] : null;
$destinatario = (isset($_POST['destinatario'])) ? mysqli_real_escape_string($conn, $_POST['destinatario']) : "";
$ruc_dni_destinatario = (isset($_POST['ruc_dni_destinatario'])) ? mysqli_real_escape_string($conn, $_POST['ruc_dni_destinatario']) : "";
$punto_partida = (isset($_POST['punto_partida'])) ? mysqli_real_escape_string($conn, $_POST['punto_partida']) : "";
$punto_llegada = (isset($_POST['punto_llegada'])) ? mysqli_real_escape_string($conn, $_POST['punto_llegada']) : "";
$motivo_traslado = (isset($_POST['motivo_traslado'])) ? mysqli_real_escape_string($conn, $_POST['motivo_traslado']) : "";
$modalidad_transporte = (isset($_POST['modalidad_transporte'])) ? mysqli_real_escape_string($conn, $_POST['modalidad_transporte']) : "";
$marca_placa = (isset($_POST['marca_placa'])) ? mysqli_real_escape_string($conn, $_POST['marca_placa']) : "";
$licencia_conducir = (isset($_POST['licencia_conducir'])) ? mysqli_real_escape_string($conn, $_POST['licencia_conducir']) : "";
$ruc_transporte = (isset($_POST['ruc_transporte'])) ? mysqli_real_escape_string($conn, $_POST['ruc_transporte']) : "";
$denominacion_conductor = (isset($_POST['denominacion_conductor'])) ? mysqli_real_escape_string($conn, $_POST['denominacion_conductor']) : "";

$detalleProductos = isset($_POST['detalle_producto']) ? $_POST['detalle_producto'] : [];
$detalleCantidades = isset($_POST['detalle_cantidad']) ? $_POST['detalle_cantidad'] : [];
$detalleLotes = isset($_POST['detalle_lote']) ? $_POST['detalle_lote'] : [];
$detalleUnidades = isset($_POST['detalle_unidad']) ? $_POST['detalle_unidad'] : [];
$detallePesos = isset($_POST['detalle_peso']) ? $_POST['detalle_peso'] : [];
$detalleDescripciones = isset($_POST['detalle_descripcion']) ? $_POST['detalle_descripcion'] : [];

$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

function obtenerNombreProducto(mysqli $conn, int $productoId): string
{
    $consulta = mysqli_query($conn, "SELECT nombre_producto FROM producto WHERE id_producto = $productoId LIMIT 1");
    if ($consulta && mysqli_num_rows($consulta) > 0) {
        $registro = mysqli_fetch_assoc($consulta);
        return $registro['nombre_producto'] ?? '';
    }

    return '';
}

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
switch ($accion) {
    case "btnAgregar":
        if (empty($detalleProductos)) {
            echo "<script>alert('Agrega al menos un producto en el detalle.'); window.location='../../vista/adm/dashboard/tabla_guia_salida.php';</script>";
            exit;
        }

        $totalCantidad = 0;
        $primerProductoNombre = '';
        foreach ($detalleProductos as $index => $productoId) {
            $cantidadDetalle = isset($detalleCantidades[$index]) ? (int) $detalleCantidades[$index] : 0;
            $totalCantidad += $cantidadDetalle;
            if ($primerProductoNombre === '') {
                $primerProductoNombre = obtenerNombreProducto($conn, (int) $productoId);
            }
        }

        mysqli_begin_transaction($conn);

        $insert = "INSERT INTO guia_de_salida(fecha_salida, descripcion, cantidad_salida, producto, destino, encargado, activo, " .
            "numero_documento, domicilio_fiscal, fecha_inicio_traslado, destinatario, ruc_dni_destinatario, punto_partida, punto_llegada, motivo_traslado, modalidad_transporte, marca_placa, licencia_conducir, ruc_transporte, denominacion_conductor) " .
            "VALUES ('$fecha_salida', '$descripcion', $totalCantidad, '" . mysqli_real_escape_string($conn, $primerProductoNombre) . "', '$destino', '$encargado', '$activo', " .
            "'$numero_documento', '$domicilio_fiscal', " . ($fecha_inicio_traslado ? "'$fecha_inicio_traslado'" : "NULL") . ", '$destinatario', '$ruc_dni_destinatario', '$punto_partida', '$punto_llegada', '$motivo_traslado', '$modalidad_transporte', '$marca_placa', '$licencia_conducir', '$ruc_transporte', '$denominacion_conductor')";

        $guiaInsertada = mysqli_query($conn, $insert);

        if (!$guiaInsertada) {
            mysqli_rollback($conn);
            echo "<script>alert('No se pudo registrar la guía de salida.'); window.location='../../vista/adm/dashboard/tabla_guia_salida.php';</script>";
            exit;
        }

        $guiaId = mysqli_insert_id($conn);

        foreach ($detalleProductos as $index => $productoId) {
            $productoId = (int) $productoId;
            $cantidadDetalle = isset($detalleCantidades[$index]) ? (int) $detalleCantidades[$index] : 0;
            $loteId = isset($detalleLotes[$index]) ? (int) $detalleLotes[$index] : 0;
            $unidad = isset($detalleUnidades[$index]) ? mysqli_real_escape_string($conn, $detalleUnidades[$index]) : '';
            $peso = isset($detallePesos[$index]) ? (float) $detallePesos[$index] : 0;
            $descripcionDetalle = isset($detalleDescripciones[$index]) ? mysqli_real_escape_string($conn, $detalleDescripciones[$index]) : '';
            $nombreProducto = obtenerNombreProducto($conn, $productoId);

            if ($cantidadDetalle <= 0 || $productoId <= 0 || $loteId <= 0) {
                continue;
            }

            $consultaLote = mysqli_query($conn, "SELECT cantidad_disponible FROM lote WHERE id_lote = $loteId AND id_producto = $productoId FOR UPDATE");
            if (!$consultaLote || mysqli_num_rows($consultaLote) === 0) {
                mysqli_rollback($conn);
                echo "<script>alert('No se encontró el lote seleccionado para el producto.'); window.location='../../vista/adm/dashboard/tabla_guia_salida.php';</script>";
                exit;
            }

            $loteInfo = mysqli_fetch_assoc($consultaLote);
            if ((int) $loteInfo['cantidad_disponible'] < $cantidadDetalle) {
                mysqli_rollback($conn);
                echo "<script>alert('Stock insuficiente en el lote seleccionado.'); window.location='../../vista/adm/dashboard/tabla_guia_salida.php';</script>";
                exit;
            }

            mysqli_query($conn, "UPDATE lote SET cantidad_disponible = cantidad_disponible - $cantidadDetalle WHERE id_lote = $loteId");

            registrarKardex(
                $conn,
                $fecha_salida,
                $nombreProducto,
                'salida',
                (int) $cantidadDetalle,
                $descripcion,
                'GS-' . $guiaId
            );

            mysqli_query($conn, "INSERT INTO guia_de_salida_detalle (id_guia_salida, id_producto, id_lote, descripcion, cantidad, unidad_medida, peso_total) " .
                "VALUES ($guiaId, $productoId, $loteId, '$descripcionDetalle', $cantidadDetalle, '$unidad', $peso)");
        }

        mysqli_commit($conn);
        header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
        break;

    case "btnModificar":
        $update = "UPDATE guia_de_salida SET fecha_salida='$fecha_salida',descripcion='$descripcion',destino='$destino',encargado='$encargado', activo='$activo', numero_documento='$numero_documento', domicilio_fiscal='$domicilio_fiscal', fecha_inicio_traslado=" . ($fecha_inicio_traslado ? "'$fecha_inicio_traslado'" : "NULL") . ", destinatario='$destinatario', ruc_dni_destinatario='$ruc_dni_destinatario', punto_partida='$punto_partida', punto_llegada='$punto_llegada', motivo_traslado='$motivo_traslado', modalidad_transporte='$modalidad_transporte', marca_placa='$marca_placa', licencia_conducir='$licencia_conducir', ruc_transporte='$ruc_transporte', denominacion_conductor='$denominacion_conductor' WHERE id_guia_salida='$id_guia_salida'";
        mysqli_query($conn, $update);

        header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
        break;
    case "btnEliminar":
        $delete = "DELETE FROM guia_de_salida WHERE id_guia_salida = '$id_guia_salida'";
        mysqli_query($conn, $delete);
        header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
        break;
    case "btnCancelar":
        header('location: ../../vista/adm/dashboard/tabla_guia_salida.php');
        break;

    case "Seleccionar":
        $pass = "disabled";
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal = true;
        break;
}
?>