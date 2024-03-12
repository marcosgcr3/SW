-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2024 a las 16:34:33
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
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_vehiculo` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `precioFinal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id_alquiler`, `id_usuario`, `id_vehiculo`, `fecha_inicio`, `fecha_fin`, `precioFinal`) VALUES
(3, 2, 26, '0000-00-00', '0000-00-00', 0),
(4, 2, 24, '0000-00-00', '0000-00-00', 0),
(5, 2, 21, '0000-00-00', '0000-00-00', 0),
(6, 2, 2, '0000-00-00', '0000-00-00', 0),
(7, 2, 4, '0000-00-00', '0000-00-00', 0),
(8, 2, 5, '0000-00-00', '0000-00-00', 0),
(9, 2, 7, '0000-00-00', '0000-00-00', 0),
(10, 2, 8, '2024-03-12', '2024-03-16', 0),
(11, 2, 10, '2024-03-12', '2024-03-15', 3900),
(12, 2, 10, '2024-03-13', '2024-03-06', 9100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `id_usuario`, `estado`, `precio_total`) VALUES
(25, 8, 0, 0),
(26, 8, 0, 0),
(27, 8, 0, 0),
(28, 8, 0, 0),
(29, 8, 0, 0),
(30, 8, 0, 0),
(31, 8, 0, 0),
(32, 8, 0, 0),
(33, 8, 0, 0),
(34, 8, 0, 0),
(35, 8, 0, 0),
(36, 8, 0, 0),
(37, 8, 0, 0),
(38, 8, 0, 0),
(39, 8, 0, 0),
(40, 8, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_producto`
--

CREATE TABLE `pedido_producto` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `precio` float NOT NULL,
  `descripcion` text NOT NULL,
  `unidades` int(11) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `descripcion`, `unidades`, `imagen`) VALUES
(3, 'Neumatico', 23, 'Nuematicos nuevos de 22 pulgadas', 8, 'img/imgProductos/neumatico.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `NIF` varchar(9) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `correo` text NOT NULL,
  `password` text NOT NULL,
  `rol` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `NIF`, `nombre`, `apellido`, `correo`, `password`, `rol`) VALUES
(2, '12', 'pepe', 'peres', 'pepe@gmail.com', '$2y$10$RSE/bu0FF67rcqWU/i6BPO/jhmP0VMYAyRvn4vz62gsPPb.OWgHE6', 'usuario'),
(3, '1234567', 'cristiano', 'ronaldo', 'elbicho@gmail.com', 'messimalo', 'mecanico'),
(4, '123456789', 'ghj', 'ghj', 'hgj@gmail.com', '$2y$10$8iYgOYrv.WTNpD.1XfaIXewG8IWk4rXcaF4M5u0GaTjPd4HPHMRGW', 'usuario'),
(5, '33', 'fernando', 'alonso', 'elnano@gmail.com', '33', 'admin'),
(6, '5151', 'marcos', 'gomez', 'marcos@gmail.com', '$2y$10$hDYEcSH2d0sP0oEq67j/sOg5OpuC/579V90yYOdr8N6DMNv/FDC36', 'admin'),
(7, '7654321', 'lionel', 'messi', 'lapulga@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(8, '243524534', 'wedfwaf', 'wsdw', 'wed@gmail.com', '$2y$10$/GQqud7wtaKYez/WSOqSjeB3YmIkoT4ASrMn38I6Eit8eeCQRRsQW', 'usuario'),
(9, '123987658', 'Marcos', 'ewd', 'papa@gmail.com', '$2y$10$o5scwI8bAQ72gyAWGakVqeggq1mhqiEyJNBnNxrqWdSAnqJz4WGEK', 'usuario'),
(10, '984759857', 'Marcos', 'ewd', 'paadpa@gmail.com', '$2y$10$im9lPcRt8mNxOlQMF8yRhu9AIn/.7zI/8GY8c5Z4LgG71XkCSQj.m', 'usuario'),
(12, '000000000', 'Marcos', 'Gomez', 'lagarto@gmail.com', '$2y$10$IGlIFQvB75s3Q6eG1s3GLu5IoI1myTSnD2.t7ulMDv/cL9ug/xt0y', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id_vehiculo` int(11) NOT NULL,
  `matricula` text NOT NULL,
  `marca` text NOT NULL,
  `modelo` text NOT NULL,
  `precio` double NOT NULL,
  `year` int(11) NOT NULL,
  `disponibilidad` text NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `matricula`, `marca`, `modelo`, `precio`, `year`, `disponibilidad`, `imagen`) VALUES
(2, '5678DEF', 'Porsche', '911', 1500, 1990, 'no', 'img/imgVehiculos/porsche911.png'),
(3, '9012GHI', 'BMW', 'M5', 1600, 2020, 'no', 'img/imgVehiculos/bmwm5.png'),
(4, '3456JKL', 'BMW', 'X3', 1200, 2015, 'no', 'img/imgVehiculos/bmwx3.png'),
(5, '7890MNO', 'BMW', 'Serie 1', 1100, 2018, 'no', 'img/imgVehiculos/bmwserie1.png'),
(6, '1234PQR', 'BMW', 'Serie 3', 1300, 2019, 'no', 'img/imgVehiculos/bmwserie3.png'),
(7, '5678STU', 'Audi', 'A3', 1000, 2017, 'no', 'img/imgVehiculos/audia3.png'),
(8, '9012VWX', 'Audi', 'A4', 1100, 2018, 'no', 'img/imgVehiculos/audia4.png'),
(9, '3456YZA', 'Audi', 'Q3', 1200, 2016, 'no', 'img/imgVehiculos/audiq3.png'),
(10, '7890BCD', 'Audi', 'Q5', 1300, 2019, 'no', 'img/imgVehiculos/audiq5.png'),
(11, '1234EFG', 'Mercedes', 'Clase A', 1100, 2018, 'si', 'img/imgVehiculos/mercedesclasea.png'),
(12, '5678HIJ', 'Mercedes', 'Clase B', 1200, 2017, 'si', 'img/imgVehiculos/mercedesclaseb.png'),
(13, '9012KLM', 'Mercedes', 'Clase C', 1300, 2016, 'no', 'img/imgVehiculos/mercedesclasec.png'),
(14, '3456NOP', 'Mercedes', 'Clase GLA', 1400, 2019, 'si', 'img/imgVehiculos/mercedesclasegla.png'),
(15, '7890QRS', 'Toyota', 'Corolla', 900, 2020, 'si', 'img/imgVehiculos/toyotacorolla.png'),
(16, '1234TUV', 'Ford', 'Focus', 800, 2019, 'si', 'img/imgVehiculos/fordfocus.png'),
(17, '5678WXY', 'Honda', 'Civic', 850, 2018, 'si', 'img/imgVehiculos/hondacivic.png'),
(18, '9012ZAB', 'Volkswagen', 'Golf', 900, 2017, 'no', 'img/imgVehiculos/vwgolf.png'),
(19, '3456CDE', 'Renault', 'Clio', 750, 2020, 'si', 'img/imgVehiculos/renaultclio.png'),
(20, '7890FGH', 'Seat', 'Ibiza', 700, 2019, 'si', 'img/imgVehiculos/seatibiza.png'),
(21, '1234IJK', 'Kia', 'Rio', 780, 2018, 'no', 'img/imgVehiculos/kiario.png'),
(22, '5678LMN', 'Hyundai', 'i30', 820, 2017, 'no', 'img/imgVehiculos/hyundaii30.png'),
(23, '9012OPQ', 'Citroen', 'C3', 730, 2019, 'si', 'img/imgVehiculos/citroenc3.png'),
(24, '3456RST', 'Peugeot', '208', 720, 2020, 'no', 'img/imgVehiculos/peugeot208.png'),
(25, '7890UVW', 'Opel', 'Corsa', 710, 2018, 'si', 'img/imgVehiculos/opelcorsa.png'),
(26, '1234ABC', 'Ferrari', 'F40', 1000, 1987, 'no', 'img/imgVehiculos/Ferrarif40.png'),
(27, '0000AAA', 'pedro', 'csdf', 32, 1234, 'si', '2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre` (`nombre`) USING HASH;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NIF` (`NIF`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `matricula` (`matricula`) USING HASH;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD CONSTRAINT `alquileres_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `alquileres_ibfk_2` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculos` (`id_vehiculo`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `pedido_producto`
--
ALTER TABLE `pedido_producto`
  ADD CONSTRAINT `pedido_producto_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `pedido_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
