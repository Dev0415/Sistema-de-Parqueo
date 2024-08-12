<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_parqueo";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} 
error_log("Conexion Exitosa");
?>
