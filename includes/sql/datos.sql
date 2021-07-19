-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2021 a las 23:39:43
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.15

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

--
-- Volcado de datos para la tabla `animales`
--

INSERT INTO `animales` (`ID`, `nombre`, `nacimiento`, `tipo`, `raza`, `sexo`, `peso`, `ingreso`, `protectora`, `historia`, `ID_usuario`, `urgente`) VALUES
(1, 'Winkie', '2015-09-06', 'perro', 'Teckel', 'hembra', '4.2', '2021-04-15', 1, 'Mucho texto', 7, 0),
(2, 'Coco', '2021-04-15', 'gato', NULL, 'hembra', '3.0', '2021-04-15', 1, NULL, NULL, 1),
(3, 'Thor', '2021-04-15', 'perro', 'Labrador', 'macho', '32.0', '2021-04-15', 1, 'TEXTO', 4, 0),
(4, 'Max', '2021-04-15', 'gato', NULL, 'macho', NULL, '2021-04-15', 2, NULL, NULL, 0),
(5, 'Rocky', '2021-04-15', 'gato', NULL, 'macho', NULL, '2021-04-15', 1, NULL, NULL, 0),
(6, 'Acua', '2021-04-15', 'gato', NULL, 'hembra', NULL, '2021-04-15', 2, NULL, NULL, 0),
(7, 'Hannah', NULL, 'perro', NULL, 'hembra', NULL, '2021-04-16', 2, NULL, NULL, 0),
(8, 'Bianca', '2021-04-15', 'perro', 'Samoyedo', 'hembra', NULL, '2021-04-15', 3, NULL, NULL, 1),
(9, 'Leo', '2021-04-15', 'gato', NULL, 'macho', NULL, '2021-04-15', 1, NULL, NULL, 0),
(10, 'Ava', '2021-04-15', 'gato', 'Scottish Fold', 'hembra', '2.9', '2021-04-15', 2, 'En el momento que Rares entró a la protectora, él y Ava se miraron y su conexión fue instantáneo, forjando una unión que nada los separará.', 4, 0),
(11, 'Simba', '2021-04-15', 'perro', NULL, 'macho', NULL, '2021-04-15', 3, NULL, NULL, 0),
(12, 'Cloe', '2021-04-15', 'perro', NULL, 'hembra', NULL, '2021-04-15', 1, NULL, NULL, 0),
(13, 'Lucas', '2021-04-15', 'gato', NULL, 'macho', NULL, '2021-04-15', 1, NULL, NULL, 0),
(14, 'Frida', '2021-04-15', 'gato', 'Persa', 'hembra', '3.8', '2021-04-15', 1, 'Desde que conoció a Enrique, se volvió el gato más feliz de toda España.', 1, 0),
(15, 'Zeus', '2021-04-15', 'perro', NULL, 'macho', NULL, '2021-04-15', 3, NULL, NULL, 0),
(16, 'Iris', '2021-04-15', 'perro', NULL, 'hembra', NULL, '2021-04-15', 2, NULL, NULL, 1);


--
-- Volcado de datos para la tabla `apadrinados`
--

INSERT INTO `apadrinados` (`ID`, `ID_usuario`, `cantidad`) VALUES
(7, 4, '5.00');

--
-- Volcado de datos para la tabla `contrato_adopcion`
--

INSERT INTO `contrato_adopcion` (`ID_usuario`, `ID`, `formulario`, `estado`, `fecha`) VALUES
(7, 1, 'Mucho texto', 'Aprobado', '2021-04-15'),
(7, 12, 'Mucho texto', 'Rechazado', '2021-04-15'),
(3, 4, 'Mucho texto', 'EnTramite', '2021-04-15'),
(3, 8, 'Mucho texto', 'PendCita', '2021-04-15'),
(2, 14, 'Texto', 'Aprobado', '2021-04-15'),
(2, 3, 'TEXTO', 'Aprobado', '2021-04-15'),
(1, 10, 'TEXTO', 'Aprobado', '2021-04-15'),
(1, 15, '¿Has tenido (o tienes) animales? si \r\n								¿En que tipo de domicilio vives diariamente? ninguno \r\n								¿Viven niños en el mismo domicilio en el que se encontrará el animal? no \r\n								¿Cuantas horas estaría solo el animal? 24\r\n								¿Cual es tu motivación por adoptar un animal? tengo hambre', 'EnTramite', '2021-04-16');

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`ID_usuario`, `numero`, `hilo`, `comentario`, `fecha`) VALUES
(3, 1, 1, 'Hola!\r\nPara poder adoptar a un animal debes de ir a la publicación de alguno de ellos y darle al botón de \"Adoptar\", siempre y cuando estés registrado claro. Posteriormente debes de rellenar el formulario para iniciar el proceso de adopción y cuando lo envíes algún chico/a de la protectora te avisará para proseguir.\r\n', '2021-04-16');

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`ID`, `vacunas`, `observaciones`) VALUES
(1, 'Se ha puesto todas las vacunas', 'Muy mona pero súper hiperactiva');

--
-- Volcado de datos para la tabla `hilos`
--

INSERT INTO `hilos` (`NUMERO`, `titulo`, `fecha`, `ID_usuario`, `comentario`) VALUES
(1, '¿Cómo se adopta?', '2021-04-15', 7, 'Hola!, soy nuevo aquí y no sé cómo se adopta, alguien me echa una mano?');

--
-- Volcado de datos para la tabla `protectoras`
--

INSERT INTO `protectoras` (`ID`, `nombre`, `direccion`, `telefono`) VALUES
(1, 'Protectora Madrid Centro', 'Av. de Concha Espina, 1, 28036 Madrid', 697638858),
(2, 'Protectora Barcelona', 'C. d Arístides Maillol, 12, 08028 Barcelona', 697638858),
(3, 'Protectora Madrid (Moncloa)', 'Calle del Prof. José García Santesmases, 9, 28040 ', 913947501);

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `DNI`, `nombre`, `apellido`, `telefono`, `email`, `contraseña`, `nacimiento`, `direccion`, `tipo`, `creacion`) VALUES
(1, '00000000A', 'Enrique', 'Juez de Miceli', 672336821, 'ejuez@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '1999-03-25', 'Ninguna', 'voluntario', '2021-04-15'),
(2, '00000001A', 'Alberto', 'Bañegil Díaz', 619229128, 'abanegil@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '2021-04-15', 'Ninguna', 'administrador', '2021-04-15'),
(3, '00000002A', 'Aurora', 'Daza Llin', 658049474, 'adaza@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '1999-04-20', 'Ninguna', 'voluntario', '2021-04-15'),
(4, '00000003A', 'Rares', 'Petrisor Cincea', 663873473, 'rcincea@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '1997-10-12', 'Ninguna', 'veterinario', '2021-04-15'),
(6, '51739423A', 'Maria', 'Nuñez Conde', 666999333, 'marinu@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '2000-11-22', 'Ninguna', 'normal', '2021-04-15'),
(7, '54494722V', 'Fabrizio', 'Alcaraz Escobar', 697638858, 'fabrialc@ucm.es', '$2y$10$uM6NtF.f6e.1Ffu2rMWYV.j.X8lhWq9l8PwJcs9/ioVKTGqink6DG', '2000-07-22', 'Ninguna', 'normal', '2021-04-15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
