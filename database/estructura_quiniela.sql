SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Estructura de tabla para la tabla `boton`
--

CREATE TABLE `boton` (
  `id` int(11) NOT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `valor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `fecha_limite` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `lado` enum('A','B') NOT NULL,
  `posicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `ganadores`
--

CREATE TABLE `ganadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `puntos` int(11) NOT NULL,
  `categoria` enum('ganador','segundo','perfecta','cero') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Estructura de tabla para la tabla `montos_premios`
--

CREATE TABLE `montos_premios` (
  `id` int(11) NOT NULL,
  `monto_ganador` decimal(10,2) NOT NULL,
  `monto_quiniela_perfecta` decimal(10,2) NOT NULL,
  `monto_quiniela_cero` decimal(10,2) NOT NULL,
  `monto_segundo_lugar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id` int(11) NOT NULL,
  `local` varchar(255) NOT NULL,
  `visitante` varchar(255) NOT NULL,
  `resultado` enum('local','empate','visitante') DEFAULT NULL,
  `horario` varchar(50) NOT NULL DEFAULT 'Horario no definido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `predicciones`
--

CREATE TABLE `predicciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `semi1` varchar(100) DEFAULT NULL,
  `semi2` varchar(100) DEFAULT NULL,
  `semi3` varchar(100) DEFAULT NULL,
  `semi4` varchar(100) DEFAULT NULL,
  `final_left` varchar(100) DEFAULT NULL,
  `final_right` varchar(100) DEFAULT NULL,
  `campeon` varchar(100) DEFAULT NULL,
  `puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `quinielas`
--

CREATE TABLE `quinielas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `selecciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ;

--
-- Estructura de tabla para la tabla `resultados_oficiales`
--

CREATE TABLE `resultados_oficiales` (
  `id` int(11) NOT NULL,
  `semi1` varchar(100) DEFAULT NULL,
  `semi2` varchar(100) DEFAULT NULL,
  `semi3` varchar(100) DEFAULT NULL,
  `semi4` varchar(100) DEFAULT NULL,
  `final_left` varchar(100) DEFAULT NULL,
  `final_right` varchar(100) DEFAULT NULL,
  `campeon` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indices de la tabla `boton`
--
ALTER TABLE `boton`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clave` (`clave`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ganadores`
--
ALTER TABLE `ganadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `montos_premios`
--
ALTER TABLE `montos_premios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `predicciones`
--
ALTER TABLE `predicciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resultados_oficiales`
--
ALTER TABLE `resultados_oficiales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boton`
--
ALTER TABLE `boton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ganadores`
--
ALTER TABLE `ganadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `montos_premios`
--
ALTER TABLE `montos_premios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `predicciones`
--
ALTER TABLE `predicciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `quinielas`
--
ALTER TABLE `quinielas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resultados_oficiales`
--
ALTER TABLE `resultados_oficiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
