-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2015 a las 22:21:45
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `siw06`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE IF NOT EXISTS `administradores` (
  `Nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `Apellido1` varchar(30) COLLATE utf8_bin NOT NULL,
  `Apellido2` varchar(30) COLLATE utf8_bin NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Correo` varchar(30) COLLATE utf8_bin NOT NULL,
  `Contraseña` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`Nombre`, `Apellido1`, `Apellido2`, `Usuario`, `Correo`, `Contraseña`) VALUES
('', '', '', 'Jub3r', '', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
('ser', 'ser', 'ser', 'usergio', 'asd.asd.asd', '8cb2237d0679ca88db6464eac60da96345513964');

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
  `ValoracionSemanal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`Id`, `Titulo`, `Artista`, `Album`, `Genero`, `Año`, `ValoracionSemanal`) VALUES
(2, 'Loba', 'Shakira', 'album', 'Pop', 2009, 4),
(1, 'Sugar', 'Maroon 5', 'V', 'Disco', 2015, 10),
(3, 'dws', 'yo', 'otroalbum', 'iug', 1995, 2),
(5, 'erfqerfc', 'refqerf', 'eqrfqerf', 'qrfqer', 2014, 9),
(4, 'juu', 'otro', 'otromas', 'ghjv', 1995, 3),
(14, 'mnbcv', 'bvcb', 'ouyio', 'uioy', 2053, 7),
(6, 'qwerqwefc', 'bbyujtyujn', 'tyrhyb', 'ehgbeyhty', 2017, 6),
(9, 'wegvwrgv', 'cvbfgb ', 'rtcwtg rt', 'vtyhvthn', 2014, 6),
(11, 'wertfwerf', 'gfergvrth', 'gsdvfertyh', 'hethbvertb', 2053, 7),
(12, 'wtrf vgfer', 'sdfgsfh', 'hjyj', 'htyhr', 2053, 7),
(13, 'wwrgffer', 'sdfgzcvzdfssfh', 'hsdfgjyj', 'hsdfgsftyhr', 2053, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancionesplaylist`
--

CREATE TABLE IF NOT EXISTS `cancionesplaylist` (
  `playlist` int(11) NOT NULL,
  `cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `cancionesplaylist`
--

INSERT INTO `cancionesplaylist` (`playlist`, `cancion`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
`Id` int(11) NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Reportes` int(11) NOT NULL,
  `Comentario` text COLLATE utf8_bin NOT NULL,
  `Playlist` int(11) NOT NULL,
  `Ignorado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`Id`, `Usuario`, `Reportes`, `Comentario`, `Playlist`, `Ignorado`) VALUES
(3, 'Usergio', 5, 'cabron!', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
`Id` int(11) NOT NULL,
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `Asunto` varchar(60) COLLATE utf8_bin NOT NULL,
  `Descripcion` text COLLATE utf8_bin NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Valoracion` int(11) NOT NULL DEFAULT '0',
  `ValoracionSemanal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `playlist`
--

INSERT INTO `playlist` (`Id`, `Usuario`, `Nombre`, `Asunto`, `Descripcion`, `Fecha`, `Valoracion`, `ValoracionSemanal`) VALUES
(1, 'Jub3r', 'Caribe Mix', 'CAnciones verano', 'Las mejores canciones del verano 2015', '2015-05-10 00:00:00', 10, 9),
(2, 'Jub3r', 'Caribe Mix', 'CAnciones verano', 'Las mejores canciones del verano 2015', '2015-05-10 00:00:00', 10, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacioncanciones`
--

CREATE TABLE IF NOT EXISTS `puntuacioncanciones` (
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Cancion` int(11) NOT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Valoracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `puntuacioncanciones`
--

INSERT INTO `puntuacioncanciones` (`Usuario`, `Cancion`, `Fecha`, `Valoracion`) VALUES
('Jub3r', 1, '2015-05-10 00:00:00', 7),
('Jub3r', 2, NULL, 6),
('muyñ', 1, NULL, 1),
('muyñ', 2, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacionesplaylist`
--

CREATE TABLE IF NOT EXISTS `puntuacionesplaylist` (
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Playlist` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Valoracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `Usuario` varchar(30) COLLATE utf8_bin NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `Apellido1` varchar(30) COLLATE utf8_bin NOT NULL,
  `Apellido2` varchar(30) COLLATE utf8_bin NOT NULL,
  `Correo` varchar(40) COLLATE utf8_bin NOT NULL,
  `Contraseña` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Usuario`, `Nombre`, `Apellido1`, `Apellido2`, `Correo`, `Contraseña`) VALUES
('Jub3r', '', '', '', '', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
('Usergio', 'sergio', '', '', 'asd@asd.asd', '8cb2237d0679ca88db6464eac60da96345513964'),
('muyñ', 'muyñ', '', '', 'asd@asd.asd', '8cb2237d0679ca88db6464eac60da96345513964');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
 ADD PRIMARY KEY (`Nombre`), ADD UNIQUE KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
 ADD PRIMARY KEY (`Titulo`,`Artista`), ADD UNIQUE KEY `Id` (`Id`);

--
-- Indices de la tabla `cancionesplaylist`
--
ALTER TABLE `cancionesplaylist`
 ADD PRIMARY KEY (`playlist`,`cancion`), ADD KEY `fk_cancion` (`cancion`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
 ADD PRIMARY KEY (`Id`), ADD KEY `Usuario` (`Usuario`), ADD KEY `fk_playlist_coment` (`Playlist`);

--
-- Indices de la tabla `playlist`
--
ALTER TABLE `playlist`
 ADD PRIMARY KEY (`Id`), ADD KEY `Usuario` (`Usuario`);

--
-- Indices de la tabla `puntuacioncanciones`
--
ALTER TABLE `puntuacioncanciones`
 ADD PRIMARY KEY (`Usuario`,`Cancion`), ADD KEY `Cancion` (`Cancion`);

--
-- Indices de la tabla `puntuacionesplaylist`
--
ALTER TABLE `puntuacionesplaylist`
 ADD PRIMARY KEY (`Usuario`,`Playlist`), ADD KEY `Playlist` (`Playlist`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `playlist`
--
ALTER TABLE `playlist`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cancionesplaylist`
--
ALTER TABLE `cancionesplaylist`
ADD CONSTRAINT `fk_cancion` FOREIGN KEY (`cancion`) REFERENCES `canciones` (`Id`),
ADD CONSTRAINT `fk_playlist` FOREIGN KEY (`playlist`) REFERENCES `playlist` (`Id`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`),
ADD CONSTRAINT `fk_playlist_coment` FOREIGN KEY (`Playlist`) REFERENCES `playlist` (`Id`);

--
-- Filtros para la tabla `playlist`
--
ALTER TABLE `playlist`
ADD CONSTRAINT `playlist_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`);

--
-- Filtros para la tabla `puntuacioncanciones`
--
ALTER TABLE `puntuacioncanciones`
ADD CONSTRAINT `puntuacioncanciones_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`),
ADD CONSTRAINT `puntuacioncanciones_ibfk_2` FOREIGN KEY (`Cancion`) REFERENCES `canciones` (`Id`);

--
-- Filtros para la tabla `puntuacionesplaylist`
--
ALTER TABLE `puntuacionesplaylist`
ADD CONSTRAINT `puntuacionesplaylist_ibfk_1` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`Usuario`),
ADD CONSTRAINT `puntuacionesplaylist_ibfk_2` FOREIGN KEY (`Playlist`) REFERENCES `playlist` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
