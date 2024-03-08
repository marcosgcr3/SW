-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2024 a las 11:29:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `nif` varchar(9) NOT NULL,
  `estado` tinyint(1) NOT NULL,
   PRIMARY KEY (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
 `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL UNIQUE,
  `precio` float NOT NULL,
  `descripcion` text NOT NULL,
  `unidades` int(11) NOT NULL,
  `imagen` text NOT NULL,
   PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `descripcion`, `unidades`, `imagen`) VALUES
(1, 'Aceite de motor', 22, 'Aceite para todo tipo de motores', 45, 'img/imgProductos/aceite.png'),
(2, 'frenos', 34, 'liquido de frenos', 67, 'img/imgProductos/frenos.png'),
(3, 'Neumatico', 23, 'Nuematicos nuevos de 22 pulgadas', 8, '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NIF` varchar(9) NOT NULL UNIQUE,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `correo` text NOT NULL,
  `password` text NOT NULL,
  `rol` text NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`NIF`, `nombre`, `apellido`, `correo`, `password`, `rol`) VALUES
('', '', '', '', '', ''),
('12', 'pepe', 'peres', 'pepe@gmail.com', '$2y$10$RSE/bu0FF67rcqWU/i6BPO/jhmP0VMYAyRvn4vz62gsPPb.OWgHE6', 'usuario'),
('1234567', 'cristiano', 'ronaldo', 'elbicho@gmail.com', 'messimalo', 'mecanico'),
('123456789', 'ghj', 'ghj', 'hgj@gmail.com', '$2y$10$8iYgOYrv.WTNpD.1XfaIXewG8IWk4rXcaF4M5u0GaTjPd4HPHMRGW', 'usuario'),
('33', 'fernando', 'alonso', 'elnano@gmail.com', '33', 'admin'),
('5151', 'marcos', 'gomez', 'marcos@gmail.com', '$2y$10$hDYEcSH2d0sP0oEq67j/sOg5OpuC/579V90yYOdr8N6DMNv/FDC36', 'admin'),
('7654321', 'lionel', 'messi', 'lapulga@gmail.com', '202cb962ac59075b964b07152d234b70', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `FK_pedido_usuario` (`nif`);

--
-- Indices de la tabla `productos`
--
--
-- Indices de la tabla `usuarios`
--


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_pedido_usuario` FOREIGN KEY (`nif`) REFERENCES `usuarios` (`NIF`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
