<?php

require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');


$consulta = "SELECT * FROM colaborador";
$resultado = $conn->query($consulta);

$pdf = new PDF("P","mm", array(500,370));   
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Ln(10);

$pdf->Cell(40, 5,  mb_convert_encoding('Reporte de Tabla Servicio', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
$pdf->Image('../img/Makro_logo.png', 320, 5, 40);

$pdf->Ln(10);

$pdf->Cell(20,5,"ID",1,0,"C");
$pdf->Cell(40,5,"DNI",1,0,"C");
$pdf->Cell(40,5,"Nombre",1,0,"C");
$pdf->Cell(40,5,"Apellido",1,0,"C");
$pdf->Cell(30,5,"Genero",1,0,"C");
$pdf->Cell(35,5,"Direccion",1,0,"C");
$pdf->Cell(35,5,utf8_decode("Telefono"),1,0,"C");
$pdf->Cell(38,5,"Email",1,0,"C");
$pdf->Cell(20,5,"Tipo",1,1,"C");

$pdf->SetFont("Arial", "B", 9);

while ($fila = $resultado->fetch_assoc()){
    $pdf->Cell(20,5,$fila['id_colab'],1,0,"C");
    $pdf->Cell(40,5,$fila['dni_colab'],1,0,"C");
    $pdf->Cell(40,5,$fila['nombre_colab'],1,0,"C");
    $pdf->Cell(40,5,$fila['apellido_colab'],1,0,"C");
    $pdf->Cell(30,5,$fila['genero_colab'],1,0,"C");
    $pdf->Cell(35,5,$fila[utf8_decode('direccion_colab')],1,0,"C");
    $pdf->Cell(35,5,$fila['telefono_colab'],1,0,"C");
    $pdf->Cell(38,5,$fila["email"],1,0,"C");
    $pdf->Cell(20,5,$fila["user_type"],1,1,"C");
}



$pdf->Output('I', 'reporte_colaboradores.pdf');
?>