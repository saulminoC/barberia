<?php
session_start(); // Iniciar la sesión

// Verificar si los datos de login llegaron
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    echo "Correo o contraseña no proporcionados";
    exit;
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el correo y la contraseña del formulario
$email = $_POST['email'];
$pass = $_POST['password'];

// Depuración: Ver los valores recibidos
var_dump($email, $pass);
