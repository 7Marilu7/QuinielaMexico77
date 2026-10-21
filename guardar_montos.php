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

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (
        !isset($data['monto_ganador']) || 
        !isset($data['monto_quiniela_perfecta']) || 
        !isset($data['monto_quiniela_cero']) || 
        !isset($data['monto_segundo_lugar'])
    ) {
        throw new Exception('Datos incompletos');
    }

    $pdo->exec("INSERT IGNORE INTO montos_premios (id, monto_ganador, monto_quiniela_perfecta, monto_quiniela_cero, monto_segundo_lugar)
                VALUES (1, 0, 0, 0, '')");

    $stmt = $pdo->prepare("
        UPDATE montos_premios SET
            monto_ganador = :monto_ganador,
            monto_quiniela_perfecta = :monto_quiniela_perfecta,
            monto_quiniela_cero = :monto_quiniela_cero,
            monto_segundo_lugar = :monto_segundo_lugar
        WHERE id = 1
    ");

    $stmt->execute([
        ':monto_ganador' => $data['monto_ganador'],
        ':monto_quiniela_perfecta' => $data['monto_quiniela_perfecta'],
        ':monto_quiniela_cero' => $data['monto_quiniela_cero'],
        ':monto_segundo_lugar' => $data['monto_segundo_lugar']
    ]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>