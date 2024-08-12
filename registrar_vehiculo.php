<?php
// Asumiendo que ya tienes un archivo 'conexion.php' que se encarga de la conexión a la base de datos
include '../PHP/conexion.php';

function generarTicket($conn) {
    // Obtener el último número de ticket asignado
    $sql = "SELECT MAX(numero_ticket) AS max_ticket FROM vehiculos";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $max_ticket = $row['max_ticket'];

    // Incrementar el último número de ticket y devolverlo
    return str_pad($max_ticket + 1, 2, '0', STR_PAD_LEFT);
}
  // Asumiendo que tienes un formulario con el campo 'placa'
  $placa = $_POST['placa'];  
  
  // Comprobar si el campo 'placa' está vacío
  if (empty($placa)) {
    echo "Error: El campo 'placa' está vacío.";
    exit;
  }

  // Comprobar si la placa ya está registrada
  $sql = "SELECT * FROM vehiculos WHERE placa = '$placa'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "Error: La placa '$placa' ya está registrada.";
    exit;
  }

// Lista de modelos y colores reales
$modelos = array(
  "Toyota Corolla",
  "Honda Civic",
  "Ford F-150",
  "Chevrolet Silverado",
  "Ram 1500",
  "Toyota Camry",
  "Honda CR-V",
  "Tesla Model 3",
  "Hyundai Elantra",
  "Subaru Forester",
  "Nissan Rogue",
  "Volkswagen Golf",
  "BMW 3 Series",
  "Mercedes-Benz C-Class",
  "Audi A4",
  "Porsche 911",
  "Mazda MX-5 Miata",
  "Chevrolet Corvette",
  "Ford Mustang",
  "Dodge Charger",
  "Jeep Wrangler",
  "Toyota RAV4",
  "Honda Accord",
  "Subaru Outback",
  "Hyundai Tucson",
  "Kia Soul",
  "Nissan Altima",
  "Volkswagen Passat",
  "BMW 5 Series",
  "Mercedes-Benz E-Class",
  "Audi A6",
  "Porsche Panamera",
  "Mazda CX-5",
  "Chevrolet Equinox",
  "Ford Explorer",
  "Dodge Durango",
  "Jeep Grand Cherokee",
  "Toyota Highlander",
  "Honda Pilot",
  "Subaru Ascent",
  "Lexus RX",
  "BMW X5",
  "Audi Q5",
  "Mercedes-Benz GLE",
  "Porsche Cayenne",
  "Volvo XC90",
  "Land Rover Discovery",
  "Jaguar F-Pace",
  "Alfa Romeo Stelvio",
  "Cadillac XT5",
  "Infiniti QX50",
  "Lincoln Nautilus",
  "Acura RDX",
  "Buick Enclave",
  "GMC Acadia",
  "Chevrolet Traverse",
  "Ford Edge",
  "Hyundai Santa Fe",
  "Kia Sorento",
  "Nissan Murano",
  "Mitsubishi Outlander",
  "Subaru Crosstrek",
  "Jeep Compass",
  "Fiat 500X",
  "Mini Countryman",
  "BMW X1",
  "Audi Q3",
  "Mercedes-Benz GLA",
  "Volvo XC40",
  "Lexus UX",
  "Cadillac XT4",
  "Infiniti QX30",
  "Lincoln Corsair",
  "Acura RDX",
  "Buick Encore",
  "Chevrolet Trax",
  "Ford EcoSport",
  "Honda HR-V",
  "Hyundai Kona",
  "Kia Soul",
  "Nissan Kicks",
  "Toyota C-HR",
  "Subaru Impreza",
  "Volkswagen Jetta",
  "Hyundai Sonata",
  "Kia Optima",
  "Nissan Sentra",
  "Chevrolet Malibu",
  "Ford Fusion",
  "Dodge Challenger",
  "Chevrolet Camaro",
  "Ford Mustang",
  "BMW M4",
  "Mercedes-Benz AMG GT",
  "Audi RS5",
  "Porsche 718 Cayman",
  "Lexus RC F",
  "Infiniti Q60",
  "Cadillac ATS-V",
  "Alfa Romeo Giulia Quadrifoglio",
  "Maserati Ghibli",
  "Aston Martin Vantage",
  "Bentley Continental GT",
  "Rolls-Royce Wraith"
);

$colores = array(
  "Blanco", 
  "Negro", 
  "Gris", 
  "Azul", 
  "Rojo", 
  "Verde", 
  "Amarillo", 
  "Naranja", 
  "Morado", 
  "Rosa", 
  "Turquesa", 
  "Coral", 
  "Lavanda", 
  "Marrón", 
  "Beige",
  "Personalizado"
);

$modelo = $modelos[array_rand($modelos)];  // Elegir un modelo aleatorio de la lista
$color = $colores[array_rand($colores)];  // Elegir un color aleatorio de la lista

$hora_entrada = date('Y-m-d H:i:s');  // Fecha y hora actual
$numero_ticket = generarTicket($conn);
$tarifa_aplicada = 0.50;  // Tarifa de 50 centavos de dólar por 1 hora

$sql = "INSERT INTO vehiculos (placa, modelo, color, hora_entrada, numero_ticket, tarifa_aplicada)
VALUES ('$placa', '$modelo', '$color', '$hora_entrada', '$numero_ticket', '$tarifa_aplicada')";

if ($conn->query($sql) === TRUE) {
  echo "Nuevo registro creado exitosamente";
  // Llamar al archivo generar_ticket.php
  $_POST['numero_ticket'] = $numero_ticket;
  $_POST['modelo'] = $modelo;
  $_POST['color'] = $color;
  $_POST['tarifa_aplicada'] = $tarifa_aplicada;
  include 'generar_ticket.php';
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>