
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$conn = new mysqli(
    'SERVIDOR',
    'USUARIO',
    'CONTRASEÑA',
    'BASE DE DATOS'
);

if ($conn->connect_error) {
    error_log("Error de conexión MySQL: " . $conn->connect_error);
    die("Error de conexión con la base de datos.");
}

$conn->set_charset('utf8mb4');
$torneo_habilitado = false;

$result = $conn->query(
    "SELECT valor FROM boton WHERE clave='torneo_habilitado'"
);

if ($result && $result->num_rows > 0) {
    $torneo_habilitado =
        $result->fetch_assoc()['valor'] === '1';
}

$fecha_limite = date(
    'Y-m-d H:i:s',
    strtotime('+1 week')
);

$result_fecha_limite = $conn->query(
    "SELECT fecha_limite FROM configuracion WHERE id = 1"
);

if ($result_fecha_limite && $result_fecha_limite->num_rows > 0) {
    $fecha_raw = $result_fecha_limite->fetch_assoc()['fecha_limite'];

    if (DateTime::createFromFormat('Y-m-d H:i:s', $fecha_raw) !== false) {
        $fecha_limite = $fecha_raw;
    } else {
        error_log("Formato de fecha inválido en BD: " . $fecha_raw);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-E11W5RFZDK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-E11W5RFZDK');
</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Quiniela México 77</title>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
<style>

html {
    width: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    background-color: #c7dcf3;
    background-image: linear-gradient(135deg, #e8f0fa 0%, #c7dcf3 100%);
    background-attachment: scroll;
}

body {
    width: 100%;
    min-width: 0;
    min-height: 100vh;
    min-height: 100dvh;
    margin: 0;
    padding: 20px;
    overflow-x: hidden;
    background: transparent;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
    color: #263449;
}
:root {
    --m77-navy: #1d3557;
    --m77-navy-hover: #294d79;
    --m77-green: #16834a;
    --m77-green-hover: #116b3b;
    --m77-border: #d9e0e8;
}
.quiniela-name-container {
    width: 50%;
    max-width: 600px;
    margin: 30px auto 10px;
    padding: 0 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    box-sizing: border-box;
    text-align: center;
}

#quinielaName {
    width: 150px;
    min-width: 150px;
    padding: 12px;
    font-size: 15px;
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    color: #263449;
    box-sizing: border-box;
}

#quinielaName:focus {
    border-color: #3275b9;
    box-shadow: 0 0 0 3px rgba(50, 117, 185, 0.14);
    outline: none;
}

.table-container {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding: 0 10px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    box-sizing: border-box;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(29, 52, 82, 0.12);
}

#quiniela {
    width: 100%;
    min-width: 400px;
    margin: 0 auto;
    border-collapse: collapse;
    white-space: nowrap;
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
}

#quiniela th,
#quiniela td {
    border: 1px solid #dce4ee;
    padding: 12px 10px;
    text-align: center;
    font-size: 14px;
}

#quiniela th {
    background-color: var(--m77-navy);
    color: #ffffff;
    font-weight: bold;
    letter-spacing: 0.3px;
}

#quiniela tbody tr:nth-child(even) {
    background-color: #f2f6fb;
}

#quiniela tbody tr:hover {
    background-color: #e5effb;
}

#quiniela input[type="radio"] {
    accent-color: var(--m77-green);
    cursor: pointer;
    transform: scale(1.1);
}
.action-button,
#login-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 44px;
    padding: 11px 24px;
    border: 1px solid transparent;
    border-radius: 50px;
    font-family: Arial, sans-serif;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    box-sizing: border-box;
    box-shadow: 0 2px 6px rgba(29, 53, 87, 0.08);
    transition: background-color 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
}

.action-button:hover,
#login-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(29, 53, 87, 0.14);
}

#enviar.action-button {
    background-color: var(--m77-green);
    color: #ffffff;
    border-color: var(--m77-green);
}

#enviar.action-button:hover {
    background-color: var(--m77-green-hover);
    border-color: var(--m77-green-hover);
}

.action-button-outline {
    background-color: #ffffff;
    color: var(--m77-navy);
    border-color: var(--m77-border);
}

.action-button-outline:hover {
    background-color: #f4f7fa;
    border-color: var(--m77-navy);
}

#show-login.action-button,
#login-btn {
    background-color: var(--m77-navy);
    color: #ffffff;
    border-color: var(--m77-navy);
}

#show-login.action-button:hover,
#login-btn:hover {
    background-color: var(--m77-navy-hover);
    border-color: var(--m77-navy-hover);
}

#admin-link.action-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 12px;
    width: 100%;
    margin: 24px auto;
    text-align: center;
    box-sizing: border-box;
}

#login-form {
    width: 100%;
    max-width: 340px;
    margin: 20px auto;
    padding: 22px;
    border: 1px solid var(--m77-border);
    border-radius: 18px;
    background-color: #ffffff;
    box-shadow: 0 5px 18px rgba(29, 53, 87, 0.07);
    box-sizing: border-box;
}

#login-form input {
    display: block;
    width: 100%;
    margin: 7px 0;
    padding: 12px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    box-sizing: border-box;
    font-size: 14px;
}

#login-form input:focus {
    border-color: var(--m77-navy);
    box-shadow: 0 0 0 3px rgba(29, 53, 87, 0.10);
    outline: none;
}

@font-face {
    font-family: 'Cooper Black';
    src: url('CooperBlack.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.logo-wrapper {
    width: fit-content;
    margin: 0 auto;
    position: relative;
}

.logo-container {
    position: relative;
    width: max-content;
    max-width: 100%;
    margin: 0 auto;
}

.logo-quiniela {
    position: absolute;
    top: -5px;
    right: 0;
    font-family: 'Concert One', sans-serif;
    font-size: 1.1rem;
    color: #111;
    letter-spacing: 2px;
    width: 100%;
    text-align: right;
}

.logo-mexico77 {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.1em;
    margin-top: 40px;
    font-family: 'Concert One', sans-serif;
    font-size: 4.8rem;
    font-weight: bold;
    white-space: nowrap;
}

.logo-me {
    color: #00843D;
}

.logo-xi {
    color: #fff;
    text-shadow: 1px 1px 2px #000;
}

.logo-co {
    color: #E10600;
}

.logo-77 {
    color: #111;
    margin-bottom: 1px;
}

footer {
    background-color: var(--m77-navy);
    color: #ffffff;
    padding: 10px;
    width: 100%;
    height: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
    border-radius: 8px;
    box-sizing: border-box;
}

footer .copyright {
    text-align: center;
    width: 100%;
}
@media (max-width: 600px) {
    body {
        padding: 8px 3px;
    }

    .quiniela-name-container {
        flex-direction: row;
        align-items: center;
        gap: 8px;
        width: 100%;
        max-width: 100%;
        padding: 0 4px;
        margin: 15px auto;
    }

    #quinielaName {
        flex: 1;
        width: auto;
        min-width: 0;
        max-width: 100%;
        font-size: 14px;
    }

    .table-container {
        max-width: 100%;
        padding: 0 2px;
        border-radius: 10px;
    }

    #quiniela {
        min-width: 380px;
    }

    #quiniela th,
    #quiniela td {
        padding: 6px 4px;
        font-size: 10px;
    }

    #admin-link.action-buttons {
        flex-direction: column;
        gap: 10px;
        margin: 20px auto;
    }

    #admin-link .action-button {
        width: min(100%, 260px);
    }

    .action-button,
    #login-btn {
        min-height: 42px;
        padding: 10px 18px;
        font-size: 13px;
    }

    #login-form {
        width: calc(100% - 20px);
        max-width: 340px;
        padding: 18px;
    }

    footer {
        height: auto;
        min-height: 40px;
        flex-wrap: wrap;
        gap: 5px;
    }
}
    @media screen and (max-width: 900px) and (orientation: landscape) {
        .table-responsive, .table-container {
    margin-left: 0 !important;
    margin-right: 0 !important;
    width: 100% !important;
  max-width: 100% !important;
}
    }

.info-quiniela {
    display: flex;
    justify-content: center;
    align-items: stretch;
    gap: 16px;
    width: 100%;
    max-width: 650px;
    margin: 24px auto;
    padding: 0 10px;
    box-sizing: border-box;
}

.info-quiniela-card {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
    background: #ffffff;
    border: 1px solid #d9e0e8;
    border-radius: 16px;
    box-shadow: 0 5px 16px rgba(29, 53, 87, 0.08);
    box-sizing: border-box;
}

.info-quiniela-icon {
    flex-shrink: 0;
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 24px;
}

.info-quiniela-costo .info-quiniela-icon {
    background: #e4f4e9;
}

.info-quiniela-fecha .info-quiniela-icon {
    background: #e7effb;
}

.info-quiniela-texto {
    min-width: 0;
}

.info-quiniela-label {
    margin: 0 0 6px;
    color: #64748b;
    font-size: 13px;
    line-height: 1.4;
}

.info-quiniela-valor {
    margin: 0;
    color: #1d3557;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.35;
    overflow-wrap: anywhere;
}

.info-quiniela-costo .info-quiniela-valor {
    color: #16834a;
    font-size: 27px;
}

.info-quiniela-detalle {
    margin: 5px 0 0;
    color: #64748b;
    font-size: 12px;
    line-height: 1.5;
}

@media (max-width: 600px) {
    .info-quiniela {
        gap: 8px;
        padding: 0 4px;
        margin: 18px auto;
    }

    .info-quiniela-card {
        gap: 8px;
        padding: 12px 9px;
        border-radius: 12px;
    }

    .info-quiniela-icon {
        width: 32px;
        height: 32px;
        font-size: 18px;
        border-radius: 9px;
    }

    .info-quiniela-label {
        font-size: 11px;
        margin-bottom: 5px;
    }

    .info-quiniela-valor {
        font-size: 15px;
    }

    .info-quiniela-costo .info-quiniela-valor {
        font-size: 22px;
    }

    .info-quiniela-detalle {
        font-size: 10px;
    }
}

.m77-bienvenida-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(0, 0, 0, 0.65);
    box-sizing: border-box;
}

.m77-bienvenida-modal {
    position: relative;
    width: 100%;
    max-width: 420px;
    padding: 35px 25px 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    text-align: center;
    box-sizing: border-box;
    animation: m77-bienvenida-entrada 0.3s ease-out;
}

.m77-bienvenida-cerrar {
    position: absolute;
    top: 10px;
    right: 14px;
    padding: 0;
    border: none;
    background: transparent;
    color: #666666;
    font-size: 30px;
    line-height: 1;
    cursor: pointer;
}

.m77-bienvenida-cerrar:hover {
    color: #1d3557;
}

.m77-bienvenida-titulo {
    margin: 0 25px 12px;
    color: #1d3557;
    font-size: 27px;
    font-weight: bold;
}

.m77-bienvenida-texto {
    margin: 0;
    color: #444444;
    font-size: 16px;
    line-height: 1.6;
}

.m77-bienvenida-destacado {
    display: block;
    margin-top: 12px;
    color: #16834a;
    font-size: 18px;
    font-weight: bold;
}

@keyframes m77-bienvenida-entrada {
    from {
        opacity: 0;
        transform: translateY(12px) scale(0.97);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 480px) {
    .m77-bienvenida-modal {
        padding: 32px 20px 25px;
    }

    .m77-bienvenida-titulo {
        font-size: 24px;
    }
}

.transferencia-card {
    width: 100%;
    max-width: 350px;
    margin: 12px auto;
    padding: 12px;
    background: #ffffff;
    border: 1px solid var(--m77-border);
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(29, 53, 87, 0.08);
    box-sizing: border-box;
}

.transferencia-titulo {
    margin: 0 0 6px;
    color: var(--m77-navy);
    font-size: 16px;
    font-weight: 700;
    text-align: center;
}

.transferencia-descripcion {
    margin: 0 0 10px;
    color: #64748b;
    font-size: 12px;
    line-height: 1.4;
    text-align: center;
}

.transferencia-dato {
    margin: 8px 0;
}

.transferencia-etiqueta {
    display: block;
    margin-bottom: 3px;
    color: #64748b;
    font-size: 12px;
}

.transferencia-valor {
    color: var(--m77-navy);
    font-size: 13px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.transferencia-clabe-fila {
    display: flex;
    align-items: center;
    gap: 8px;
}

.transferencia-clabe {
    flex: 1;
    min-width: 0;
    padding: 8px;
    background: #f2f6fb;
    border: 1px solid #dce4ee;
    border-radius: 7px;
    color: var(--m77-navy);
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.3px;
    overflow-wrap: anywhere;
}

#copiar-clabe {
    flex-shrink: 0;
    min-height: 34px;
    padding: 7px 10px;
    border: 1px solid var(--m77-navy);
    border-radius: 30px;
    background: var(--m77-navy);
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

#copiar-clabe:hover {
    background: var(--m77-navy-hover);
}

.transferencia-nota {
    margin: 10px 0 0;
    color: #64748b;
    font-size: 11px;
    line-height: 1.4;
}

@media (max-width: 600px) {
    .transferencia-card {
        max-width: 320px;
        margin: 10px auto;
        padding: 10px;
        border-radius: 10px;
    }

    .transferencia-titulo {
        font-size: 15px;
    }

    .transferencia-clabe-fila {
        align-items: stretch;
        flex-direction: column;
    }

    #copiar-clabe {
        width: 100%;
    }
}

footer {
    background-color: var(--m77-navy);
    color: #ffffff;
    padding: 10px;
    width: 100%;
    min-height: 40px;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 25px;
    border-radius: 8px;
    text-align: center;
    box-sizing: border-box;
}

footer .copyright {
    text-align: center;
    width: 100%;
}

@media (max-width: 600px) {
    footer {
        height: auto;
        min-height: 40px;
        padding: 10px 6px;
        font-size: 12px;
    }
}

@media screen and (max-width: 900px) and (orientation: landscape) {
    footer {
        margin-top: 12px;
        padding: 6px;
        font-size: 10px;
        width: 100%;
        max-width: 100%;
        margin-left: 0;
        margin-right: 0;
        border-radius: 0;
    }
}

</style>

</head>
<body>
<div
    id="m77-bienvenida-overlay"
    class="m77-bienvenida-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="m77-bienvenida-titulo"
    aria-describedby="m77-bienvenida-texto"
    style="display: none;"
>
    <div class="m77-bienvenida-modal">
        <button
            type="button"
            id="m77-bienvenida-cerrar"
            class="m77-bienvenida-cerrar"
            aria-label="Cerrar mensaje de bienvenida"
        >&times;</button>

        <h2 id="m77-bienvenida-titulo" class="m77-bienvenida-titulo">
           Quiniela México 77
        </h2>

        <p id="m77-bienvenida-texto" class="m77-bienvenida-texto">
           ¡Porque una cosa es saber de fútbol y otra muy distinta es atinarle!
            <span class="m77-bienvenida-destacado">
                Que comience la jornada
            </span>
        </p>
    </div>
</div>

    <div style="text-align: center;">
        <div class="logo-wrapper">
            <div class="logo-container">
              <span class="logo-quiniela">Quiniela</span>
              <div class="logo-mexico77">
                <span class="logo-me">MÉ</span>
                <span class="logo-xi">XI</span>
                <span class="logo-co">CO</span>
                <span class="logo-77">77</span>
              </div>
            </div>
          </div>          
    </div>
    <div class="quiniela-name-container">
        <label for="quinielaName">Nombre:</label>
        <input type="text" id="quinielaName" name="quinielaName">
    </div>
    <div class="table-container"> 
    <table id="quiniela">
        <thead>
            <tr>
                <th>Local</th>
                <th></th>
                <th>Empate</th>
                <th></th>
                <th>Visitante</th>
                <th>Horario</th>
            </tr>
        </thead>
        <tbody id="partidos">
            <!-- Aquí se cargarán los partidos dinámicamente -->
        </tbody>
    </table>
    </div>

<div class="info-quiniela">
    <div class="info-quiniela-card info-quiniela-costo">
        <div class="info-quiniela-icon" aria-hidden="true"> 💰</div>
        <div class="info-quiniela-texto">
            <p class="info-quiniela-label"> Costo por quiniela</p>
            <p class="info-quiniela-valor">$50.00</p>
            <p class="info-quiniela-detalle">Pesos mexicanos</p>
        </div>
    </div>
    <div class="info-quiniela-card info-quiniela-fecha">
        <div class="info-quiniela-icon" aria-hidden="true">🗓️ </div>
        <div class="info-quiniela-texto">
            <p class="info-quiniela-label">Fecha límite </p>
            <p class="info-quiniela-valor">
                <?php echo date('d/m/Y', strtotime($fecha_limite)); ?>
            </p>
            <p class="info-quiniela-detalle">Hora límite:
                <?php echo date('H:i:s', strtotime($fecha_limite)); ?>
            </p>
        </div>
    </div>

</div>

    <div style="text-align: center; margin-top: 20px;">
       <button id="enviar" class="action-button"> Enviar quiniela </button>
    </div><br>
    
<div class="transferencia-card">
    <h2 class="transferencia-titulo">Datos para transferencia</h2>
    <p class="transferencia-descripcion">
        Realiza tu pago por transferencia bancaria.
    </p>

    <div class="transferencia-dato">
        <span class="transferencia-etiqueta">Banco</span>
        <div class="transferencia-valor">SANTANDER</div>
    </div>

    <div class="transferencia-dato">
        <span class="transferencia-etiqueta">Titular de la cuenta</span>
        <div class="transferencia-valor">Francisco Cruz</div>
    </div>

    <div class="transferencia-dato">
        <span class="transferencia-etiqueta">CLABE interbancaria</span>
        <div class="transferencia-clabe-fila">
            <div class="transferencia-clabe" id="clabe-valor">
                014180567978316932
            </div>

            <button type="button" id="copiar-clabe">
                Copiar CLABE
            </button>
        </div>
    </div>

    <p class="transferencia-nota">
     Después de transferir, envía tu comprobante al 5578113560 e indica el nombre con el que registraste tus quinielas.
    </p>
</div>
    <div id="admin-link" class="action-buttons">
    <a href="quinielas.html"
       class="action-button action-button-outline">
        Resultados quiniela
    </a>

    <button id="show-login" class="action-button">
        Acceso admin
    </button>
</div>
    <div id="login-form" style="display: none;">
        <h2>Acceso administrador</h2>
        <input type="text" id="username" placeholder="Usuario">
        <input type="password" id="password" placeholder="Contraseña">
        <button id="login-btn">Iniciar sesión</button>
    </div>
</div>
    <script>      
const loginForm = document.getElementById('login-form');
const showLoginBtn = document.getElementById('show-login');
const loginBtn = document.getElementById('login-btn');

showLoginBtn.addEventListener('click', () => {
    loginForm.style.display =
        loginForm.style.display === 'none' ? 'block' : 'none';
});

loginBtn.addEventListener('click', async () => {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('Ingresa tu usuario y contraseña.');
        return;
    }

    loginBtn.disabled = true;

    try {
        const response = await fetch('login_admin.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: username,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            window.location.href = 'admin.php';
        } else {
            alert(data.message || 'Usuario o contraseña incorrectos.');
        }
    } catch (error) {
        alert('No se pudo verificar el acceso. Intenta más tarde.');
    } finally {
        loginBtn.disabled = false;
    }
});
        let partidos = [];
        function cargarPartidos() {
            const tbody = document.getElementById('partidos'); 
            fetch('obtener_partidos.php')
                .then(response => response.json())
                .then(data => {
                    partidos = data;
                    tbody.innerHTML = '';

                    partidos.forEach((partido, index) => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><input type="radio" name="partido${index}" value="local"></td>
                            <td class="equipo">${partido.local}</td>
                            <td><input type="radio" name="partido${index}" value="empate"></td>
                            <td class="equipo">${partido.visitante}</td>
                            <td><input type="radio" name="partido${index}" value="visitante"></td>
                            <td class="horario">${partido.horario}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cargar los partidos');
                });
        }
        cargarPartidos();

        document.getElementById('enviar').addEventListener('click', async function(e) {
    e.preventDefault(); 

    const permitido = await validarFechaLimite();
    if (!permitido) {
        return; 
    }

    const quinielaName = document.getElementById('quinielaName').value.trim();
    if (!quinielaName) {
        alert('Por favor, ingresa un nombre para la quiniela.');
        return;
    }

const nombresDuplicados = await fetch('obtener_nombres.php')
    .then(res => res.json())
    .then(data => data.nombres.map(n => n.toLowerCase().trim()));

if (nombresDuplicados.includes(quinielaName.toLowerCase())) {
    alert('Ese nombre ya ha sido usado. Por favor elige uno diferente (puedes agregar un número, emoji o variación).');
    return;
}

    const quinielaData = {
        name: quinielaName,
        selections: []
    };

    let todasSeleccionadas = true;
    partidos.forEach((partido, index) => {
        const selectedOption = document.querySelector(`input[name="partido${index}"]:checked`);
        if (selectedOption) {
            quinielaData.selections.push(selectedOption.value);
        } else {
            quinielaData.selections.push(null);
            todasSeleccionadas = false;
        }
    });

    if (!todasSeleccionadas) {
        alert('Por favor, selecciona una opción para cada partido.');
        return;
    }
    document.getElementById('quinielaName').value = '';
    document.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);

    fetch('guardar_quiniela.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(quinielaData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Quiniela enviada correctamente.');
        } else {
            alert('Error al enviar la quiniela: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la quiniela');
    });
});

document.getElementById('guardar-fecha-limite').addEventListener('click', () => {
    const fechaLimite = document.getElementById('fecha-limite').value;

    if (!fechaLimite) {
        alert('Por favor, selecciona una fecha y hora límite válida.');
        return;
    }

    fetch('guardar_fecha_limite.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'fecha_limite=' + encodeURIComponent(fechaLimite)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Fecha límite guardada correctamente.');
        } else {
            alert('Error al guardar la fecha límite: ' + (data.message || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error al guardar fecha límite:', error);
        alert('Error al guardar la fecha límite.');
    });
});

async function validarFechaLimite() {
    try {
        const response = await fetch('obtener_fecha_limite.php');
        const data = await response.json();

        if (!data.success) {
            alert('No se pudo obtener la fecha límite. Intenta más tarde.');
            return false;
        }

        const fechaLimite = new Date(data.fecha_limite);
        const ahora = new Date();

        if (ahora > fechaLimite) {
            alert('El tiempo para enviar la quiniela ha expirado.');
            return false;
        }

        return true;
    } catch (error) {
        console.error('Error al validar fecha límite:', error);
        alert('Error al validar la fecha límite. Intenta más tarde.');
        return false;
    }
}
        const adminLink = document.getElementById('admin-link');
        document.body.appendChild(adminLink);
    </script>
    <footer>
        <div class="copyright">
            &copy; 2025 Quiniela México 77. Todos los derechos reservados.
        </div>
    </footer>  
    
<script>
(function () {
    const overlay = document.getElementById('m77-bienvenida-overlay');
    const botonCerrar = document.getElementById('m77-bienvenida-cerrar');
    const claveSesion = 'm77_bienvenida_mostrada';

    if (!overlay || !botonCerrar) {
        return;
    }

    try {
        if (!sessionStorage.getItem(claveSesion)) {
            sessionStorage.setItem(claveSesion, '1');
            overlay.style.display = 'flex';
        }
    } catch (error) {
        overlay.style.display = 'flex';
    }

    botonCerrar.addEventListener('click', function () {
        overlay.style.display = 'none';
    });
})();
</script>
<script>
document.getElementById('copiar-clabe').addEventListener('click', async function () {
    const clabe = document.getElementById('clabe-valor').textContent.trim();

    try {
        await navigator.clipboard.writeText(clabe);
        this.textContent = '¡CLABE copiada!';
    } catch (error) {
        alert('No se pudo copiar automáticamente. Selecciona y copia la CLABE manualmente.');
    }
});
</script>
</body>
</html>