<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

// Obtener citas de la base de datos
$sql = "SELECT servicio, dia, hora, usuario_id FROM citas"; // No estamos seleccionando nombre ni correo
$result = $conn->query($sql);

$citas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
    echo json_encode(['success' => true, 'citas' => $citas]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontraron citas']);
}

// Cerrar la conexión
$conn->close();
?>
