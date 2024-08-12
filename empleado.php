<?php
// Inicio de la sesión
session_start();

if (!isset($_SESSION['nombre'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Sistema de Tickets</title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* Ajusta la posición del menú desplegable */
        .navbar-nav .dropdown-menu {
            left: auto;
            right: 0;
        }
        #texto {
            font-weight: 600;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="texto">
    <a class="navbar-brand" href="index.php">Sistema de Tickets</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>       
            <li class="nav-item">
                <a class="nav-link" href="AI/Formulario.html">Control de Parqueo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tickets.php">Tickets</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownReportes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reportes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownReportes">
                    <a class="dropdown-item" href="reporte_incidencias.php">Reporte de problemas de un cliente especifico</a>
                    <a class="dropdown-item" href="reporte.php">Reporte de incidencias relacionadas con tarifas</a>
                    <a class="dropdown-item" href="reporte_perdidas_ticket.php">Reporte de perdidas de ticket</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION['nombre']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownUsuario">
                    <a class="dropdown-item" href="#">Rol: <?php echo $_SESSION['rol']; ?></a>
                    <a class="dropdown-item" href="#">Fecha de creación: <?php echo date('d-m-Y', strtotime($_SESSION['fecha_creacion'])); ?></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Aquí va el resto de tu contenido -->

<!-- jQuery y JavaScript de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
