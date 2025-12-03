<?php
header('Content-Type: application/json');
require_once '../../modelo/config.php';

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

// Obtener datos del formulario
$idProducto = isset($_POST['id_producto']) ? (int) $_POST['id_producto'] : 0;
$fechaVencimiento = isset($_POST['fecha_vencimiento']) ? $_POST['fecha_vencimiento'] : '';
$fechaIngreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';

// Validar datos básicos
if ($idProducto <= 0 || empty($fechaVencimiento) || empty($fechaIngreso)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios.']);
    exit;
}

// Insertar el nuevo lote con cantidad_recibida = 0
// La cantidad real se sumará cuando se guarde el detalle de la guía de entrada
$query = "INSERT INTO lote (id_producto, cantidad_recibida, cantidad_disponible, fecha_vencimiento, fecha_ingreso) VALUES (?, 0, 0, ?, ?)";
$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'iss', $idProducto, $fechaVencimiento, $fechaIngreso);

    if (mysqli_stmt_execute($stmt)) {
        $idLote = mysqli_insert_id($conn);

        // Obtener nombre del producto para la respuesta
        $queryProd = "SELECT nombre_producto FROM producto WHERE id_producto = $idProducto";
        $resultProd = mysqli_query($conn, $queryProd);
        $rowProd = mysqli_fetch_assoc($resultProd);
        $nombreProducto = $rowProd ? $rowProd['nombre_producto'] : 'Producto desconocido';

        echo json_encode([
            'success' => true,
            'message' => 'Lote creado correctamente.',
            'id_lote' => $idLote,
            'nombre_producto' => $nombreProducto,
            'fecha_vencimiento' => $fechaVencimiento
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al crear el lote: ' . mysqli_error($conn)]);
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . mysqli_error($conn)]);
}
?>