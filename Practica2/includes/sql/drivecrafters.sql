-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-03-2024 a las 11:58:01
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drivecrafters`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tienda`
--

CREATE TABLE `tienda` (
  `articulo` text NOT NULL,
  `categoria` text NOT NULL,
  `precio` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `decripcion_breve` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tienda`
--

INSERT INTO `tienda` (`articulo`, `categoria`, `precio`, `descripcion`, `decripcion_breve`) VALUES
('Aceite para coche', 'mantenimiento', 30, 'El aceite 15W40 Diésel/Gasolina A3/B4 es un aceite multigrado de alta calidad basado en aceites minerales extremadamente refinados y aditivos seleccionados.\r\n\r\nProporciona excepcionales resultados en motores diésel o gasolina de aspiración atmosférica o\r\n\r\nturboalimentados tanto de automóviles como de furgonetas.\r\n\r\nLas propiedades principales del aceite 15W40 Diésel/Gasolina A3/B4 son:\r\n\r\n• Elevada resistencia a la oxidación.\r\n\r\n• Fortalece la protección del motor contra el desgaste.\r\n\r\n• Sobresalientes propiedades detergentes y dispersantes.\r\n\r\n•Este producto es adecuado para motores con catalizador.', 'El aceite 15W40 Diésel/Gasolina A3/B4 es un aceite multigrado de alta calidad basado en aceites minerales extremadamente refinados y aditivos seleccionados.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `NIF` text NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `correo` text NOT NULL,
  `password` text NOT NULL,
  `tipo_user` text NOT NULL,
  `id_taller` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`NIF`, `nombre`, `apellido`, `correo`, `password`, `tipo_user`, `id_taller`) VALUES
('1234567', 'cristiano', 'ronaldo', 'elbicho@gmail.com', 'messimalo', 'mecanico', ''),
('7654321', 'lionel', 'messi', 'lapulga@gmail.com', '202cb962ac59075b964b07152d234b70', '', ''),
('33', 'fernando', 'alonso', 'elnano@gmail.com', '33', 'admin', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
