<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Verifica si se ha enviado un ID de usuario para editar
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    // Prepara y ejecuta la consulta SQL para actualizar el usuario
    $sql = "UPDATE usuarios SET nombre = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $rol, $id);

    if($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
