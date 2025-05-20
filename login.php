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
    $num_control = trim($conn->real_escape_string($_POST['num_control']));
    $password = trim($_POST['password']);
    $errores = [];
    if (!preg_match('/^[0-9]{6,20}$/', $num_control)) {
        $errores[] = 'El número de control debe tener entre 6 y 20 dígitos numéricos.';
    }
    if (strlen($password) < 6) {
        $errores[] = 'La contraseña debe tener al menos 6 caracteres.';
    }
    if (count($errores) > 0) {
        echo '<script>alert("' . implode('\\n', $errores) . '"); window.location.href="index.html";</script>';
        exit();
    }
    $sql = "SELECT * FROM usuarios WHERE num_control = '$num_control'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            header("Location: usuario.html");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Número de control no encontrado.'); window.location.href='index.html';</script>";
    }
}
$conn->close();
?> 