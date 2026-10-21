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

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID de partido inválido'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM partidos WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró el partido'
        ]);
    }

} catch (PDOException $e) {
    error_log("Error en eliminar_partido.php: " . $e->getMessage());
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Ocurrió un error al eliminar el partido.'
    ]);
}
?>