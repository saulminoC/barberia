<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Conexión fallida: ' . $conn->connect_error]));
}

$sql = "SELECT dia, hora FROM horario_disponible";
$result = $conn->query($sql);

$dias = [];
$horas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Agrega solo valores únicos a los arrays
        if (!in_array($row['dia'], $dias)) {
            $dias[] = $row['dia'];
        }
        if (!in_array($row['hora'], $horas)) {
            $horas[] = $row['hora'];
        }
    }
}

// Estructura JSON con 'dias' y 'horas'
echo json_encode(['dias' => $dias, 'horas' => $horas]);

$conn->close();
?>
