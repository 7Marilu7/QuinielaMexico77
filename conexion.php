
<?php
$host = 'SERVIDOR';
$db   = 'BASE DE DATOS';
$user = 'USUARIO';
$pass = 'CONTRASEÑA';
$charset = 'utf8mb4';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión con la base de datos.");
}

$conn->set_charset($charset);
$conn->query("SET time_zone = '-06:00'");