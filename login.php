<?php
include 'PHP/conexion.php';

$mensaje = "";
$mostrarModal = false;
$redirigir = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        // Esto es un inicio de sesión
        $form_nombre = $_POST['nombre'];
        $form_password = $_POST['password'];

        // Buscar al usuario en la base de datos
        $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $form_nombre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Verificar la contraseña
            $row = $result->fetch_assoc();
            if (password_verify($form_password, $row['password_hash'])) {
                $mensaje = "Inicio de sesión exitoso";
                $mostrarModal = true;

                // Iniciar la sesión y guardar el rol del usuario
                session_start();
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['rol'] = $row['rol'];
                $_SESSION['fecha_creacion'] = $row['fecha_creacion'];


                // Redirigir al usuario a la página correspondiente según su rol
                if ($_SESSION['rol'] == 'Admin' || $_SESSION['rol'] == 'admin') {
                    header('Location: index.php');
                } else {
                    header('Location: empleado.php');
                }
                exit();
            } else {
                $mensaje = "Contraseña incorrecta";
                $mostrarModal = true;
            }
        } else {
            $mensaje = "Usuario no encontrado";
            $mostrarModal = true;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'register') {
        // Esto es un registro
        $form_nombre = $_POST['nombre'];
        $form_rol = $_POST['rol'];
        $form_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $fecha_creacion = date('Y-m-d H:i:s');

        // Insertar el nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, rol, password_hash, fecha_creacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $form_nombre, $form_rol, $form_password, $fecha_creacion);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $mensaje = "Registro exitoso";
            $mostrarModal = true;
        } else {
            $mensaje = "Error al registrar";
            $mostrarModal = true;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <div class="wrapper">
        <div class="card-switch">
            <label class="switch">
                <input type="checkbox" class="toggle">
                <span class="slider"></span>
                <span class="card-side"></span>
                <div class="flip-card__inner">
                    <div class="flip-card__front">
                        <div class="title">Iniciar sesión</div>
                        <form class="flip-card__form" action="" method="post">
                            <input type="hidden" name="action" value="login">
                            <input class="flip-card__input" name="nombre" placeholder="Nombre" type="text"
                                autocomplete="off">
                            <input class="flip-card__input" name="password" placeholder="Contraseña" type="password"
                                autocomplete="new-password">
                            <button class="flip-card__btn">¡Vamos!</button>
                        </form>
                    </div>
                    <div class="flip-card__back">
                        <div class="title">Registrarse</div>
                        <form class="flip-card__form" action="" method="post">
                            <input type="hidden" name="action" value="register">
                            <input class="flip-card__input" name="nombre" placeholder="Nombre" type="text"
                                autocomplete="off">
                            <input class="flip-card__input" name="rol" placeholder="Rol" type="text" autocomplete="off">
                            <input class="flip-card__input" name="password" placeholder="Contraseña" type="password"
                                autocomplete="new-password">
                            <button class="flip-card__btn">¡Confirmar!</button>
                        </form>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $mensaje; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            <?php if ($mostrarModal) { ?>
                $('#myModal').modal('show');
            <?php } ?>
        });
    </script>
</body>

</html>