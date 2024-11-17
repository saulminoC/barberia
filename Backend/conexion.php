<?php
// Datos de la conexión a la base de datos
$host = 'localhost'; // Dirección del servidor
$user = 'usuario'; // Tu usuario de base de datos
$password = 'contraseña'; // Tu contraseña de base de datos
$dbname = 'nombre_base_de_datos'; // Nombre de tu base de datos

// Crear la conexión
$conn = mysqli_connect($host, $user, $password, $dbname);

// Verificar la conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
