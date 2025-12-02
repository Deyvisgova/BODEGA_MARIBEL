<?php

require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');


$consulta = "SELECT * FROM guia_de_salida";
$resultado = $conn->query($consulta);

$pdf = new PDF("L","mm", array(300,320));   
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Ln(10);

$pdf->Cell(45, 5,  mb_convert_encoding('Reporte de Tabla Productos', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
$pdf->Image('../img/Makro_logo.png', 250, 5, 40);

$pdf->Ln(10);

$pdf->Cell(25,5,"Id Guia de Salida",1,0,"C");
$pdf->Cell(40,5,"Fecha",1,0,"C");
$pdf->Cell(70,5,"Descripcion ",1,0,"C");
$pdf->Cell(30,5,"Cantidad ",1,0,"C");
$pdf->Cell(30,5,"Producto ",1,0,"C");
$pdf->Cell(40,5,"Destino ",1,0,"C");
$pdf->Cell(40,5,"Encargado ",1,0,"C");
$pdf->Cell(20,5,"Estado ",1,1,"C");


$pdf->SetFont("Arial", "B", 9);

while ($fila = $resultado->fetch_assoc()){
    $pdf->Cell(25,5,$fila['id_guia_salida'],1,0,"C");
    $pdf->Cell(40,5,$fila['fecha_salida'],1,0,"C");
    $pdf->Cell(70,5,strip_tags($fila[utf8_decode('descripcion')]),1,0,"B");
    $pdf->Cell(30,5,$fila['cantidad_salida'],1,0,"C");
    $pdf->Cell(30,5,$fila[utf8_decode('producto')],1,0,"C");
    $pdf->Cell(40,5,$fila[utf8_decode('destino')],1,0,"C");
    $pdf->Cell(40,5,$fila['encargado'],1,0,"C");
    $pdf->Cell(20,5,$fila['activo'],1,1,"C");

}



$pdf->Output('I', 'reporte_guia_salida.pdf');
?>