<?php
include("conexion.php");

function deleteUser($id) {
    $con = connection();
    $sql = "DELETE FROM users WHERE id = $id";
    $query = mysqli_query($con, $sql);

    if($query){
        echo "Usuario eliminado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Uso de la función
if (isset($_GET['id'])) {
    deleteUser($_GET['id']);
}
?>
