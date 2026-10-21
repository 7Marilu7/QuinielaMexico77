<?php
header('Content-Type: application/json');

try {
    $host = 'SERVIDOR';
    $db   = 'BASE DE DATOS';
    $user = 'USUARIO';
    $pass = 'CONTRASEÑA';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    $resultadoIncompleto = $pdo->query("SELECT COUNT(*) FROM partidos WHERE resultado IS NULL")->fetchColumn();

    if ($resultadoIncompleto > 0) {
        echo json_encode([
            'estado' => 'incompleto'
        ]);
        exit;
    }

    $totalPartidos = $pdo->query("SELECT COUNT(*) FROM partidos")->fetchColumn();
    $stmt = $pdo->query("SELECT id, nombre, puntos FROM quinielas ORDER BY puntos DESC, id ASC");
    $quinielasCompletas = $stmt->fetchAll();

    $quinielas = [];
    $perfectas = [];

    foreach ($quinielasCompletas as $q) {
        if ((int)$q['puntos'] === (int)$totalPartidos) {
            $perfectas[] = $q;
        } else {
            $quinielas[] = $q;
        }
    }

    $ganadores = [
        'ganador' => [],
        'segundo' => null,
        'perfecta' => null,
        'cero' => null,
        'estado' => 'completo' 
    ];

if (!empty($perfectas)) {
    $ganadores['perfecta'] = array_map(function($q) {
        return ['id' => $q['id'], 'nombre' => $q['nombre']];
    }, $perfectas);
}

if (!empty($quinielas)) {
    $puntosGanador = $quinielas[0]['puntos'];
    foreach ($quinielas as $q) {
        if ($q['puntos'] === $puntosGanador) {
            $ganadores['ganador'][] = ['id' => $q['id'], 'nombre' => $q['nombre']];
        } else {
            break;
        }
    }

    $puntosSegundo = null;
    foreach ($quinielas as $q) {
        if ($q['puntos'] < $puntosGanador && $q['puntos'] > 0) {
            $puntosSegundo = $q['puntos'];
            break;
        }
    }

    if ($puntosSegundo !== null) {
        foreach ($quinielas as $q) {
            if ($q['puntos'] === $puntosSegundo) {
                $ganadores['segundo'] = ['id' => $q['id'], 'nombre' => $q['nombre']];
                break;
            }
        }
    }

    $ganadores['cero'] = [];
    foreach ($quinielas as $q) {
        if ($q['puntos'] === 0) {
            $ganadores['cero'][] = ['id' => $q['id'], 'nombre' => $q['nombre']];
        }
    }

    if (empty($ganadores['cero'])) {
        $ganadores['cero'] = null;
    }
}

if (empty($ganadores['ganador'])) {
    $ganadores['ganador'] = null;
}
    echo json_encode($ganadores);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>