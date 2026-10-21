<?php
header('Content-Type: application/json');
$host = 'SERVIDOR';
    $db   = 'BASE DE DATOS';  
    $user = 'USUARIO';        
    $pass =  'CONTRASEÑA';      
    $charset = 'utf8mb4';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

$sql = "SELECT fecha_limite FROM configuracion WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'fecha_limite' => $row['fecha_limite']]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró la fecha límite']);
}

$conn->close();
?>