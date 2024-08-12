<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion.php';

// Verifica si se ha enviado una búsqueda
if(isset($_POST['search'])) {
    $search = $_POST['search'];

    // Prepara y ejecuta la consulta SQL para buscar usuarios
    $sql = "SELECT * FROM usuarios WHERE nombre LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchWithWildcards = "%" . $search . "%";
    $stmt->bind_param("s", $searchWithWildcards);
    $stmt->execute();
    $result = $stmt->get_result();

    // Muestra los resultados de la búsqueda
    while($usuario = $result->fetch_assoc()) {
        echo '
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <img src="IMG\usuario.png" class="profile-img" alt="Imagen de perfil">
                    <div class="flex-grow-1">
                        <h5 class="card-title">' . $usuario['nombre'] . '</h5>
                        <p class="card-text text-truncate">' . $usuario['rol'] . '</p>
                        <p class="card-text"><small class="text-muted">Creado el ' . $usuario['fecha_creacion'] . '</small></p>
                        <button class="btn btn-danger" onclick="eliminarUsuario(' . $usuario['id'] . ')">Eliminar</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editModal' . $usuario['id'] . '">Editar</button>
                    </div>
                </div>
            </div>
        </div>';
    }

    $stmt->close();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
