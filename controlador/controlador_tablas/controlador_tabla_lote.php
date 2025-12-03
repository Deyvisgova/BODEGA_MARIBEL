<?php
@include '../../modelo/config.php';

$id_lote = isset($_POST['id_lote']) ? $_POST['id_lote'] : "";
$id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : "";
$cantidad_recibida = isset($_POST['cantidad_recibida']) ? (int) $_POST['cantidad_recibida'] : 0;
$fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : "";
$fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : "";

$accionAgregar = "";
$accionModificar = $accionEliminar = $accionCancelar = "disabled";
$mostrarModal = false;

$accion = isset($_POST['accion']) ? $_POST['accion'] : "";

$esAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

$responderJson = function (array $payload, int $codigo = 200) {
    http_response_code($codigo);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
};

function ajustarStock(mysqli $conn, int $productoId, int $diferencia): void {
    if ($productoId <= 0 || $diferencia === 0) {
        return;
    }

    mysqli_query(
        $conn,
        "UPDATE producto SET stock_actual = stock_actual + $diferencia, cantidad = cantidad + $diferencia WHERE id_producto = $productoId"
    );
}

    switch ($accion) {
        case "btnAgregar":
            $insert = "INSERT INTO lote (id_producto, cantidad_recibida, fecha_vencimiento, fecha_ingreso) VALUES ($id_producto, $cantidad_recibida, '$fecha_vencimiento', '$fecha_ingreso')";
            $exito = mysqli_query($conn, $insert);

            if ($exito) {
                ajustarStock($conn, (int) $id_producto, $cantidad_recibida);

                if ($esAjax) {
                    $productoNombre = '';
                    $busqueda = mysqli_query($conn, "SELECT nombre_producto FROM producto WHERE id_producto = $id_producto LIMIT 1");
                    if ($busqueda && mysqli_num_rows($busqueda) === 1) {
                        $productoEncontrado = mysqli_fetch_assoc($busqueda);
                        $productoNombre = $productoEncontrado['nombre_producto'];
                    }

                    $responderJson([
                        'success' => true,
                        'message' => 'Lote creado correctamente.',
                        'id_lote' => mysqli_insert_id($conn),
                        'producto' => $productoNombre,
                        'fecha_vencimiento' => $fecha_vencimiento
                    ]);
                }

                header('location: ../../vista/adm/dashboard/tabla_lote.php');
            } else {
                if ($esAjax) {
                    $responderJson(['success' => false, 'message' => 'No se pudo crear el lote.'], 500);
                }
                header('location: ../../vista/adm/dashboard/tabla_lote.php');
            }
            break;

    case "btnModificar":
        $consultaLote = mysqli_query($conn, "SELECT id_producto, cantidad_recibida FROM lote WHERE id_lote = $id_lote LIMIT 1");
        $loteAnterior = $consultaLote ? mysqli_fetch_assoc($consultaLote) : null;
        $productoAnterior = $loteAnterior ? (int) $loteAnterior['id_producto'] : 0;
        $cantidadAnterior = $loteAnterior ? (int) $loteAnterior['cantidad_recibida'] : 0;

        $update = "UPDATE lote SET id_producto=$id_producto, cantidad_recibida=$cantidad_recibida, fecha_vencimiento='$fecha_vencimiento', fecha_ingreso='$fecha_ingreso' WHERE id_lote='$id_lote'";
        mysqli_query($conn, $update);

        if ($productoAnterior !== (int)$id_producto) {
            ajustarStock($conn, $productoAnterior, -$cantidadAnterior);
            ajustarStock($conn, (int) $id_producto, $cantidad_recibida);
        } else {
            $diferencia = $cantidad_recibida - $cantidadAnterior;
            ajustarStock($conn, (int) $id_producto, $diferencia);
        }

        header('location: ../../vista/adm/dashboard/tabla_lote.php');
        break;

    case "btnEliminar":
        $consultaLote = mysqli_query($conn, "SELECT id_producto, cantidad_recibida FROM lote WHERE id_lote = $id_lote LIMIT 1");
        $lote = $consultaLote ? mysqli_fetch_assoc($consultaLote) : null;
        $producto = $lote ? (int) $lote['id_producto'] : 0;
        $cantidad = $lote ? (int) $lote['cantidad_recibida'] : 0;

        $delete = "DELETE FROM lote WHERE id_lote = '$id_lote'";
        mysqli_query($conn, $delete);
        ajustarStock($conn, $producto, -$cantidad);
        header('location: ../../vista/adm/dashboard/tabla_lote.php');
        break;

    case "btnCancelar":
        header('location: ../../vista/adm/dashboard/tabla_lote.php');
        break;

    case "Seleccionar":
        $accionAgregar = "disabled";
        $accionModificar = $accionEliminar = $accionCancelar = "";
        $mostrarModal = true;
        break;
}
