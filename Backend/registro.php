<?php
// Iniciar la conexión a la base de datos
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "barberia_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si los datos han sido enviados por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que las contraseñas coincidan
    if ($password === $confirm_password) {
        // Encriptar la contraseña
        $password_hashed = md5($password);  // Cambia a md5 si así lo tienes en la base de datos

        // Asignar el valor de 'cliente' al rol
        $rol = 'cliente';

        // Modificar la consulta para insertar en el orden correcto (email, password, rol, nombre)
        $sql = "INSERT INTO usuarios (email, password, rol, nombre) VALUES (?, ?, ?, ?)";

        // Preparar la consulta
        if ($stmt = $conn->prepare($sql)) {
            // Vincular los parámetros, en el orden de la base de datos
            $stmt->bind_param("ssss", $email, $password_hashed, $rol, $nombre); // 'ssss' porque son 4 parámetros de tipo string

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Registro exitoso. Ahora puedes iniciar sesión.";
                // Redirigir al usuario a la página de inicio de sesión
                header("Location: ../index.html");
                exit();
            } else {
                echo "Error al registrar: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
}

$conn->close();
?>
