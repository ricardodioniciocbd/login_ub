<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_ub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($conn->real_escape_string($_POST['nombre']));
    $carrera = trim($conn->real_escape_string($_POST['carrera']));
    $num_control = trim($conn->real_escape_string($_POST['num_control']));
    $password = trim($_POST['password']);

    // Validaciones
    $errores = [];
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,}$/u', $nombre)) {
        $errores[] = 'El nombre debe tener al menos 3 letras y solo letras y espacios.';
    }
    if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,}$/u', $carrera)) {
        $errores[] = 'La carrera debe tener al menos 3 letras y solo letras y espacios.';
    }
    if (!preg_match('/^[0-9]{3,20}$/', $num_control)) {
        $errores[] = 'El número de control debe tener entre 6 y 20 dígitos numéricos.';
    }
    if (strlen($password) < 3) {
        $errores[] = 'La contraseña debe tener al menos 3 caracteres.';
    }

    if (count($errores) > 0) {
        echo '<script>alert("' . implode('\\n', $errores) . '"); window.location.href="registro.html";</script>';
        exit();
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, carrera, num_control, password) VALUES ('$nombre', '$carrera', '$num_control', '$password_hash')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?> 