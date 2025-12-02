<?php

require ('../../../../controlador/fpdf/plantilla_colab.php');
require ('../../../../modelo/config.php');


$consulta = "SELECT * FROM provedor";
$resultado = $conn->query($consulta);

$pdf = new PDF("P","mm", array(300,300));   
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Ln(10);

$pdf->Cell(45, 5,  mb_convert_encoding('Reporte de Tabla Proveedor', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
$pdf->Image('../img/Makro_logo.png', 250, 5, 40);

$pdf->Ln(10);

$pdf->Cell(20,5,"ID",1,0,"C");
$pdf->Cell(40,5,"Nombre De la Empresa",1,0,"C");
$pdf->Cell(20,5,"Ruc",1,0,"C");
$pdf->Cell(40,5,"Persona de Contacto",1,0,"C");
$pdf->Cell(45,5,"Numero Telefonico",1,0,"C");
$pdf->Cell(45,5,"Correo Electronico",1,1,"C");

$pdf->SetFont("Arial", "B", 9);

while ($fila = $resultado->fetch_assoc()){
    $pdf->Cell(20,5,$fila['id_provedor'],1,0,"C");
    $pdf->Cell(40,5,$fila['Nombre_de_la_empresa'],1,0,"C");
    $pdf->Cell(20,5,$fila['ruc'],1,0,"C");
    $pdf->Cell(40,5,$fila['Persona_de_Contacto'],1,0,"C");
    $pdf->Cell(45,5,$fila[utf8_decode('Numero_de_contacto')],1,0,"C");
    $pdf->Cell(45,5,$fila[utf8_decode('correo_electronico')],1,1,"C");
}



$pdf->Output('I', 'reporte_proveedores_colaboradores.pdf');
?>