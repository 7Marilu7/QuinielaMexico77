<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

if (!isset($_SESSION['login_intentos'])) {
    $_SESSION['login_intentos'] = 0;
    $_SESSION['login_bloqueo'] = 0;
}

if (time() < $_SESSION['login_bloqueo']) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Demasiados intentos. Espera 15 minutos.']);
    exit;
}

$usuario = $_POST['username'] ?? '';
$contrasena = $_POST['password'] ?? '';

$usuarioCorrecto = 'USUARIO';
$hashContrasena = 'HASHCONTRASEÑA';

if (
    is_string($usuario) &&
    is_string($contrasena) &&
    hash_equals($usuarioCorrecto, $usuario) &&
    password_verify($contrasena, $hashContrasena)
) {
    session_regenerate_id(true);
    $_SESSION['es_admin'] = true;
    $_SESSION['login_intentos'] = 0;
    $_SESSION['login_bloqueo'] = 0;

    echo json_encode(['success' => true]);
    exit;
}

$_SESSION['login_intentos']++;

if ($_SESSION['login_intentos'] >= 5) {
    $_SESSION['login_bloqueo'] = time() + 900;
    $_SESSION['login_intentos'] = 0;
}

http_response_code(401);
echo json_encode([
    'success' => false,
    'message' => 'Usuario o contraseña incorrectos.'
]);