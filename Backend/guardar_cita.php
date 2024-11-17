<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    die(json_encode(['success' => false, 'message' => 'Datos no válidos.']));
}

$servicio = $data['servicio'] ?? '';
$dia = $data['dia'] ?? '';
$hora = $data['hora'] ?? '';
$usuario_id = $data['usuario_id'] ?? '';

if (empty($servicio) || empty($dia) || empty($hora) || empty($usuario_id)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

// Insertar la cita
$stmt = $conn->prepare("INSERT INTO citas (servicio, dia, hora, usuario_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $servicio, $dia, $hora, $usuario_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Cita reservada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la cita.']);
}

$stmt->close();
$conn->close();
?>
