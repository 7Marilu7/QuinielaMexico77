<?php
header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli('SERVIDOR', 'USUARIO', 'CONTRASEÑA', 'BASE DE DATOS');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => $conn->connect_error]);
    exit;
}

$conn->set_charset('utf8mb4');

$nombre = isset($_POST['nombre']) ? urldecode($_POST['nombre']) : '';
$pagada = isset($_POST['pagada']) ? intval($_POST['pagada']) : 0;

if ($nombre !== '') {
    $stmt = $conn->prepare("UPDATE quinielas SET pagada=? WHERE nombre=?");
    $stmt->bind_param('is', $pagada, $nombre);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se actualizó ningún registro. Verifica el nombre.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
}

$conn->close();
?>