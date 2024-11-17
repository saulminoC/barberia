<?php
session_start();
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener los datos del POST
$usuarioId = $_POST['usuarioId'];
$nombre = $_POST['nombre'];

// Actualizar solo el nombre del usuario
$sql = "UPDATE usuarios SET nombre = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $nombre, $usuarioId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Nombre actualizado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar el nombre"]);
}

$conn->close();
?>
