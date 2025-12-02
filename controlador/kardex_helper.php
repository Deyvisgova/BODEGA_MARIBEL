<?php
function obtenerSaldoProducto(mysqli $conn, string $producto): int
{
    $productoSeguro = mysqli_real_escape_string($conn, $producto);
    $consulta = mysqli_query(
        $conn,
        "SELECT stock_actual, cantidad FROM producto WHERE nombre_producto = '$productoSeguro' LIMIT 1"
    );

    if ($consulta && mysqli_num_rows($consulta) > 0) {
        $registro = mysqli_fetch_assoc($consulta);
        return (int) ($registro['stock_actual'] ?? $registro['cantidad']);
    }

    return 0;
}

function actualizarSaldoProducto(mysqli $conn, string $producto, int $cantidad, string $tipo): int
{
    $productoSeguro = mysqli_real_escape_string($conn, $producto);
    $saldoActual = obtenerSaldoProducto($conn, $productoSeguro);

    if ($tipo === 'entrada') {
        $nuevoSaldo = $saldoActual + $cantidad;
    } else {
        $nuevoSaldo = max(0, $saldoActual - $cantidad);
    }

    mysqli_query(
        $conn,
        "UPDATE producto SET stock_actual = $nuevoSaldo, cantidad = $nuevoSaldo WHERE nombre_producto = '$productoSeguro'"
    );

    return $nuevoSaldo;
}

function registrarKardex(
    mysqli $conn,
    string $fecha,
    string $producto,
    string $tipo,
    int $cantidad,
    string $descripcion,
    string $referencia
): void {
    $descripcionSegura = mysqli_real_escape_string($conn, $descripcion);
    $referenciaSegura = mysqli_real_escape_string($conn, $referencia);
    $productoSeguro = mysqli_real_escape_string($conn, $producto);

    $saldo = actualizarSaldoProducto($conn, $productoSeguro, $cantidad, $tipo);

    mysqli_query(
        $conn,
        "INSERT INTO kardex (fecha, producto, tipo, descripcion, cantidad, saldo, referencia) " .
        "VALUES ('$fecha', '$productoSeguro', '$tipo', '$descripcionSegura', $cantidad, $saldo, '$referenciaSegura')"
    );
}
