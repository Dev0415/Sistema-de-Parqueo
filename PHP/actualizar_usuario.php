<?php
include 'conexion.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $rol, $id);

    if($stmt->execute()) {
        echo "<script>alert('Usuario actualizado con éxito.'); window.location.href = 'user.php';</script>";
    } else {
        echo "<script>alert('Hubo un error al actualizar el usuario.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
