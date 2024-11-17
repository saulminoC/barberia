<?php
header('Content-Type: application/json');
session_start();

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID de usuario no proporcionado']);
    exit;
}

$usuarioId = $_GET['id'];

// Configura la conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Error en la conexión a la base de datos: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT nombre, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar la consulta SQL: ' . $conn->error]);
    exit;
}
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    echo json_encode($usuario);
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
