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
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $carrera = $conn->real_escape_string($_POST['carrera']);
    $num_control = $conn->real_escape_string($_POST['num_control']);

    $sql = "INSERT INTO usuarios (nombre, carrera, num_control) VALUES ('$nombre', '$carrera', '$num_control')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?> 