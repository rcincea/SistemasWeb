-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2021 a las 00:02:07
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.15

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `unipetdb`
--
CREATE DATABASE IF NOT EXISTS `unipetdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `unipetdb`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animales`
--

DROP TABLE IF EXISTS `animales`;
CREATE TABLE `animales` (
  `ID` int(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `nacimiento` date DEFAULT NULL,
  `tipo` enum('perro','gato','otro') NOT NULL,
  `raza` varchar(20) DEFAULT NULL,
  `sexo` enum('macho','hembra') NOT NULL,
  `peso` decimal(3,1) DEFAULT NULL,
  `ingreso` date NOT NULL,
  `protectora` int(9) NOT NULL,
  `historia` text DEFAULT NULL,
  `ID_usuario` int(9) DEFAULT NULL,
  `urgente` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apadrinados`
--

DROP TABLE IF EXISTS `apadrinados`;
CREATE TABLE `apadrinados` (
  `ID_usuario` int(9) NOT NULL,
  `ID` int(9) NOT NULL,
  `cantidad` decimal(6,2) NOT NULL,
  `numero_tarjeta` bigint(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colabora`
--

DROP TABLE IF EXISTS `colabora`;
CREATE TABLE `colabora` (
  `ID` int(9) NOT NULL,
  `ID_usuario` int(9) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato_adopcion`
--

DROP TABLE IF EXISTS `contrato_adopcion`;
CREATE TABLE `contrato_adopcion` (
  `ID_usuario` int(9) NOT NULL,
  `ID` int(9) NOT NULL,
  `formulario` mediumtext NOT NULL,
  `estado` enum('EnTramite','PendCita','Rechazado','Aprobado','FaltDatos','EsperaRes') NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

DROP TABLE IF EXISTS `entradas`;
CREATE TABLE `entradas` (
  `ID_usuario` int(9) NOT NULL,
  `numero` int(10) NOT NULL,
  `hilo` int(10) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

DROP TABLE IF EXISTS `fichas`;
CREATE TABLE `fichas` (
  `ID` int(9) NOT NULL,
  `vacunas` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hilos`
--

DROP TABLE IF EXISTS `hilos`;
CREATE TABLE `hilos` (
  `NUMERO` int(10) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `fecha` date NOT NULL,
  `ID_usuario` int(9) NOT NULL,
  `comentario` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `protectoras`
--

DROP TABLE IF EXISTS `protectoras`;
CREATE TABLE `protectoras` (
  `ID` int(9) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjetas`
--

DROP TABLE IF EXISTS `tarjetas`;
CREATE TABLE `tarjetas` (
  `ID_usuario` int(9) NOT NULL,
  `numero_tarjeta` bigint(16) NOT NULL,
  `caducidad` varchar(5) NOT NULL,
  `cvv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
CREATE TABLE `transacciones` (
  `ID` int(9) NOT NULL,
  `ID_usuario` int(9) NOT NULL,
  `tarjeta` bigint(16) NOT NULL,
  `cantidad` decimal(6,2) NOT NULL,
  `ID_animal` int(9) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `entradascontrato`
--

DROP TABLE IF EXISTS `entradascontrato`;
CREATE TABLE `entradascontrato` (
  `ID` int(9) NOT NULL,
  `ID_usuario` int(9) NOT NULL,
  `ID_animal` int(9) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `ID` int(9) NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `telefono` int(9) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contraseña` varchar(70) NOT NULL,
  `nacimiento` date NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `tipo` enum('normal','veterinario','administrador','voluntario') NOT NULL,
  `creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animales`
--
ALTER TABLE `animales`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `protectora` (`protectora`),
  ADD KEY `adoptante` (`ID_usuario`) USING BTREE;

--
-- Indices de la tabla `apadrinados`
--
ALTER TABLE `apadrinados`
  ADD UNIQUE KEY `ID` (`ID`,`ID_usuario`),
  ADD KEY `ID_2` (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `colabora`
--
ALTER TABLE `colabora`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `contrato_adopcion`
--
ALTER TABLE `contrato_adopcion`
  ADD UNIQUE KEY `unicidad` (`ID_usuario`,`ID`) USING BTREE,
  ADD KEY `ID` (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `hilo` (`hilo`),
  ADD KEY `ID_usuario` (`ID_usuario`) USING BTREE;
 
 --
-- Indices de la tabla `entradascontrato`
--
ALTER TABLE `entradascontrato`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_solicitud` (`ID_animal`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD UNIQUE KEY `ID_2` (`ID`),
  ADD KEY `ID` (`ID`) USING BTREE;

--
-- Indices de la tabla `hilos`
--
ALTER TABLE `hilos`
  ADD PRIMARY KEY (`NUMERO`),
  ADD KEY `ID_usuario` (`ID_usuario`) USING BTREE;

--
-- Indices de la tabla `protectoras`
--
ALTER TABLE `protectoras`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD UNIQUE KEY `numero_tarjeta` (`numero_tarjeta`),
  ADD KEY `ID_usuario` (`ID_usuario`) USING BTREE;

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_animal` (`ID_animal`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animales`
--
ALTER TABLE `animales`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `colabora`
--
ALTER TABLE `colabora`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `numero` int(10) NOT NULL AUTO_INCREMENT;
  
--
-- AUTO_INCREMENT de la tabla `entradascontrato`
--
ALTER TABLE `entradascontrato`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `hilos`
--
ALTER TABLE `hilos`
  MODIFY `NUMERO` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `protectoras`
--
ALTER TABLE `protectoras`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animales`
--
ALTER TABLE `animales`
  ADD CONSTRAINT `animales_ibfk_1` FOREIGN KEY (`protectora`) REFERENCES `protectoras` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animales_ibfk_2` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `apadrinados`
--
ALTER TABLE `apadrinados`
  ADD CONSTRAINT `apadrinados_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `apadrinados_ibfk_2` FOREIGN KEY (`ID`) REFERENCES `animales` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `colabora`
--
ALTER TABLE `colabora`
  ADD CONSTRAINT `colabora` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contrato_adopcion`
--
ALTER TABLE `contrato_adopcion`
  ADD CONSTRAINT `contrato_adopcion_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `animales` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrato_adopcion_ibfk_2` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entradas_ibfk_2` FOREIGN KEY (`hilo`) REFERENCES `hilos` (`NUMERO`) ON DELETE CASCADE ON UPDATE CASCADE;
 
--
-- Filtros para la tabla `entradascontrato`
--
ALTER TABLE `entradascontrato`
  ADD CONSTRAINT `entrada_contrato1` FOREIGN KEY (`ID_animal`) REFERENCES `animales` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_contrato2` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `fichas_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `animales` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hilos`
--
ALTER TABLE `hilos`
  ADD CONSTRAINT `hilos_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarjetas`
--
ALTER TABLE `tarjetas`
  ADD CONSTRAINT `tarjetas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD CONSTRAINT `transacciones_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
