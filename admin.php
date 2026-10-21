<?php
  session_start();

if (empty($_SESSION['es_admin'])) {
    header('Location: index.php');
    exit;
}
$conn = new mysqli(
    'SERVIDOR',
    'USUARIO',
    'CONTRASEÑA' ,
    'BASE DE DATOS'
);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT fecha_limite FROM configuracion WHERE id = 1");
$fecha_limite = $result && $result->num_rows > 0 ? $result->fetch_assoc()['fecha_limite'] : null;
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>Administrador Quiniela México77</title>
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">
  
<style>
:root {
    --m77-navy: #1d3557;
    --m77-navy-hover: #294d79;
    --m77-green: #16834a;
    --m77-green-hover: #116b3b;
    --m77-border: #d9e0e8;
}
* {
    box-sizing: border-box;
}

html {
    width: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    background-color: #c7dcf3;
    background-image: linear-gradient(135deg, #e8f0fa 0%, #c7dcf3 100%);
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
    font-family: Arial, sans-serif;
    color: #263449;
}

@font-face {
    font-family: 'Cooper Black';
    src: url('CooperBlack.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.logo-wrapper {
    width: fit-content;
    max-width: 100%;
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
    width: 100%;
    font-family: 'Concert One', sans-serif;
    font-size: 1.1rem;
    color: #111;
    letter-spacing: 2px;
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
    margin-bottom: 1px;
    color: #111;
}

h1,
h2 {
    color: var(--m77-navy);
    text-align: center;
}

h1 {
    margin: 18px 0 22px;
}

.table-responsive {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto 20px;
    padding: 10px;
    overflow-x: auto;
    overflow-y: visible;
    -webkit-overflow-scrolling: touch;
    border: 1px solid #dce4ee;
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 6px 20px rgba(29, 52, 82, 0.12);
}

.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #e8f0fa;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #8ca6c5;
    border-radius: 10px;
}
#admin-quiniela {
    width: 100%;
    min-width: 0;
    margin: 0 auto;
    border-collapse: separate;
    border-spacing: 0;
    table-layout: auto;
    background: #fff;
    box-shadow: none;
}

#admin-quiniela th,
#admin-quiniela td {
    padding: 7px 6px;
    border-right: 1px solid #dce4ee;
    border-bottom: 1px solid #dce4ee;
    text-align: center;
    vertical-align: middle;
    font-size: 12px;
    line-height: 1.3;
}

#admin-quiniela tr > *:first-child {
    border-left: 1px solid #dce4ee;
}

#admin-quiniela th {
    background: var(--m77-navy);
    color: #fff;
    font-weight: bold;
    white-space: nowrap;
}

#admin-quiniela tbody tr:nth-child(even) {
    background: #f2f6fb;
}

#admin-quiniela tbody tr:hover {
    background: #e5effb;
}

#admin-quiniela input,
#admin-quiniela select {
    display: block;
    width: 100%;
    min-width: 0;
    max-width: 220px;
    margin: 0 auto;
    padding: 6px 4px;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    background: #fff;
    color: #263449;
    font-family: Arial, sans-serif;
    font-size: 12px;
}

#admin-quiniela input:focus,
#admin-quiniela select:focus {
    outline: none;
    border-color: #3275b9;
    box-shadow: 0 0 0 2px rgba(50, 117, 185, 0.14);
}

#admin-quiniela td:nth-child(4),
#admin-quiniela td:nth-child(5) {
    padding: 5px 4px;
    font-size: 11px;
}

#tabla-pagos {
    width: 100%;
    min-width: 0;
    max-width: 600px;
    margin: 0 auto;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    table-layout: fixed;
}

#tabla-pagos th,
#tabla-pagos td {
    padding: 6px 8px;
    border-right: 1px solid #dce4ee;
    border-bottom: 1px solid #dce4ee;
    text-align: center;
    vertical-align: middle;
    font-size: 12px;
}

#tabla-pagos tr > *:first-child {
    border-left: 1px solid #dce4ee;
}

#tabla-pagos th:nth-child(1),
#tabla-pagos td:nth-child(1) {
    width: 55%;
    text-align: left;
    overflow-wrap: anywhere;
}

#tabla-pagos th:nth-child(2),
#tabla-pagos td:nth-child(2) {
    width: 23%;
}

#tabla-pagos th:nth-child(3),
#tabla-pagos td:nth-child(3) {
    width: 22%;
}

#tabla-pagos th {
    background: var(--m77-navy);
    color: #fff;
    font-weight: bold;
}

#tabla-pagos tbody tr:nth-child(even) {
    background: #f2f6fb;
}

#tabla-pagos tbody tr:hover {
    background: #e5effb;
}

#tabla-pagos .btn-pago {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    min-height: 32px;
    margin: 0;
    padding: 0;
    border: none;
    border-radius: 50%;
    color: #fff;
    font-size: 19px;
    font-weight: bold;
    line-height: 1;
    cursor: pointer;
    transition: transform 0.15s ease, background-color 0.2s ease;
}

#tabla-pagos .btn-pago:hover {
    transform: scale(1.08);
    box-shadow: none;
}

#tabla-pagos .btn-pago.no-pagada {
    background: #c0392b;
}

#tabla-pagos .btn-pago.pagada {
    background: #16834a;
}

@media (max-width: 600px) {
    #tabla-pagos th,
    #tabla-pagos td {
        padding: 5px 6px;
        font-size: 11px;
    }

    #tabla-pagos .btn-pago {
        width: 30px;
        height: 30px;
        min-height: 30px;
        font-size: 18px;
    }
}
button {
    min-height: 38px;
    margin: 5px;
    padding: 9px 15px;
    border: none;
    border-radius: 9px;
    cursor: pointer;
    font-family: Arial, sans-serif;
    font-size: 13px;
    font-weight: 600;
    transition: background-color 0.2s ease,
                box-shadow 0.2s ease;
}

button:hover {
    box-shadow: 0 3px 8px rgba(29, 53, 87, 0.15);
}

#nuevo-partido {
    background: var(--m77-navy);
    color: #fff;
}

#nuevo-partido:hover {
    background: var(--m77-navy-hover);
}

#guardar-cambios {
    background: var(--m77-green);
    color: #fff;
}

#guardar-cambios:hover {
    background: var(--m77-green-hover);
}

.eliminar,
#borrar-quinielas {
    background: #c0392b;
    color: #fff;
}

.eliminar {
    min-height: 28px;
    padding: 6px 9px;
    border-radius: 6px;
    font-size: 11px;
}

#borrar-quinielas {
    padding: 12px 18px;
    border-radius: 9px;
}

#logout-btn {
    margin-top: 15px;
    padding: 12px 18px;
    border-radius: 9px;
    background: var(--m77-navy);
    color: #fff;
}
.contenedor-botones {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 8px;
    margin: 20px auto;
}

#montos-premios {
    display: none;
    width: 100%;
    max-width: 420px;
    margin: 20px auto;
    padding: 22px 18px;
    border: 1px solid #d5e2f0;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 5px 18px rgba(29, 53, 87, 0.12);
    text-align: center;
}

#montos-premios label {
    display: block;
    margin: 14px 0 6px;
    color: var(--m77-navy);
    font-size: 14px;
    font-weight: bold;
    text-align: left;
}

#montos-premios input {
    display: block;
    width: 100%;
    max-width: 100%;
    min-height: 44px;
    margin: 6px auto 12px;
    padding: 10px 12px;
    border: 1px solid #cbd8e6;
    border-radius: 9px;
    background: #f7faff;
    color: #263449;
    font-family: Arial, sans-serif;
    font-size: 16px;
}

#montos-premios input:focus {
    outline: none;
    border-color: var(--m77-green);
    box-shadow: 0 0 0 3px rgba(22, 131, 74, 0.12);
}

#montos-premios button {
    display: block;
    width: 100%;
    min-height: 44px;
    margin: 12px 0 0;
    padding: 11px 16px;
    border: none;
    border-radius: 9px;
    background: var(--m77-green);
    color: #fff;
    font-size: 14px;
    font-weight: bold;
}

#montos-premios button:hover {
    background: var(--m77-green-hover);
}

.login-message {
    max-width: 500px;
    margin: 25px auto;
    padding: 16px;
    border: 1px solid #f2b8b5;
    border-radius: 10px;
    background: #fff;
    color: #c0392b;
    text-align: center;
}

footer {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    min-height: 40px;
    height: auto;
    margin-top: 25px;
    padding: 12px 10px;
    border-radius: 8px;
    background: var(--m77-navy);
    color: #fff;
    text-align: center;
}

footer .copyright {
    width: 100%;
    text-align: center;
}
@media (max-width: 600px) {
    body {padding: 8px 5px;}

    .logo-mexico77 {
        margin-top: 30px;
        gap: 0.06em;
        font-size: clamp(2.7rem, 11vw, 4rem);}

    .logo-quiniela {
        font-size: 0.9rem;
        letter-spacing: 1.5px; }

    h1 {
        margin: 14px 0;
        font-size: 1.6rem;}

    h2 { font-size: 1.25rem;}

    .table-responsive {
        width: 100%;
        max-width: 100%;
        margin-bottom: 14px;
        padding: 0;
        border-radius: 10px;
        touch-action: pan-x pan-y;
    }
    #admin-quiniela {
        width: 100%;
        min-width: 0;
        table-layout: fixed;
    }

    #admin-quiniela th,
    #admin-quiniela td {
        padding: 4px 2px;
        font-size: 10px;
        overflow-wrap: anywhere;
    }

    #admin-quiniela th {
        white-space: normal;
    }

    #admin-quiniela td:nth-child(1),
    #admin-quiniela td:nth-child(2),
    #admin-quiniela td:nth-child(3) {
        width: 21%;
    }

    #admin-quiniela td:nth-child(4),
    #admin-quiniela td:nth-child(5) {
        width: 18.5%;
        padding: 3px 1px;
        font-size: 10px;
    }

    #admin-quiniela input,
    #admin-quiniela select {
        width: 100%;
        min-width: 0;
        max-width: 100%;
        padding: 4px 1px;
        border-radius: 4px;
        font-size: 10px;
    }

    #admin-quiniela button {
        min-height: 27px;
        margin: 1px 0;
        padding: 4px 2px;
        border-radius: 5px;
        font-size: 10px;
    }

    #admin-quiniela .eliminar {
        padding: 4px 2px;
        font-size: 9px;
    }

    #tabla-pagos {
        width: 100%;
        min-width: 300px;
        max-width: 100%;
    }

    #tabla-pagos th,
    #tabla-pagos td {
        padding: 6px 5px;
        font-size: 11px;
    }

    #montos-premios {
        width: 100%;
        max-width: 420px;
        margin: 16px auto;
        padding: 16px 12px;
        border-radius: 12px;
    }

    #montos-premios label {
        font-size: 13px;
    }

    #montos-premios input {
        font-size: 16px;
    }

    #montos-premios button {
        min-height: 46px;
        font-size: 14px;
    }

    .contenedor-botones {
        gap: 5px;
    }

    .contenedor-botones button {
        margin: 3px;
        padding: 10px 13px;
        font-size: 12px;
    }

    #botones-admin button {
        margin: 5px 2px;
    }

    footer {
        padding: 10px 6px;
        font-size: 12px;
    }
}

@media (max-width: 360px) {
    body {
        padding: 8px 3px;
    }

    .logo-mexico77 {
        font-size: clamp(2.4rem, 10.5vw, 2.7rem);
    }

    #admin-quiniela th,
    #admin-quiniela td {
        padding: 3px 1px;
        font-size: 9px;
    }

    #admin-quiniela input,
    #admin-quiniela select {
        padding: 3px 1px;
        font-size: 9px;
    }

    #admin-quiniela button {
        font-size: 9px;
    }

    .contenedor-botones button {
        padding: 9px 10px;
        font-size: 11px;
    }
}
    
#panel-fecha-limite {
    box-sizing: border-box;
    width: 100%;
    max-width: 420px;
    margin: 20px auto;
    padding: 22px 18px;
    border: 1px solid #244664;
    border-radius: 16px;
    background: #102a43;
    box-shadow: 0 6px 20px rgba(16, 42, 67, 0.2);
    text-align: left;
}

.fecha-limite-encabezado {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.fecha-limite-icono {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 52px;
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #244664;
    font-size: 26px;
}

.fecha-limite-encabezado h3 {
    margin: 0 0 6px;
    color: #fff;
    font-size: 20px;
}

.fecha-limite-encabezado p {
    margin: 0;
    color: #c6d8e7;
    font-size: 12px;
    line-height: 1.5;
}

#panel-fecha-limite label {
    display: block;
    margin: 0 0 10px;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
}

#panel-fecha-limite #fecha-limite {
    display: block;
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    min-height: 46px;
    margin: 0 0 14px;
    padding: 8px;
    border: 1px solid #cbd8e6;
    border-radius: 9px;
    background-color: #fff;
    color: #102a43;
    font-family: Arial, sans-serif;
    font-size: 15px;
    opacity: 1;
}

#panel-fecha-limite #fecha-limite:focus {
    outline: none;
    border-color: #63b3ed;
    box-shadow: 0 0 0 3px rgba(99, 179, 237, 0.2);
}

#panel-fecha-limite #guardar-fecha-limite {
    display: block;
    box-sizing: border-box;
    width: 100%;
    min-height: 46px;
    margin: 0;
    padding: 11px 16px;
    border: none;
    border-radius: 9px;
    background: #176b43;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
}

#panel-fecha-limite #guardar-fecha-limite:hover {
    background: #125735;
}

@media (max-width: 600px) {
    #panel-fecha-limite {
        width: 100%;
        max-width: 420px;
        margin: 16px auto;
        padding: 18px 12px;
        border-radius: 12px;
    }

    .fecha-limite-encabezado {
        gap: 10px;
        margin-bottom: 18px;
    }

    .fecha-limite-encabezado h3 {
        font-size: 18px;
    }

    .fecha-limite-encabezado p {
        font-size: 12px;
    }

    #panel-fecha-limite #fecha-limite {
        font-size: 16px;
    }
}   
    
#panel-fecha-limite {
    overflow: hidden;
}

#panel-fecha-limite #fecha-limite {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    margin-right: 0;
    padding-left: 6px;
    padding-right: 1px;
}

.contenedor-botones {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 12px;
    width: 100%;
    max-width: 480px;
    margin: 20px auto;
}

.contenedor-botones #borrar-quinielas,
.contenedor-botones #logout-btn {
    box-sizing: border-box;
    flex: 1 1 190px;
    max-width: 220px;
    min-height: 46px;
    margin: 0;
    padding: 12px 14px;
    border-radius: 9px;
    font-size: 13px;
    font-weight: bold;
}

.contenedor-botones #borrar-quinielas {
    background: #c0392b;
    color: #fff;
}

.contenedor-botones #logout-btn {
    background: var(--m77-navy);
    color: #fff;
}

@media (max-width: 600px) {
    .contenedor-botones {
        max-width: 420px;
        padding: 0 8px;
        gap: 10px;
    }

    .contenedor-botones #borrar-quinielas,
    .contenedor-botones #logout-btn {
        flex: 1 1 100%;
        width: 100%;
        max-width: none;
        min-height: 46px;
        margin: 0;
    }
}
</style>
</head>
<body>
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
    <h1 id="titulo-admin" style="text-align: center;">Administrador-Quinielas</h1>
    <div id="login-message" class="login-message" style="display:none;">
        Debes iniciar sesión como administrador
    </div>
    <div class="table-responsive">
    <table id="admin-quiniela" style="display:none;">
        <thead>
            <tr>
                <th>Local</th>
                <th>Visitante</th>
                <th>Horario</th>
                <th>Acciones</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody id="admin-partidos"></tbody>
    </table>
    </div>
    <div style="text-align: center; margin: 20px; display:none;" id="botones-admin">
        <button id="nuevo-partido">+ Añadir partido</button>
        <button id="guardar-cambios">Guardar cambios</button>
    </div>

    <h2 id="titulo-montos" style="text-align: center;">Premios</h2>
    <div id="montos-premios">
        <label for="monto-ganador">Ganador:</label>
        <input type="text" id="monto-ganador" placeholder="Monto al Ganador" pattern="\d*(\.\d{0,2})?"
            title="Solo números y hasta 2 decimales" inputmode="decimal">

        <label for="monto-quiniela-perfecta">Quiniela perfecta:</label>
        <input type="text" id="monto-quiniela-perfecta" placeholder="Monto Quiniela Perfecta"
            pattern="\d*(\.\d{0,2})?" title="Solo números y hasta 2 decimales" inputmode="decimal">

        <label for="monto-quiniela-cero">Quiniela de 0 puntos:</label>
        <input type="text" id="monto-quiniela-cero" placeholder="Monto Quiniela de 0 Puntos"
            pattern="\d*(\.\d{0,2})?" title="Solo números y hasta 2 decimales" inputmode="decimal">
        <label for="monto-segundo-lugar">Segundo lugar:</label>
 <input type="text" id="monto-segundo-lugar" placeholder="Monto Segundo Lugar"
        pattern="\d*(\.\d{0,2})?" title="Solo números y hasta 2 decimales" inputmode="decimal">

        <button id="guardar-montos">Guardar montos</button>
    </div>
<div id="panel-fecha-limite">
    <div class="fecha-limite-encabezado">
        <div class="fecha-limite-icono">📅</div>
        <div>
            <h3>Fecha límite</h3>
            <p>Configura hasta cuándo se aceptan las quinielas</p>
        </div>
    </div>

    <label for="fecha-limite">Selecciona la fecha y hora:</label>
    <input type="datetime-local" id="fecha-limite" name="fecha-limite">

    <button id="guardar-fecha-limite">Guardar fecha límite</button>
</div>

    <h2 style="text-align:center;">PAGOS</h2>
<div class="table-responsive">
  <table id="tabla-pagos" style="margin:auto; min-width:350px;">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>¿Pagó?</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody id="pagos-body"></tbody>
  </table>
</div>
        <div class="contenedor-botones">
        <button id="borrar-quinielas">Borrar quinielas</button>
        <button id="logout-btn">Cerrar sesión</button>
    </div>

    <footer>
        <div class="copyright">
            &copy; 2025 Quiniela México 77. Todos los derechos reservados.
        </div>
    </footer>

    <script>
        
function verificarSesion() {
    document.getElementById('admin-quiniela').style.display = 'table';
    document.getElementById('botones-admin').style.display = 'block';
    document.getElementById('montos-premios').style.display = 'block';
    document.getElementById('titulo-montos').style.display = 'block';
    document.getElementById('titulo-admin').style.display = 'block';
    document.getElementById('borrar-quinielas').style.display = 'inline-block';
    document.getElementById('logout-btn').style.display = 'inline-block';
    document.getElementById('panel-fecha-limite').style.display = 'block';
    document.getElementById('login-message').style.display = 'none';
}

verificarSesion();
        document.getElementById('logout-btn').addEventListener('click', () => {
    window.location.href = 'logout_admin.php';
});
        let partidos = [];
        const tbody = document.getElementById('admin-partidos');

        function renderizarPartidos() {
            fetch('obtener_partidos.php')
                .then(response => response.json())
                .then(data => {
                    partidos = data;
                    tbody.innerHTML = '';
                    partidos.forEach((partido, index) => {
                        const resultadoActual = partido.resultado || '';
                        const horarioActual = partido.horario || ''; 
                        tbody.innerHTML += `
                            <tr>
                                <td><input type="text" id="local-${index}" value="${partido.local}" /></td>
                                <td><input type="text" id="visitante-${index}" value="${partido.visitante}" /></td>
                                <td><input type="text" id="horario-${index}" value="${horarioActual}" placeholder="Ej: Sábado 19:00pm" /></td>
                                <td><button class="eliminar" data-id="${partido.id}">Eliminar</button></td>
                                <td>
                                    <select id="resultado-${index}">
                                        <option value="" ${resultadoActual === '' ? 'selected' : ''}>-- Sin resultado --</option>
                                        <option value="local" ${resultadoActual === 'local' ? 'selected' : ''}>Local</option>
                                        <option value="empate" ${resultadoActual === 'empate' ? 'selected' : ''}>Empate</option>
                                        <option value="visitante" ${resultadoActual === 'visitante' ? 'selected' : ''}>Visitante</option>
                                    </select>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error al cargar partidos:', error);
                    alert('Error al cargar los partidos');
                });
        }
       renderizarPartidos();
        
        document.getElementById('nuevo-partido').addEventListener('click', () => {
            fetch('nuevo_partido.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta de nuevo_partido.php:', data); 
                    if (data.success) {
                        renderizarPartidos();
                    } else {
                        alert("No se pudo agregar partido: " + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error en fetch nuevo_partido.php:', error);
                    alert('Error al añadir un nuevo partido');
                });
        });
        document.getElementById('guardar-cambios').addEventListener('click', () => {
            const updates = partidos.map((partido, index) => ({
                id: partido.id,
                local: document.getElementById(`local-${index}`).value.trim(),
                visitante: document.getElementById(`visitante-${index}`).value.trim(),
                resultado: document.getElementById(`resultado-${index}`).value || null 
            }));
    partidos.forEach((partido, index) => {
        updates[index].horario = document.getElementById(`horario-${index}`).value.trim();
    });
            for (let i = 0; i < updates.length; i++) {
                if (updates[i].local === '' || updates[i].visitante === '') {
                    alert('Los campos local y visitante no pueden estar vacíos.');
                    return;
                }
            }

            fetch('guardar_cambios.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updates)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Cambios guardados correctamente');
                        renderizarPartidos();
                    } else {
                        alert('No se pudieron guardar los cambios: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error al guardar cambios:', error);
                    alert('Error al guardar los cambios');
                });
        });
document.getElementById('admin-partidos').addEventListener('click', e => {
    if (e.target.classList.contains('eliminar')) {
        const id = e.target.getAttribute('data-id');

        if (confirm('¿Seguro que deseas eliminar este partido?')) {
            fetch('eliminar_partido.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({ id: id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Partido eliminado');
                        renderizarPartidos();
                    } else {
                        alert('No se pudo eliminar el partido: ' + (data.message || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error al eliminar partido:', error);
                    alert('Error al eliminar el partido');
                });
        }
    }
});
function cargarMontos() {
    fetch('obtener_montos.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('monto-ganador').value = data.monto_ganador;
            document.getElementById('monto-quiniela-perfecta').value = data.monto_quiniela_perfecta;
            document.getElementById('monto-quiniela-cero').value = data.monto_quiniela_cero;
            document.getElementById('monto-segundo-lugar').value = data.monto_segundo_lugar;
        }
    })
    .catch(error => console.error('Error al cargar montos:', error));
}

         document.getElementById('borrar-quinielas').addEventListener('click', () => {
    if (confirm('¿Estás seguro de que quieres borrar todas las quinielas? Esta acción no se puede deshacer.')) {
        fetch('borrar_quinielas.php', {
    method: 'POST',
    credentials: 'same-origin'
})
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('ultimasQuinielas');
                    const quinielasEnviadasContainer = document.querySelector('.contenedor-quinielas-enviadas');
                    if (quinielasEnviadasContainer) {
                        quinielasEnviadasContainer.innerHTML = '';
                    }

                    alert('¡Todas las quinielas han sido borradas!');
                } else {
                    alert('No se pudieron borrar las quinielas: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error al borrar las quinielas:', error);
                alert('Error al borrar las quinielas');
            });
    }
});

window.addEventListener('load', () => {
    fetch('obtener_fecha_limite.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.fecha_limite) {
                const fechaMysql = data.fecha_limite;
                const fechaInput = fechaMysql.replace(' ', 'T').slice(0, 16);
                const inputFecha = document.getElementById('fecha-limite');
                if (inputFecha) {
                    inputFecha.value = fechaInput;
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar la fecha límite:', error);
        });
});
        window.addEventListener('load', cargarMontos);


        document.getElementById('guardar-fecha-limite').addEventListener('click', () => {
            const fechaLimite = document.getElementById('fecha-limite').value;

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
                        alert('Error al guardar la fecha límite.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar la fecha límite.');
                });
        });
 
  document.getElementById('guardar-montos').addEventListener('click', () => {
    const montoGanador = document.getElementById('monto-ganador').value || '0';
    const montoQuinielaPerfecta = document.getElementById('monto-quiniela-perfecta').value || '0';
    const montoQuinielaCero = document.getElementById('monto-quiniela-cero').value || '0';
    const montoSegundoLugar = document.getElementById('monto-segundo-lugar').value || '0';

    const montos = {
        monto_ganador: montoGanador,
        monto_quiniela_perfecta: montoQuinielaPerfecta,
        monto_quiniela_cero: montoQuinielaCero,
        monto_segundo_lugar: montoSegundoLugar
    };

    fetch('guardar_montos.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(montos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Montos guardados correctamente');
            cargarMontos();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar');
    });
});

function cargarPagos() {
    fetch('obtener_quinielas.php') 
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById('pagos-body');
            tbody.innerHTML = '';
            const quinielas = data.quinielas || data; 

            quinielas.forEach(q => {
                const tr = document.createElement('tr');
                const estaPagada = Number(q.pagada) === 1;

tr.innerHTML = `
    <td>${q.nombre}</td>
    <td style="font-weight:bold; color:${estaPagada ? '#16834a' : '#c0392b'}">
        ${estaPagada ? 'Sí' : 'No'}
    </td>
    <td>
        <button
            class="btn-pago ${estaPagada ? 'pagada' : 'no-pagada'}"
            data-nombre="${q.nombre}"
            data-pagada="${estaPagada ? 0 : 1}"
            aria-label="${estaPagada ? 'Marcar como no pagada' : 'Marcar como pagada'}"
            title="${estaPagada ? 'Marcar como no pagada' : 'Marcar como pagada'}"
        >${estaPagada ? '✓' : '✕'}</button>
    </td>
`;

                tbody.appendChild(tr);
            });
        });
}

document.getElementById('pagos-body').addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-pago')) {
        console.log('Botón clicado:', e.target.dataset);
        const nombre = e.target.getAttribute('data-nombre');
        const pagada = e.target.getAttribute('data-pagada');

        fetch('actualizar_pago.php', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: `nombre=${encodeURIComponent(nombre)}&pagada=${pagada}`
})

        .then(r => r.json())
        .then(data => {
            if (data.success) {
                cargarPagos();
            } else {
                alert('Error al actualizar el pago: ' + (data.error || ''));
            }
        });
    }
});
cargarPagos();

function marcarPagada(nombre, nuevoEstado) {
    fetch('actualizar_pago.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `nombre=${encodeURIComponent(nombre)}&pagada=${nuevoEstado}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarPagos();
        } else {
            alert('Error al actualizar el pago');
        }
    });
}
cargarPagos();
    </script>
</body>
</html>