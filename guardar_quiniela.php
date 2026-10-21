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

    if (empty($data['name']) || empty($data['selections'])) {
        throw new Exception('Datos incompletos');
    }

    $stmt = $pdo->prepare("INSERT INTO quinielas (nombre, selecciones) VALUES (?, ?)");
    $selecciones_json = json_encode($data['selections']);
    $stmt->execute([$data['name'], $selecciones_json]);
    echo json_encode(['success' => true]);

} catch (Exception $e) {

    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>