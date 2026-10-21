<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['es_admin'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'No autorizado'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

try {
    $host = 'SERVIDOR';
    $db   = 'BASE DE DATOS';
    $user = 'USUARIO';
    $pass =  'CONTRASEÑA';  
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->prepare(
        "INSERT INTO partidos (local, visitante) VALUES (?, ?)"
    );
    $stmt->execute(['Local', 'Visitante']);

    $nuevoPartidoId = $pdo->lastInsertId();

    if ($nuevoPartidoId) {
        echo json_encode([
            'success' => true,
            'id' => $nuevoPartidoId
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo agregar el partido'
        ]);
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Ocurrió un error al agregar el partido.'
    ]);
}
?>