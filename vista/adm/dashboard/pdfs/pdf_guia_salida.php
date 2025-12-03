<?php

require '../../../../controlador/fpdf/plantilla.php';
require '../../../../modelo/config.php';

$ruc = '20600837550';
$domicilioFiscal = 'Av. Los Próceres 145, Lima – San Juan de Lurigancho';
$puntoPartida = 'Almacén Maribel– Jr. Huancavelica 234, Lima.';

$consulta = "SELECT * FROM guia_de_salida ORDER BY fecha_salida DESC, id_guia_salida DESC";
$resultado = $conn->query($consulta);

if ($resultado && $resultado->num_rows > 0) {
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();

    while ($guia = $resultado->fetch_assoc()) {
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true, 15);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(140, 12, mb_convert_encoding('RUC: ' . $ruc, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(140, 12, mb_convert_encoding('GUÍA DE REMISIÓN - REMITENTE', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf->Ln(12);

        $numeroGuia = 'GS-' . str_pad((string) $guia['id_guia_salida'], 6, '0', STR_PAD_LEFT);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(210, 8, mb_convert_encoding('Domicilio fiscal: ' . $domicilioFiscal, 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(70, 8, mb_convert_encoding('N° ' . $numeroGuia, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

        $pdf->Cell(140, 8, mb_convert_encoding('Fecha de inicio de traslado: ' . $guia['fecha_salida'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(140, 8, mb_convert_encoding('Punto de llegada: ' . $guia['destino'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');

        $pdf->Cell(140, 8, mb_convert_encoding('Destinatario: ' . $guia['encargado'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(140, 8, mb_convert_encoding('Punto de partida: ' . $puntoPartida, 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');

        $pdf->Cell(280, 8, mb_convert_encoding('Motivo del traslado (especificar): ' . $guia['descripcion'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 8, 'DESCRIPCION', 1, 0, 'C');
        $pdf->Cell(40, 8, 'CANTIDAD', 1, 0, 'C');
        $pdf->Cell(60, 8, 'PRODUCTO', 1, 0, 'C');
        $pdf->Cell(50, 8, 'DESTINO', 1, 0, 'C');
        $pdf->Cell(50, 8, 'ENCARGADO', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(80, 8, mb_convert_encoding($guia['descripcion'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(40, 8, $guia['cantidad_salida'], 1, 0, 'C');
        $pdf->Cell(60, 8, mb_convert_encoding($guia['producto'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(50, 8, mb_convert_encoding($guia['destino'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(50, 8, mb_convert_encoding($guia['encargado'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'C');

        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(140, 8, mb_convert_encoding('Observaciones: ' . $guia['activo'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
    }

    $pdf->Output('I', 'reporte_guia_salida.pdf');
} else {
    echo 'No hay guías de salida registradas.';
}