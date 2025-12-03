<?php
require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');

$id_guia = isset($_GET['id']) ? $_GET['id'] : null;

 
$cabecera = null;
$detalleQuery = null;

 main
if ($id_guia !== null && $id_guia !== '') {
    $query = "SELECT * FROM guia_de_salida WHERE id_guia_salida = '$id_guia'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $cabecera = $result->fetch_assoc();
        $detalleQuery = $conn->query(
            "SELECT d.*, p.nombre_producto, l.fecha_vencimiento FROM guia_de_salida_detalle d " .
            "LEFT JOIN producto p ON p.id_producto = d.id_producto " .
            "LEFT JOIN lote l ON l.id_lote = d.id_lote WHERE d.id_guia_salida = '$id_guia'"
        );

    }
}

if (!$cabecera) {
    echo "No se encontró la guía de salida con el ID proporcionado.";
    exit;
}

$ruc = $cabecera['numero_documento'] ?? '20600837550';
$domicilio = $cabecera['domicilio_fiscal'] ?? 'Av. Los Próceres 145, Lima – San Juan de Lurigancho';
$puntoPartida = $cabecera['punto_partida'] ?? 'Almacén Maribel– Jr. Huancavelica 234, Lima.';
$serieNumero = '001-' . str_pad((string) ($cabecera['id_guia_salida'] ?? '0'), 6, '0', STR_PAD_LEFT);

$pdf = new PDF("P", "mm", "A4");
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(130, 10, utf8_decode('GUÍA DE REMISIÓN - REMITENTE'), 1, 0, 'L');
$pdf->Cell(60, 10, 'RUC: ' . $ruc, 1, 1, 'R');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(190, 8, 'Domicilio Fiscal: ' . utf8_decode($domicilio), 1, 1);
$pdf->Cell(95, 8, 'Fecha de emisión: ' . ($cabecera['fecha_salida'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'Fecha de inicio de traslado: ' . ($cabecera['fecha_inicio_traslado'] ?? ''), 1, 1);
$pdf->Cell(95, 8, 'Destinatario: ' . utf8_decode($cabecera['destinatario'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'RUC/DNI: ' . ($cabecera['ruc_dni_destinatario'] ?? ''), 1, 1);
$pdf->Cell(190, 8, 'Punto de partida: ' . utf8_decode($puntoPartida), 1, 1);
$pdf->Cell(190, 8, 'Punto de llegada: ' . utf8_decode($cabecera['punto_llegada'] ?? ''), 1, 1);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 8, 'Motivo del traslado: ' . utf8_decode($cabecera['motivo_traslado'] ?? ''), 1, 1);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 8, 'Modalidad de transporte: ' . utf8_decode($cabecera['modalidad_transporte'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'Destino interno: ' . utf8_decode($cabecera['destino'] ?? ''), 1, 1);
$pdf->Cell(95, 8, 'Encargado: ' . utf8_decode($cabecera['encargado'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'Estado: ' . ($cabecera['activo'] ?? ''), 1, 1);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 8, 'Detalle de productos', 1, 1, 'C');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(70, 7, 'Descripción', 1, 0, 'C');
$pdf->Cell(20, 7, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 7, 'Unidad', 1, 0, 'C');
$pdf->Cell(25, 7, 'Peso total', 1, 0, 'C');
$pdf->Cell(25, 7, 'Lote', 1, 0, 'C');
$pdf->Cell(20, 7, 'Vence', 1, 1, 'C');

if ($detalleQuery && $detalleQuery->num_rows > 0) {
    $pdf->SetFont('Arial', '', 9);
    while ($detalle = $detalleQuery->fetch_assoc()) {
        $pdf->Cell(70, 7, utf8_decode($detalle['descripcion'] ?? ''), 1, 0);
        $pdf->Cell(20, 7, $detalle['cantidad'] ?? '', 1, 0, 'C');
        $pdf->Cell(30, 7, utf8_decode($detalle['unidad_medida'] ?? ''), 1, 0, 'C');
        $pdf->Cell(25, 7, $detalle['peso_total'] ?? '', 1, 0, 'C');
        $pdf->Cell(25, 7, $detalle['id_lote'] ?? '', 1, 0, 'C');
        $pdf->Cell(20, 7, $detalle['fecha_vencimiento'] ?? '', 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 7, 'No hay detalles registrados para esta guía.', 1, 1, 'C');

        $pdf = new PDF("L", "mm", array(300, 320));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(80, 6, mb_convert_encoding('GUÍA DE REMISIÓN - REMITENTE', 'ISO-8859-1', 'UTF-8'), 0, 0, "L");
        $pdf->Cell(70, 6, 'RUC: ' . $cabecera['numero_documento'], 0, 0, "R");
        $pdf->Image('../img/Makro_logo.png', 250, 5, 40);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(60, 6, 'Domicilio fiscal: ' . utf8_decode($cabecera['domicilio_fiscal']), 0, 0);
        $pdf->Cell(60, 6, 'Fecha emisión: ' . $cabecera['fecha_salida'], 0, 0);
        $pdf->Cell(80, 6, 'Inicio traslado: ' . ($cabecera['fecha_inicio_traslado'] ?? '-'), 0, 1);

        $pdf->Cell(60, 6, 'Destinatario: ' . utf8_decode($cabecera['destinatario']), 0, 0);
        $pdf->Cell(60, 6, 'RUC/DNI: ' . $cabecera['ruc_dni_destinatario'], 0, 0);
        $pdf->Cell(80, 6, 'Motivo: ' . utf8_decode($cabecera['motivo_traslado']), 0, 1);

        $pdf->Cell(120, 6, 'Punto de partida: ' . utf8_decode($cabecera['punto_partida']), 0, 1);
        $pdf->Cell(120, 6, 'Punto de llegada: ' . utf8_decode($cabecera['punto_llegada']), 0, 1);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(90, 6, 'Motivo del traslado: ' . utf8_decode($cabecera['motivo_traslado']), 0, 1);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(60, 6, 'Modalidad: ' . utf8_decode($cabecera['modalidad_transporte']), 0, 0);
        $pdf->Cell(60, 6, 'Destino interno: ' . utf8_decode($cabecera['destino']), 0, 1);
        $pdf->Cell(60, 6, 'Encargado: ' . utf8_decode($cabecera['encargado']), 0, 0);
        $pdf->Cell(60, 6, 'Estado: ' . $cabecera['activo'], 0, 1);

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(65, 6, 'Descripción', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Cant.', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Unidad', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Peso', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Producto', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Lote', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Vencimiento', 1, 1, 'C');

        if ($detalleQuery && $detalleQuery->num_rows > 0) {
            $pdf->SetFont('Arial', '', 9);
            while ($detalle = $detalleQuery->fetch_assoc()) {
                $pdf->Cell(65, 6, utf8_decode($detalle['descripcion']), 1, 0);
                $pdf->Cell(20, 6, $detalle['cantidad'], 1, 0, 'C');
                $pdf->Cell(25, 6, utf8_decode($detalle['unidad_medida']), 1, 0, 'C');
                $pdf->Cell(25, 6, $detalle['peso_total'], 1, 0, 'C');
                $pdf->Cell(40, 6, utf8_decode($detalle['nombre_producto']), 1, 0);
                $pdf->Cell(25, 6, $detalle['id_lote'], 1, 0, 'C');
                $pdf->Cell(30, 6, $detalle['fecha_vencimiento'], 1, 1, 'C');
            }
        } else {
            $pdf->Cell(230, 6, 'No hay detalles registrados para esta guía.', 1, 1, 'C');
        }

        $pdf->Ln(8);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(80, 6, 'Marca y placa: ' . utf8_decode($cabecera['marca_placa']), 0, 0);
        $pdf->Cell(80, 6, 'Licencia conducir: ' . utf8_decode($cabecera['licencia_conducir']), 0, 0);
        $pdf->Cell(80, 6, 'RUC transportista: ' . utf8_decode($cabecera['ruc_transporte']), 0, 1);
        $pdf->Cell(120, 6, 'Denominación transportista: ' . utf8_decode($cabecera['denominacion_conductor']), 0, 1);

        $pdf->Output('I', 'guia_salida_individual_admin.pdf');
    } else {
        echo "No se encontró la guía de salida con el ID proporcionado.";
    }
} else {
    echo "ID de guía de salida no proporcionado.";

}

$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 8, 'Datos de traslado', 1, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(95, 8, 'Marca y placa: ' . utf8_decode($cabecera['marca_placa'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'Licencia de conducir: ' . utf8_decode($cabecera['licencia_conducir'] ?? ''), 1, 1);
$pdf->Cell(95, 8, 'RUC transportista: ' . utf8_decode($cabecera['ruc_transporte'] ?? ''), 1, 0);
$pdf->Cell(95, 8, 'Denominación transportista: ' . utf8_decode($cabecera['denominacion_conductor'] ?? ''), 1, 1);

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(190, 8, 'Documento: ' . $serieNumero, 0, 1, 'R');

$pdf->Output('I', 'guia_salida_individual_admin.pdf');
?>
