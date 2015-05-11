-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2015 a las 21:20:30
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `siw04`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE IF NOT EXISTS `canciones` (
`Id` int(11) NOT NULL,
  `Titulo` varchar(30) COLLATE utf8_bin NOT NULL,
  `Artista` varchar(30) COLLATE utf8_bin NOT NULL,
  `Album` varchar(30) COLLATE utf8_bin NOT NULL,
  `Genero` varchar(30) COLLATE utf8_bin NOT NULL,
  `Año` year(4) NOT NULL,
  `Valoracion` int(11) NOT NULL DEFAULT '0',
  `ValoracionSemanal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`Id`, `Titulo`, `Artista`, `Album`, `Genero`, `Año`, `Valoracion`, `ValoracionSemanal`) VALUES
(1, 'Sugar', 'Maroon 5', 'V', 'Disco', 2015, 9, 10),
(2, 'dsa', 'yo', 'album', '<zx', 1995, 2, 4),
(3, 'dws', 'yo', 'otroalbum', 'iug', 1995, 9, 2),
(5, 'erfqerfc', 'refqerf', 'eqrfqerf', 'qrfqer', 2014, 5, 9),
(4, 'juu', 'otro', 'otromas', 'ghjv', 1995, 3, 3),
(14, 'mnbcv', 'bvcb', 'ouyio', 'uioy', 2053, 3, 7),
(6, 'qwerqwefc', 'bbyujtyujn', 'tyrhyb', 'ehgbeyhty', 2017, 2, 6),
(9, 'wegvwrgv', 'cvbfgb ', 'rtcwtg rt', 'vtyhvthn', 2014, 9, 6),
(11, 'wertfwerf', 'gfergvrth', 'gsdvfertyh', 'hethbvertb', 2053, 3, 7),
(12, 'wtrf vgfer', 'sdfgsfh', 'hjyj', 'htyhr', 2053, 3, 7),
(13, 'wwrgffer', 'sdfgzcvzdfssfh', 'hsdfgjyj', 'hsdfgsftyhr', 2053, 3, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
 ADD PRIMARY KEY (`Titulo`,`Artista`), ADD UNIQUE KEY `Id` (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
