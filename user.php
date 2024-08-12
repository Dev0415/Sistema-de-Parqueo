<?php
// Incluye el archivo de conexión a la base de datos
include 'PHP/conexion.php';

// Verifica si se ha enviado un ID de usuario para eliminar
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepara y ejecuta la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado con éxito.'); location.reload();</script>";
    } else {
        echo "<script>alert('Hubo un error al eliminar el usuario.');</script>";
    }

    $stmt->close();
}

// Prepara y ejecuta la consulta SQL para obtener todos los usuarios
$sql = "SELECT id, nombre, rol, fecha_creacion FROM usuarios";
$resultado = $conn->query($sql);
?>

<!-- Inicio del HTML -->
<!DOCTYPE html>
<html>

<head>
    <title>Usuarios</title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .profile-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .card-body {
            height: 190px;
        }

        .card-title {
            font-size: 1.2em;
            font-weight: bold;
        }

        .card-text {
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Inicio de la barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Sistema de Tickets</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user.php">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AI/Formulario.html">Control de Parqueo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tickets.php">Tickets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reportes.php">Reportes</a>
                </li>
                <!-- Añade un campo de búsqueda en tu HTML -->
                <input type="text" id="search" placeholder="Buscar usuario...">
               
            </ul>
        </div>
    </nav>
    <!-- Fin de la barra de navegación -->

    <!-- Inicio del contenedor principal -->
    <div class="container">
    <div id="results"></div>
        <div class="row">
            <?php
            // Verifica si hay usuarios en la base de datos
            if ($resultado->num_rows > 0) {
                // Salida de cada fila
                while ($usuario = $resultado->fetch_assoc()) {
                    // Crea una tarjeta para cada usuario
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

                    // Crea una ventana modal para editar cada usuario
                    echo '
                    <div class="modal fade" id="editModal' . $usuario['id'] . '" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="nombre' . $usuario['id'] . '">Nombre</label>
                                            <input type="text" class="form-control" id="nombre' . $usuario['id'] . '" value="' . $usuario['nombre'] . '">
                                        </div>
                                        <div class="form-group">
                                            <label for="rol' . $usuario['id'] . '">Rol</label>
                                            <input type="text" class="form-control" id="rol' . $usuario['id'] . '" value="' . $usuario['rol'] . '">
                                        </div>
                                        <!-- Agrega aquí más campos si los necesitas -->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarUsuario(' . $usuario['id'] . ')">Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo "No se encontraron usuarios.";
            }
            ?>
        </div>
    </div>
    <!-- Fin del contenedor principal -->

    <!-- Inicio de los scripts de jQuery y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        function eliminarUsuario(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este usuario?")) {
                $.post(window.location.href, { id: id }, function () {
                    location.reload();
                });
            }
        }

        // Aquí debes implementar la función para editar un usuario
        function editarUsuario(id) {
            // Recoge los valores de los campos del formulario
            var nombre = $('#nombre' + id).val();
            var rol = $('#rol' + id).val();

            // Haz una solicitud POST al servidor para actualizar el usuario
            $.ajax({
                url: 'PHP/editar_usuario.php',  // Asegúrate de que este archivo exista y haga lo que se supone que debe hacer
                type: 'POST',
                data: {
                    id: id,
                    nombre: nombre,
                    rol: rol
                },
                success: function (response) {
                    if (response == 'success') {
                        alert('Usuario actualizado con éxito.');
                        location.reload();
                    } else {
                        alert('Hubo un error al actualizar el usuario.');
                    }
                }
            });
        }
    </script>
    <script>
    // Guarda las tarjetas de usuario originales cuando la página se carga por primera vez
    var originalCards = $('.container').html();

    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var search = $(this).val();

            // Verifica si el campo de búsqueda está vacío
            if(search.trim() != '') {
                // Haz una solicitud AJAX al servidor para buscar usuarios
                $.ajax({
                    url: 'PHP/buscar_usuario.php',  // Asegúrate de que este archivo exista y haga lo que se supone que debe hacer
                    type: 'POST',
                    data: { search: search },
                    success: function(response) {
                        // Actualiza el div de resultados con la respuesta del servidor
                        $('.container').html(response);
                    }
                });
            } else {
                // Si el campo de búsqueda está vacío, restaura las tarjetas de usuario originales
                $('.container').html(originalCards);
            }
        });
    });
</script>


    <!-- Fin de los scripts de jQuery y Bootstrap -->
</body>

</html>

<?php
// Cierra la conexión a la base de datos
$conn->close();
?>