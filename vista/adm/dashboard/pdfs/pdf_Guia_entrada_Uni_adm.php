<?php
require ('../../../../controlador/fpdf/plantilla.php');
require ('../../../../modelo/config.php');

// Obtener el ID de la guía de entrada desde el parámetro GET
$id_guia = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar si el ID está presente y no está vacío
if ($id_guia !== null && $id_guia !== '') {
    // Consultar la base de datos para obtener la información de la guía de entrada específica
    $query = "SELECT g.id_guia_entrada, g.fecha_entrada, g.descripcion, g.activo, p.Nombre_de_la_empresa AS proveedor FROM guia_de_entrada g LEFT JOIN provedor p ON p.id_provedor = g.id_proveedor WHERE g.id_guia_entrada = '$id_guia'";
    $result = $conn->query($query);

    // Verificar si se encontraron resultados
    if ($result && $result->num_rows > 0) {
        $pdf = new PDF("L","mm", array(300,320));   
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',9);

        $pdf->Ln(10);

        $pdf->Cell(45, 5,  mb_convert_encoding('Reporte Guias de Entrada', 'ISO-8859-1', 'UTF-8'), 0, 0, "C");
        $pdf->Image('../img/Makro_logo.png', 250, 5, 40);

        $pdf->Ln(10);

        $pdf->Cell(30,5,"Id Guia de Entrada",1,0,"C");
        $pdf->Cell(40,5,"Fecha",1,0,"C");
        $pdf->Cell(70,5,"Descripcion ",1,0,"C");
        $pdf->Cell(70,5,"Proveedor ",1,0,"C");
        $pdf->Cell(20,5,"Estado ",1,1,"C");

        $pdf->SetFont("Arial", "B", 9);

        while ($fila = $result->fetch_assoc()){
            $pdf->Cell(30,5,$fila['id_guia_entrada'],1,0,"C");
            $pdf->Cell(40,5,$fila['fecha_entrada'],1,0,"C");
            $pdf->Cell(70,5,strip_tags($fila[utf8_decode('descripcion')]),1,0,"B");
            $pdf->Cell(70,5,$fila[utf8_decode('proveedor')],1,0,"C");
            $pdf->Cell(20,5,$fila['activo'],1,1,"C");
        }

        $pdf->Output('I', 'guia_entrada_individual_admin.pdf');
    } else {
        echo "No se encontró la guía de entrada con el ID proporcionado.";
    }
} else {
    echo "ID de guía de entrada no proporcionado.";
}
?>
