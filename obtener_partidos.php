<?php
header('Content-Type: application/json');

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

    $stmt = $pdo->query("SELECT id, local, visitante, resultado, horario FROM partidos");
    $partidos = $stmt->fetchAll();

    echo json_encode($partidos);
} catch (PDOException $e) {
    error_log("Error en obtener_partidos.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error al obtener los partidos']);
}
?>