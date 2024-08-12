<?php
ob_start();  // Iniciar el almacenamiento en búfer de salida
require_once('tcpdf/tcpdf.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_parqueo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

date_default_timezone_set('America/El_Salvador');

$numero_ticket = $_POST['numero_ticket'];

// Recuperar los datos del vehículo que acabas de insertar
$sql = "SELECT * FROM vehiculos WHERE numero_ticket = '$numero_ticket'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$placa = $row['placa'];
$modelo = $row['modelo'];
$color = $row['color'];
$hora_entrada = $row['hora_entrada'];
$tarifa_aplicada = $row['tarifa_aplicada'];

$conn->close();

$pdf = new TCPDF('P', 'mm', array(80, 150), true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Parking System');
$pdf->SetTitle('Ticket de Parqueo');
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 10);

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Ticket de Parqueo', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('helvetica', '', 10);
$html = "
<table>
    <tr>
        <td><strong>Número de Ticket:</strong></td>
        <td>$numero_ticket</td>
    </tr>
    <br>
    <tr>
        <td><strong>Placa del Vehículo:</strong></td>
        <td>$placa</td>
    </tr>
    <br>
    <tr>
        <td><strong>Modelo del Vehículo:</strong></td>
        <td>$modelo</td>
    </tr>
    <br>
    <tr>
        <td><strong>Color del Vehículo:</strong></td>
        <td>$color</td>
    </tr>
    <br>
    <tr>
        <td><strong>Hora de Entrada:</strong></td>
        <td>$hora_entrada</td>
    </tr>
    <br>
    <tr>
        <td><strong>Tarifa Aplicada:</strong></td>
        <td>$tarifa_aplicada</td>
    </tr>
</table>
";
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'I', 8);
$pdf->Cell(0, 10, 'Gracias por utilizar nuestro servicio', 0, 1, 'C');

// Información que deseas codificar en el QR
$info = "Número de Ticket: $numero_ticket, Placa del Vehículo: $placa, Modelo del Vehículo: $modelo, Color del Vehículo: $color, Hora de Entrada: $hora_entrada, Tarifa Aplicada: $tarifa_aplicada";

// Codificar la información para la URL
$info_url = urlencode($info);

// URL de la API de QR Code Generator
$api_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$info_url";

// Ruta del archivo de imagen QR que se va a generar
$qr_image_file = 'qr-code.png';

// Descargar la imagen del código QR
file_put_contents($qr_image_file, file_get_contents($api_url));

$pageWidth = $pdf->getPageWidth();
$imageWidth = 30; // Ancho de la imagen en mm
$positionX = ($pageWidth - $imageWidth) / 2;

// Ajustamos la posición Y para que la imagen esté más arriba
$positionY = 100;

$pdf->Image($qr_image_file, $positionX, $positionY, $imageWidth, $imageWidth, 'PNG');

$pdf->Output('ticket.pdf', 'I');

ob_end_flush();  // Vaciar y desactivar el almacenamiento en búfer de salida
?>
