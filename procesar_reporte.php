<?php
// Incluir la biblioteca TCPDF
require_once 'TCPDF-main/tcpdf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y almacenar los datos del formulario
    $tipo_incidencia = $_POST['tipo_incidencia'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $descripcion = $_POST['descripcion'];
    $fecha_creacion = $_POST['fecha_creacion'];
    $hora_creacion = $_POST['hora_creacion'];

    // Crear nuevo objeto PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Establecer información del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Cliente');
    $pdf->SetTitle('Reporte de Incidencia');
    $pdf->SetSubject('Reporte generado por cliente');
    $pdf->SetKeywords('TCPDF, PDF, Reporte, Incidencia');

    // Agregar una página
    $pdf->AddPage();

    // Título del reporte
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Incidencia', 0, 1, 'C');
    $pdf->Ln(10);

    // Encabezados de la tabla
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(40, 10, 'Datos', 1, 0, 'C');
    $pdf->Cell(100, 10, 'Detalles', 1, 1, 'C');

    // Datos del formulario en la tabla
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(40, 10, 'Tipo de Incidencia', 1, 0);
    $pdf->Cell(100, 10, $tipo_incidencia, 1, 1);

    $pdf->Cell(40, 10, 'Nombre del Cliente', 1, 0);
    $pdf->Cell(100, 10, $nombre_cliente, 1, 1);

    $pdf->Cell(40, 10, 'Descripción', 1, 0);
    $pdf->MultiCell(100, 10, $descripcion, 1);

    $pdf->Cell(40, 10, 'Fecha de Creación', 1, 0);
    $pdf->Cell(100, 10, $fecha_creacion, 1, 1);

    $pdf->Cell(40, 10, 'Hora de Creación', 1, 0);
    $pdf->Cell(100, 10, $hora_creacion, 1, 1);

    // Salida del PDF
    $pdf->Output('reporte_incidencia.pdf', 'D');

} else {
    // Manejar la situación en la que el formulario no se envía por método POST
    echo "Error: El formulario debe ser enviado por método POST.";
}
?>
