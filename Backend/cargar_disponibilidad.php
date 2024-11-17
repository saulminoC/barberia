<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "barberia_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

$sql = "SELECT DISTINCT dia FROM horario_disponible ORDER BY FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo')";
$result = $conn->query($sql);

$disponibilidades = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $disponibilidades[] = ['dia' => $row['dia']];
    }
}

echo json_encode(['success' => true, 'disponibilidades' => $disponibilidades]);

$conn->close();
?>
