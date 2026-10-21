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
    $stmtPartidos = $pdo->query("SELECT id, local, visitante, resultado, horario FROM partidos ORDER BY id");
    $partidos = $stmtPartidos->fetchAll();
    $stmtQuinielas = $pdo->query("SELECT nombre, selecciones, puntos, pagada  FROM quinielas");
    $quinielasRaw = $stmtQuinielas->fetchAll();

    $quinielas = array_map(function($q) {
        return [
            "nombre" => $q['nombre'],
            "selecciones" => json_decode($q['selecciones'], true), 
            "puntos" => (int)$q['puntos'],
            "pagada" => (int)$q['pagada'] 
        ];
    }, $quinielasRaw);

    echo json_encode([
        "partidos" => $partidos,
        "quinielas" => $quinielas
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error al obtener los datos: ' . $e->getMessage()]);
}
?>