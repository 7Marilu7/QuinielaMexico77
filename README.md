# Quiniela México 77

Sistema web para la gestión de una quiniela de fútbol en un entorno real, desarrollado con PHP, MySQL, HTML, CSS y JavaScript.

## Descripción

Quiniela México 77 es una aplicación web desarrollada para administrar una quiniela de fútbol, permitiendo a los participantes registrar sus pronósticos y consultar los resultados de los partidos.

El sistema cuenta con herramientas de administración para gestionar partidos, actualizar resultados, establecer fechas límite, configurar premios y controlar los pagos de los participantes. También permite calcular los puntajes y mostrar la clasificación de los participantes de acuerdo con sus resultados.

## Funcionalidades

- Registro de participantes y sus quinielas.
- Captura de pronósticos para los partidos.
- Selección de resultados: local, empate o visitante.
- Consulta de quinielas registradas.
- Visualización de resultados de los partidos.
- Cálculo automático de puntos obtenidos.
- Tabla de posiciones de los participantes.
- Identificación de ganadores.
- Identificación de segundo lugar.
- Identificación de quinielas perfectas.
- Identificación de quinielas con cero puntos.
- Administración de partidos.
- Registro, edición y eliminación de partidos.
- Actualización de resultados de los encuentros.
- Configuración de fechas límite para registrar quinielas.
- Configuración de montos de premios.
- Consulta y actualización del estado de pago de los participantes.
- Panel administrativo con inicio de sesión.
- Diseño adaptable a dispositivos móviles.

## Tecnologías utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- MySQLi
- PDO
- Fetch API
- JSON

## Estructura del proyecto

```text
Quiniela-Mexico77/
├── database/
├── index.php
├── quinielas.html
├── admin.php
├── conexion.php
├── login_admin.php
├── logout_admin.php
├── guardar_quiniela.php
├── obtener_quinielas.php
├── obtener_nombres.php
├── obtener_partidos.php
├── obtener_ganadores.php
├── nuevo_partido.php
├── eliminar_partido.php
├── guardar_cambios.php
├── guardar_fecha_limite.php
├── obtener_fecha_limite.php
├── guardar_montos.php
├── obtener_montos.php
├── actualizar_pago.php
├── borrar_quinielas.php
├── .gitignore
└── README.md
```

## Instalación local

1. Instala un entorno de desarrollo local como XAMPP, que incluye Apache, PHP y MySQL.

2. Clona este repositorio:

```bash
git clone https://github.com/7Marilu7/Quiniela-Mexico77.git
```

3. Coloca la carpeta del proyecto dentro del directorio `htdocs` de XAMPP.

4. Inicia los servicios de Apache y MySQL desde el panel de control de XAMPP.

5. Crea la base de datos MySQL correspondiente al proyecto e importa su estructura y datos iniciales.

6. Configura los datos de conexión a la base de datos en los archivos correspondientes del proyecto.

7. Abre el navegador y accede a:

`http://localhost/Quiniela-Mexico77/`

## Base de datos

El proyecto utiliza MySQL para almacenar y administrar información relacionada con:

- Participantes.
- Quinielas y pronósticos.
- Partidos.
- Resultados de los encuentros.
- Puntajes y posiciones.
- Montos de premios.
- Estado de pago de los participantes.
- Fechas límite de registro.

La conexión a la base de datos se realiza mediante PHP, utilizando MySQLi y PDO.

## Estado del proyecto

Proyecto desarrollado e implementado para la gestión de una quiniela de fútbol en un entorno real.

## Autoría

Desarrollado por **María Guadalupe Cruz Paz**.

[GitHub](https://github.com/7Marilu7)
