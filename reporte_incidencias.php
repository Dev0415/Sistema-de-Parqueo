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

    // Contenido del PDF
    $html = "
        <h1>Reporte de Incidencia</h1>
        <p><strong>Tipo de Incidencia:</strong> $tipo_incidencia</p>
        <p><strong>Nombre del Cliente:</strong> $nombre_cliente</p>
        <p><strong>Descripción:</strong></p>
        <p>$descripcion</p>
        <p><strong>Fecha de Creación:</strong> $fecha_creacion</p>
        <p><strong>Hora de Creación:</strong> $hora_creacion</p>
    ";

    // Escribir el contenido HTML en el PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Nombre del archivo de salida
    $file_name = 'reporte_incidencia_' . date('YmdHis') . '.pdf';

    // Salida del PDF (descarga directa)
    $pdf->Output($file_name, 'D');

} else {
    // Manejar la situación en la que el formulario no se envía por método POST
    echo "Error: El formulario debe ser enviado por método POST.";
}
?>
