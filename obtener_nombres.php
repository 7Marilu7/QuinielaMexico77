<?php
header('Content-Type: application/json');

try {
    $host = 'SERVIDOR';
    $db   = 'BASE DE DATOS';
    $user = 'USUARIO';
    $pass = 'CONTRASEÑA';
    $charset = 'utf8mb4';

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $stmt = $pdo->query("SELECT nombre FROM quinielas");
    $nombres = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode(['nombres' => $nombres]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>