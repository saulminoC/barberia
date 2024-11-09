<?php
$servername = "localhost"; // Cambia según tu configuración
$username = "root"; // Cambia según tu configuración (en XAMPP por defecto es 'root')
$password = ""; // Cambia según tu configuración (en XAMPP por defecto es vacío)
$dbname = "barberia_db"; // Cambia según el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

// Obtener datos JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verificar si los datos son válidos
if (!$data) {
    die(json_encode(['success' => false, 'message' => 'Datos no válidos.']));
}

$dia = $data['dia'] ?? '';
$hora = $data['hora'] ?? '';

// Verificar que ambos campos no estén vacíos
if (empty($dia) || empty($hora)) {
    echo json_encode(['success' => false, 'message' => 'Día u hora no proporcionados.']);
    exit;
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare("INSERT INTO horario_disponible (dia, hora) VALUES (?, ?)");
$stmt->bind_param("ss", $dia, $hora);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Disponibilidad guardada correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar la disponibilidad.']);
}

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>
