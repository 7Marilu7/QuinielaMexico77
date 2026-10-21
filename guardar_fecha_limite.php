<?php
header('Content-Type: application/json');
$conn = new mysqli(
    'SERVIDOR',
    'USUARIO',
    'CONTRASEÑA' ,
    'BASE DE DATOS'
  );
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$fecha_limite = $_POST['fecha_limite'] ?? '';

if (!$fecha_limite) {
    echo json_encode(['success' => false, 'message' => 'Fecha límite no proporcionada']);
    exit;
}
$fecha_limite_mysql = str_replace('T', ' ', $fecha_limite) . ':00';
$fecha_limite_mysql = $conn->real_escape_string($fecha_limite_mysql);

$sql = "UPDATE configuracion SET fecha_limite = '$fecha_limite_mysql' WHERE id = 1";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
?>
