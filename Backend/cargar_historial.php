<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Asegura que la respuesta sea en formato JSON

// Obtener el ID de usuario
$usuarioId = $_GET['id']; 

// Verificar si se ha recibido el ID correctamente
if (!$usuarioId) {
    echo json_encode(["error" => "No se ha recibido un ID de usuario válido."]);
    exit;
}

// Configurar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}
$usuarioId = $_GET['id'];


// Consulta SQL para obtener el historial de servicios con el precio
$sql = "SELECT s.servicio, s.precio FROM servicios s
        JOIN citas c ON s.id = c.servicio_id
        WHERE c.usuario_id = ?"; 


$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Error al preparar la consulta SQL"]);
    exit;
}

$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows > 0) {
    $servicios = [];
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row;
    }
// Antes de echo json_encode()
var_dump($servicios); // Muestra el contenido de los datos
echo json_encode(["servicios" => $servicios]);

    // Responder con los servicios como JSON
    echo json_encode(["servicios" => $servicios]);
} else {
    echo json_encode(["error" => "No se encontraron servicios para este usuario."]);
}

$conn->close();
?>
