<?php
$host = "127.0.0.1";
$puerto = 3306;
$usuario = "root";
$password = "";
$base_datos = "proyecto_login_tp3";

$conn = new mysqli($host, $usuario, $password, $base_datos, $puerto);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
