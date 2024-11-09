<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barberia_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$email = 'admin@barberia.com';
$plainPassword = 'admin123'; // La contraseña en texto plano

// Hash de la contraseña con password_hash
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Insertar el usuario en la base de datos
$sql = "INSERT INTO usuarios (email, password, rol) 
        VALUES ('$email', '$hashedPassword', 'administrador')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario creado correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
