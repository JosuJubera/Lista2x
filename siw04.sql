-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2015 a las 01:05:29
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
  `Autor` varchar(30) COLLATE utf8_bin NOT NULL,
  `Album` varchar(30) COLLATE utf8_bin NOT NULL,
  `Valoracion` int(11) NOT NULL DEFAULT '0',
  `ValoracionSemanal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancionesplaylist`
--

CREATE TABLE IF NOT EXISTS `cancionesplaylist` (
  `playlist` int(11) NOT NULL,
  `cancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE IF NOT EXISTS `comentarios` (
`id` int(11) NOT NULL,
  `Usuario` varchar(20) COLLATE utf8_bin NOT NULL,
  `Reportes` int(11) NOT NULL,
  `Comentario` text COLLATE utf8_bin NOT NULL,
  `Playlist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `playlist`
--

CREATE TABLE IF NOT EXISTS `playlist` (
  `Id` int(11) NOT NULL,
  `Usuario` varchar(20) COLLATE utf8_bin NOT NULL,
  `Titulo` varchar(30) COLLATE utf8_bin NOT NULL,
  `Asunto` varchar(60) COLLATE utf8_bin NOT NULL,
  `Descripcion` text COLLATE utf8_bin NOT NULL,
  `Fecha` date NOT NULL,
  `Valoracion` int(11) NOT NULL DEFAULT '0',
  `ValoracionSemanal` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacioncanciones`
--

CREATE TABLE IF NOT EXISTS `puntuacioncanciones` (
  `Usuario` varchar(20) COLLATE utf8_bin NOT NULL,
  `Cancion` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Puntuacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacionesplaylist`
--

CREATE TABLE IF NOT EXISTS `puntuacionesplaylist` (
  `Usuario` varchar(20) COLLATE utf8_bin NOT NULL,
  `Playlist` int(11) NOT NULL,
  `Fecha` datetime NOT NULL,
  `Puntuacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `Usuario` varchar(20) COLLATE utf8_bin NOT NULL,
  `Correo` varchar(40) COLLATE utf8_bin NOT NULL,
  `Contraseina` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `Nombre`, `Usuario`, `Correo`, `Contraseina`) VALUES
(1, 'sergio', 'usergio', 'asd@asd.asd', '8cb2237d0679ca88db6464eac60da96345513964'),
(2, 'josu', 'Jub3r', '23rdw@#fwe,com', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'muyñ', 'muyñ', 'asd@asd.asd', '8cb2237d0679ca88db6464eac60da96345513964');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
 ADD PRIMARY KEY (`Titulo`,`Autor`), ADD UNIQUE KEY `Id` (`Id`);

--
-- Indices de la tabla `cancionesplaylist`
--
ALTER TABLE `cancionesplaylist`
 ADD PRIMARY KEY (`playlist`,`cancion`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
 ADD PRIMARY KEY (`id`), ADD KEY `Usuario` (`Usuario`);

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
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
