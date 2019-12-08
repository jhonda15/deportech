-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2019 a las 21:48:03
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `deportes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `idEquipos` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEventos` int(10) NOT NULL,
  `idPartido` int(10) NOT NULL,
  `idTipoEvento` int(10) NOT NULL,
  `tiempo` time NOT NULL,
  `timestam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `idJugadores` int(5) NOT NULL,
  `documento` bigint(12) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` bigint(11) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `eps` varchar(30) NOT NULL,
  `talla` varchar(15) NOT NULL,
  `peso` varchar(15) NOT NULL,
  `dominacion` varchar(15) NOT NULL,
  `numeroCamisa` int(3) NOT NULL,
  `edad` int(2) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `idPartido` int(10) NOT NULL,
  `observaciones` varchar(300) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(30) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `campeonato` varchar(25) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiciones`
--

CREATE TABLE `posiciones` (
  `idPosicion` int(2) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `posiciones`
--

INSERT INTO `posiciones` (`idPosicion`, `nombre`) VALUES
(1, 'portero'),
(2, 'Defensa Central Izquierda'),
(3, 'Defensa central Derecho'),
(4, 'Defensa Lateral Izquierda'),
(5, 'Defensa Lateral Derecha'),
(6, 'Volante Marca Derecha'),
(7, 'Volante Marca Central'),
(8, 'Volante Marca Izquierda'),
(9, 'Volante Mixto Derecho'),
(10, 'Volante Mixto Izquierda'),
(11, 'Carrilero Derecho'),
(12, 'Carrilero Izquierdo'),
(13, 'Volante de Creacion'),
(14, 'Extremos'),
(15, 'Delantero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evento`
--

CREATE TABLE `tipo_evento` (
  `idTipoEvento` int(10) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `u_id` int(11) NOT NULL,
  `documento` bigint(11) NOT NULL,
  `u_nombre` varchar(20) NOT NULL,
  `u_apellido` varchar(20) NOT NULL,
  `direccion` varchar(30) NOT NULL,
  `telefono` bigint(11) NOT NULL,
  `correo` varchar(40) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`u_id`, `documento`, `u_nombre`, `u_apellido`, `direccion`, `telefono`, `correo`, `password`) VALUES
(1, 123456789, 'admin', 'admin', 'admin', 1234567, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 1088304727, 'jhon', 'ortiz', 'dorado', 3104106647, 'jhonda1231@gmail.com', 'a923cce42164ac1c1fc0d3af18e8a049'),
(3, 1088304727, 'uni', 'uno', 'uno', 15454, 'uno', '1088304727');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD KEY `idEquipos` (`idEquipos`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD KEY `idEventos` (`idEventos`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD KEY `idJugadores` (`idJugadores`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD KEY `idPartido` (`idPartido`);

--
-- Indices de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  ADD KEY `idPosicion` (`idPosicion`);

--
-- Indices de la tabla `tipo_evento`
--
ALTER TABLE `tipo_evento`
  ADD KEY `idTipoEvento` (`idTipoEvento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD KEY `idUsuario` (`u_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `idEquipos` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `idJugadores` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `idPartido` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  MODIFY `idPosicion` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tipo_evento`
--
ALTER TABLE `tipo_evento`
  MODIFY `idTipoEvento` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
