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
    $num_control = $conn->real_escape_string($_POST['num_control']);
    $sql = "SELECT * FROM usuarios WHERE num_control = '$num_control'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        header("Location: usuario.html");
        exit();
    } else {
        echo "<script>alert('Número de control no encontrado.'); window.location.href='index.html';</script>";
    }
}
$conn->close();
?> 