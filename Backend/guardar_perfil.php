<?php
header('Content-Type: application/json');
session_start();

if (!isset($_POST['nombre']) || !isset($_SESSION['usuarioId'])) {
    echo json_encode(['error' => 'Datos insuficientes']);
    exit;
}

$nombre = $_POST['nombre'];
$usuarioId = $_SESSION['usuarioId'];

// Configura la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error en la conexión a la base de datos']);
    exit;
}

$sql = "UPDATE usuarios SET nombre = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nombre, $usuarioId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Error al actualizar el perfil']);
}

$stmt->close();
$conn->close();
?>
