<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Incidencias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            height: 120px;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reporte de Incidencias</h2>
        <form action="procesar_reporte.php" method="post">
           
            <div class="form-group">
                <label for="tipo_incidencia">Tipo de Incidencia:</label>
                <select name="tipo_incidencia" id="tipo_incidencia" required>
                    <option value="">Selecciona el tipo de incidencia</option>
                    <option value="Tarifas">Incidencia relacionada con tarifas</option>
                    <option value="PerdidaTicket">Pérdida de ticket</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre_cliente">Nombre:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente" required>
            </div>
          
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" placeholder="Describe la incidencia..." required></textarea>
            </div>
                <div class="form-group">
                <label for="fecha_creacion">Fecha:</label>
                <input type="date" id="fecha_creacion" name="fecha_creacion" required>
            </div>
            <div class="form-group">
                <label for="hora_creacion">Hora:</label>
                <input type="time" id="hora_creacion" name="hora_creacion" required>
            </div>
      
            <button type="submit">Generar Reporte</button>
        </form>
    </div>
</body>
</html>
