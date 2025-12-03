<?php
@header('Content-Type: application/json');
@include '../../modelo/config.php';

$idProducto = isset($_GET['id_producto']) ? (int) $_GET['id_producto'] : 0;

if (!$conn || $idProducto <= 0) {
    echo json_encode(['error' => 'Parámetros inválidos']);
    exit;
}

$sql = "SELECT id_lote, fecha_vencimiento, cantidad_disponible " .
    "FROM lote WHERE id_producto = $idProducto AND cantidad_disponible > 0 " .
    "ORDER BY fecha_vencimiento ASC LIMIT 1";
$resultado = mysqli_query($conn, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $lote = mysqli_fetch_assoc($resultado);
    echo json_encode([
        'id_lote' => (int) $lote['id_lote'],
        'fecha_vencimiento' => $lote['fecha_vencimiento'],
        'cantidad_disponible' => (int) $lote['cantidad_disponible'],
    ]);
    exit;
}

echo json_encode(['id_lote' => null]);
