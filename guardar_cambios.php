<?php
session_start();

if (empty($_SESSION['es_admin'])) {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'No autorizado'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
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
    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        throw new Exception('Datos de entrada inválidos');
    }

    $pdo->beginTransaction();

    $stmtUpdatePartido = $pdo->prepare("UPDATE partidos SET local = ?, visitante = ?, horario = ?, resultado = ? WHERE id = ?");

    foreach ($input as $partido) {
        $id = $partido['id'];
        $local = $partido['local'];
        $visitante = $partido['visitante'];
        $horario = $partido['horario'] ?? 'Horario no definido';
        $resultado = $partido['resultado'] ?? null;
        if ($resultado === '') $resultado = null;

        $stmtUpdatePartido->execute([$local, $visitante, $horario, $resultado, $id]);
    }

    $stmtPartidos = $pdo->query("SELECT id, resultado FROM partidos ORDER BY id");
    $resultadosPartidos = $stmtPartidos->fetchAll();
    $resultados = [];
    foreach ($resultadosPartidos as $p) {
        $resultados[] = $p['resultado']; 
    }
    $stmtQuinielas = $pdo->query("SELECT id, selecciones FROM quinielas");
    $quinielas = $stmtQuinielas->fetchAll();

    $stmtUpdatePuntos = $pdo->prepare("UPDATE quinielas SET puntos = ? WHERE id = ?");

    foreach ($quinielas as $quiniela) {
        $selecciones = json_decode($quiniela['selecciones'], true);
        $puntos = 0;

        foreach ($selecciones as $index => $seleccion) {
            if (!isset($resultados[$index])) continue; 
            if ($resultados[$index] === null) continue; 

            if ($seleccion === $resultados[$index]) {
                $puntos++;
            }
        }

        $stmtUpdatePuntos->execute([$puntos, $quiniela['id']]);
    }

    $pdo->commit();

    echo json_encode(['success' => true]);

} catch (Exception $e) {
   if (isset($pdo) && $pdo->inTransaction()) {
    $pdo->rollBack();
}
   error_log($e->getMessage());
http_response_code(500);
echo json_encode([
    'success' => false,
    'message' => 'Ocurrió un error al guardar los cambios.'
]);
}
?>