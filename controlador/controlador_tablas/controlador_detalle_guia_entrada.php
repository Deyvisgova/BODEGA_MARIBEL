<?php
header('Content-Type: application/json');
require_once '../../modelo/config.php';

$payload = json_decode(file_get_contents('php://input'), true);

if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No se recibieron datos para guardar el detalle.']);
    exit;
}

$idGuiaEntrada = isset($payload['id_guia_entrada']) ? (int) $payload['id_guia_entrada'] : 0;
$idProducto = isset($payload['id_producto']) ? (int) $payload['id_producto'] : 0;
$cantidad = isset($payload['cantidad_entrada']) ? (int) $payload['cantidad_entrada'] : 0;
$idLote = isset($payload['id_lote']) ? (int) $payload['id_lote'] : 0;
$fechaVencimiento = isset($payload['fecha_vencimiento']) ? trim($payload['fecha_vencimiento']) : '';
$precioUnitario = isset($payload['precio_unitario']) ? (float) $payload['precio_unitario'] : 0;

if (
    $idGuiaEntrada <= 0 ||
    $idProducto <= 0 ||
    $cantidad <= 0 ||
    $idLote <= 0 ||
    $fechaVencimiento === '' ||
    $precioUnitario <= 0
) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios para registrar el detalle.']);
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    'INSERT INTO guia_de_entrada_detalle (id_guia_entrada, id_producto, cantidad_entrada, id_lote, fecha_vencimiento, precio_unitario) VALUES (?, ?, ?, ?, ?, ?)'
);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo preparar el registro del detalle.',
        'error' => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    'iiiisd',
    $idGuiaEntrada,
    $idProducto,
    $cantidad,
    $idLote,
    $fechaVencimiento,
    $precioUnitario
);
$exito = mysqli_stmt_execute($stmt);

if ($exito) {
    // 1. Actualizar la cantidad recibida en el lote
    $updateLote = "UPDATE lote SET cantidad_recibida = cantidad_recibida + $cantidad WHERE id_lote = $idLote";
    mysqli_query($conn, $updateLote);

    // 2. Actualizar el stock del producto
    $updateProducto = "UPDATE producto SET stock_actual = stock_actual + $cantidad, cantidad = cantidad + $cantidad WHERE id_producto = $idProducto";
    mysqli_query($conn, $updateProducto);

    echo json_encode(['success' => true, 'message' => 'Detalle guardado y stock actualizado correctamente.']);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'No se pudo guardar el detalle. Verifica los datos e intenta nuevamente.',
        'error' => mysqli_error($conn)
    ]);
}

mysqli_stmt_close($stmt);
?>