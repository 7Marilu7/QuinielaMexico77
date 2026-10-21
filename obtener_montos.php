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

    $stmt = $pdo->prepare("
       SELECT 
    IFNULL(CAST(monto_ganador AS CHAR), '0') as monto_ganador,
    IFNULL(CAST(monto_quiniela_perfecta AS CHAR), '0') as monto_quiniela_perfecta,
    IFNULL(CAST(monto_quiniela_cero AS CHAR), '0') as monto_quiniela_cero,
    IFNULL(CAST(monto_segundo_lugar AS CHAR), '0') as monto_segundo_lugar
FROM montos_premios 
LIMIT 1;

    ");
    $stmt->execute();
    $montos = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$montos) {
        $montos = [
            'monto_ganador' => '0',
            'monto_quiniela_perfecta' => '0',
            'monto_quiniela_cero' => '0',
            'monto_segundo_lugar' => '0'
        ];
    }

    echo json_encode([
        'success' => true,
        'monto_ganador' => $montos['monto_ganador'],
        'monto_quiniela_perfecta' => $montos['monto_quiniela_perfecta'],
        'monto_quiniela_cero' => $montos['monto_quiniela_cero'],
        'monto_segundo_lugar' => $montos['monto_segundo_lugar']
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>