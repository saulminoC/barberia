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

// Consulta para obtener horarios disponibles
$sql = "SELECT dia, hora FROM horario_disponible";
$result = $conn->query($sql);

$horarios = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $horarios[] = $row;
    }
}

echo json_encode($horarios);

$conn->close();
?>
