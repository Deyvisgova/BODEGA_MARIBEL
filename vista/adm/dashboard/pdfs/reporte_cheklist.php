<?php
require('../../../../controlador/fpdf/plantilla_colab.php');
require('../../../../modelo/config.php');

// Obtener el nombre del producto desde el parámetro GET
$nombre_producto = isset($_GET['nombre_producto']) ? urldecode($_GET['nombre_producto']) : null;

// Consultar la base de datos para obtener la información de los productos
$query = "SELECT * FROM producto WHERE nombre_producto LIKE '%$nombre_producto%'";
$resultado = $conn->query($query);

if ($resultado && $resultado->num_rows > 0) {
    $pdf = new PDF("L", "mm", array(300, 320));
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 9);

    $pdf->Ln(10);

    $pdf->Cell(45, 5, mb_convert_encoding('Reporte de Productos', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
    $pdf->Image('../img/Makro_logo.png', 250, 5, 40);

    $pdf->Ln(10);

    $pdf->Cell(25, 5, "ID Producto", 1, 0, "C");
    $pdf->Cell(40, 5, "Nombre", 1, 0, "C");
    $pdf->Cell(30, 5, "Cantidad", 1, 0, "C");
    $pdf->Cell(30, 5, "Precio", 1, 0, "C");
    $pdf->Cell(40, 5, "Categoría", 1, 0, "C");
    $pdf->Cell(20, 5, "Activo", 1, 1, "C");

    $pdf->SetFont("Arial", "B", 9);

    while ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(25, 5, $fila['id_producto'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['nombre_producto'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['cantidad'], 1, 0, "C");
        $pdf->Cell(30, 5, $fila['precio_producto'], 1, 0, "C");
        $pdf->Cell(40, 5, $fila['categoria'], 1, 0, "C");
        $pdf->Cell(20, 5, $fila['activo'], 1, 1, "C");
    }

    $pdf->Output();
} else {
    echo "No se encontraron productos con el nombre proporcionado.";
}
?>
