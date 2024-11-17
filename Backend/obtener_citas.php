<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

// Conexión con la base de datos
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión: " . $mysqli->connect_error]);
    exit();
}

// Consulta para obtener todas las citas
$query = "SELECT * FROM citas";
$result = $mysqli->query($query);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar las citas
    $citas = [];
    
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }

    // Enviar las citas como respuesta JSON
    echo json_encode(["success" => true, "citas" => $citas]);
} else {
    echo json_encode(["success" => false, "message" => "No se encontraron citas"]);
}

// Cerrar la conexión con la base de datos
$mysqli->close();
?>
