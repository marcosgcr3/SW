-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2024 a las 11:01:05
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

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `id_cliente`, `id_mecanico`, `startDate`, `endDate`, `title`, `estado`) VALUES
(1, 2, 67, '2024-04-30 11:00:00', '2024-04-30 12:00:00', 'd4ew', 0),
(21, 2, 3, '2024-04-30 11:00:00', '2024-04-30 12:00:00', 'ewrf', 1),
(22, 2, 3, '2024-05-01 13:00:00', '2024-05-01 14:00:00', 'qref', 0),
(24, 2, 67, '2024-05-02 14:00:00', '2024-05-02 15:00:00', 'qrfe', 1),
(35, 2, 3, '2024-05-03 09:00:00', '2024-05-03 10:00:00', 'hola', 1),
(36, 2, 67, '2024-05-03 11:00:00', '2024-05-03 12:00:00', 'adios', 0),
(37, 2, 67, '2024-05-03 09:00:00', '2024-05-03 10:00:00', 't', 0),
(38, 2, 3, '2024-05-08 13:00:00', '2024-05-08 14:00:00', 'J', 2),
(39, 2, 3, '2024-05-02 09:00:00', '2024-05-02 10:00:00', 'j', 0),
(40, 2, 67, '2024-05-02 11:00:00', '2024-05-02 12:00:00', 'gfd', 0),
(41, 2, 3, '2024-05-09 11:00:00', '2024-05-09 12:00:00', 'ui', 0),
(42, 2, 67, '2024-05-10 13:00:00', '2024-05-10 14:00:00', 'h', 1);

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `descripcion`, `unidades`, `imagen`) VALUES
(3, 'Neumatico', 23, 'Nuematicos nuevos de 22 pulgadas', 8, 'img/imgProductos/neumatico.png'),
(4, 'Aceite', 12, 'Aceite para motor de coche', 10, 'img/imgProductos/aceite.png'),
(5, 'Frenos', 150, 'Frenos para coche', 15, 'img/imgProductos/frenos.png'),
(8, 'Marcos', 32, 'liquido de frenos', 8, 'img/imgProductos/image.jpg');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `NIF`, `nombre`, `apellido`, `correo`, `password`, `rol`) VALUES
(2, '12', 'pepe', 'peres', 'pepe@gmail.com', '$2y$10$RSE/bu0FF67rcqWU/i6BPO/jhmP0VMYAyRvn4vz62gsPPb.OWgHE6', 'usuario'),
(3, '000000000', 'Marcos', 'Gomez', 'lagarto@gmail.com', '$2y$10$IGlIFQvB75s3Q6eG1s3GLu5IoI1myTSnD2.t7ulMDv/cL9ug/xt0y', 'mecanico'),
(4, '123456789', 'ghj', 'ghj', 'hgj@gmail.com', '$2y$10$8iYgOYrv.WTNpD.1XfaIXewG8IWk4rXcaF4M5u0GaTjPd4HPHMRGW', 'usuario'),
(5, '33', 'fernando', 'alonso', 'elnano@gmail.com', '33', 'admin'),
(6, '5151', 'marcos', 'gomez', 'marcos@gmail.com', '$2y$10$hDYEcSH2d0sP0oEq67j/sOg5OpuC/579V90yYOdr8N6DMNv/FDC36', 'admin'),
(7, '7654321', 'lionel', 'messi', 'lapulga@gmail.com', '202cb962ac59075b964b07152d234b70', ''),
(8, '243524534', 'wedfwaf', 'wsdw', 'wed@gmail.com', '$2y$10$/GQqud7wtaKYez/WSOqSjeB3YmIkoT4ASrMn38I6Eit8eeCQRRsQW', 'usuario'),
(9, '123987658', 'Marcos', 'ewd', 'papa@gmail.com', '$2y$10$o5scwI8bAQ72gyAWGakVqeggq1mhqiEyJNBnNxrqWdSAnqJz4WGEK', 'usuario'),
(10, '984759857', 'Marcos', 'ewd', 'paadpa@gmail.com', '$2y$10$im9lPcRt8mNxOlQMF8yRhu9AIn/.7zI/8GY8c5Z4LgG71XkCSQj.m', 'usuario'),
(67, '1234567', 'cristiano', 'ronaldo', 'elbicho@gmail.com', 'messimalo', 'mecanico');

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `matricula`, `marca`, `modelo`, `precio`, `year`, `archivado`, `disponibilidad`, `imagen`) VALUES
(7, '5678STU', 'Audi', 'A3', 1000, 2017, 0, 'si', 'img/imgVehiculos/audia3.png'),
(8, '9012VWX', 'Audi', 'A4', 1100, 2018, 0, 'si', 'img/imgVehiculos/audia4.png'),
(9, '3456YZA', 'Audi', 'Q3', 1200, 2016, 0, 'si', 'img/imgVehiculos/audiq3.png'),
(10, '7890BCD', 'Audi', 'Q5', 1300, 2019, 0, 'si', 'img/imgVehiculos/audiq5.png'),
(11, '1234EFG', 'Mercedes', 'Clase A', 1100, 2018, 0, 'si', 'img/imgVehiculos/mercedesclasea.png'),
(12, '5678HIJ', 'Mercedes', 'Clase B', 1200, 2017, 0, 'si', 'img/imgVehiculos/mercedesclaseb.png'),
(13, '9012KLM', 'Mercedes', 'Clase C', 1300, 2016, 0, 'si', 'img/imgVehiculos/mercedesclasec.png'),
(14, '3456NOP', 'Mercedes', 'Clase GLA', 1400, 2019, 0, 'si', 'img/imgVehiculos/mercedesclasegla.png'),
(15, '7890QRS', 'Toyota', 'Corolla', 900, 2020, 0, 'si', 'img/imgVehiculos/toyotacorolla.png'),
(16, '1234TUV', 'Ford', 'Focus', 800, 2019, 0, 'si', 'img/imgVehiculos/fordfocus.png'),
(17, '5678WXY', 'Honda', 'Civic', 850, 2018, 0, 'si', 'img/imgVehiculos/hondacivic.png'),
(18, '9012ZAB', 'Volkswagen', 'Golf', 900, 2017, 0, 'si', 'img/imgVehiculos/vwgolf.png'),
(19, '3456CDE', 'Renault', 'Clio', 750, 2020, 0, 'si', 'img/imgVehiculos/renaultclio.png'),
(20, '7890FGH', 'Seat', 'Ibiza', 700, 2019, 0, 'si', 'img/imgVehiculos/seatibiza.png'),
(21, '1234IJK', 'Kia', 'Rio', 780, 2018, 0, 'si', 'img/imgVehiculos/kiario.png'),
(22, '5678LMN', 'Hyundai', 'i30', 820, 2017, 0, 'si', 'img/imgVehiculos/hyundaii30.png'),
(23, '9012OPQ', 'Citroen', 'C3', 730, 2019, 0, 'si', 'img/imgVehiculos/citroenc3.png'),
(24, '3456RST', 'Peugeot', '208', 720, 2020, 0, 'si', 'img/imgVehiculos/peugeot208.png'),
(25, '7890UVW', 'Opel', 'Corsa', 710, 2018, 0, 'si', 'img/imgVehiculos/opelcorsa.png'),
(26, '1234ABC', 'Ferrari', 'F40', 1000, 1987, 0, 'si', 'img/imgVehiculos/Ferrarif40.png'),
(28, '0000AAA', 'pedro', 'csdf', 324, 1234, 0, 'si', '3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
