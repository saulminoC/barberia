<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$email = $_POST['email'];
$pass = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    
    if (md5($pass) == $usuario['password']) {
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['rol'] = $usuario['rol'];

        // Responder con JSON en lugar de redireccionar
        echo json_encode([
            "success" => true,
            "usuarioId" => $usuario['id'], // Asumiendo que el ID está en el campo 'id' de la base de datos
            "rol" => $usuario['rol']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Correo no encontrado."]);
}

$conn->close();
?>
