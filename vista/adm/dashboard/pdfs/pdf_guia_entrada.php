<?php

require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');


$consulta = "SELECT g.id_guia_entrada, g.fecha_entrada, g.descripcion, g.activo, p.Nombre_de_la_empresa AS proveedor FROM guia_de_entrada g LEFT JOIN provedor p ON p.id_provedor = g.id_proveedor";
$resultado = $conn->query($consulta);

$pdf = new PDF("L","mm", array(300,320));   
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Ln(10);

$pdf->Cell(45, 5,  mb_convert_encoding('Reporte Guias de Entrada', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
$pdf->Image('../img/Makro_logo.png', 250, 5, 40);

$pdf->Ln(10);

$pdf->Cell(25,5,"Id Guia de Entrada",1,0,"C");
$pdf->Cell(40,5,"Fecha",1,0,"C");
$pdf->Cell(70,5,"Descripcion ",1,0,"C");
$pdf->Cell(70,5,"Proveedor ",1,0,"C");
$pdf->Cell(20,5,"Estado ",1,1,"C");


$pdf->SetFont("Arial", "B", 9);

while ($fila = $resultado->fetch_assoc()){
    $pdf->Cell(25,5,$fila['id_guia_entrada'],1,0,"C");
    $pdf->Cell(40,5,$fila['fecha_entrada'],1,0,"C");
    $pdf->Cell(70,5,strip_tags($fila[utf8_decode('descripcion')]),1,0,"B");
    $pdf->Cell(70,5,$fila[utf8_decode('proveedor')],1,0,"C");
    $pdf->Cell(20,5,$fila['activo'],1,1,"C");

}



$pdf->Output('I', 'reporte_guia_entrada.pdf');
?>