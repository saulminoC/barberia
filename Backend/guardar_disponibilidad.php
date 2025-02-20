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

$dia = $data['dia'] ?? '';
$hora = $data['hora'] ?? '';

if (empty($dia) || empty($hora)) {
    echo json_encode(['success' => false, 'message' => 'Día u hora no proporcionados.']);
    exit;
}

// Guardar la disponibilidad
$stmt = $conn->prepare("INSERT INTO horario_disponible (dia, hora) VALUES (?, ?)");
$stmt->bind_param("ss", $dia, $hora);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Disponibilidad guardada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la disponibilidad.']);
}

$stmt->close();
$conn->close();
?>
