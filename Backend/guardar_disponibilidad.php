<?php
$servername = "localhost"; // Cambia según tu configuración
$username = "tu_usuario"; // Cambia según tu configuración
$password = "tu_contraseña"; // Cambia según tu configuración
$dbname = "tu_base_de_datos"; // Cambia según tu configuración

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos JSON
$data = json_decode(file_get_contents("php://input"), true);
$dia = $data['dia'];
$hora = $data['hora'];

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("INSERT INTO horario_disponible (dia, hora) VALUES (?, ?)");
$stmt->bind_param("ss", $dia, $hora);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
