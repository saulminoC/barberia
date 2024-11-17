<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "barberia_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

$dia = isset($_GET['dia']) ? $_GET['dia'] : '';
if (empty($dia)) {
    echo json_encode(['success' => false, 'message' => 'Día no proporcionado']);
    exit;
}

$sql = "SELECT hora FROM horario_disponible WHERE dia = ? ORDER BY hora";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $dia);
$stmt->execute();
$result = $stmt->get_result();

$horas = [];
while ($row = $result->fetch_assoc()) {
    $horas[] = $row['hora'];
}

echo json_encode(['success' => true, 'horas' => $horas]);

$stmt->close();
$conn->close();
?>
