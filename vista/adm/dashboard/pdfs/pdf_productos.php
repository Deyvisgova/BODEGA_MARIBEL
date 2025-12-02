<?php

require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');


$consulta = "SELECT * FROM producto";
$resultado = $conn->query($consulta);

$pdf = new PDF("P","mm", array(400,400));   
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Ln(10);

$pdf->Cell(45, 5,  mb_convert_encoding('Reporte de Tabla Productos', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
$pdf->Image('../img/Makro_logo.png', 320, 5, 40);

$pdf->Ln(10);

$pdf->Cell(25,5,"ID",1,0,"C");
$pdf->Cell(85,5,"Nombre",1,0,"C");
$pdf->Cell(70,5,"Cantidad",1,0,"C");
$pdf->Cell(65,5,"precio",1,0,"C");
$pdf->Cell(30,5,"Categoria",1,0,"C");
$pdf->Cell(25,5,"Activo",1,0,"C");
$pdf->Cell(20,5,"Provedor",1,1,"C");


$pdf->SetFont("Arial", "B", 9);

while ($fila = $resultado->fetch_assoc()){
    $pdf->Cell(25,5,$fila['id_producto'],1,0,"C");
    $pdf->Cell(85,5,$fila['nombre_producto'],1,0,"C");
    $pdf->Cell(70,5,strip_tags($fila[utf8_decode('cantidad')]),1,0,"B");
    $pdf->Cell(65,5,$fila['precio_producto'],1,0,"C");
    $pdf->Cell(30,5,$fila[utf8_decode('categoria')],1,0,"C");
    $pdf->Cell(25,5,$fila[utf8_decode('activo')],1,0,"C");
    $pdf->Cell(20,5,$fila['provedor'],1,1,"C");
}



$pdf->Output('I', 'reporte_productos.pdf');
?>