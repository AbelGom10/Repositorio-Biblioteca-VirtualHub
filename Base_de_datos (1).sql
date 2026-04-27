-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-04-2026 a las 07:48:27
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca_virtualhub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `stock` int NOT NULL,
  `activo` tinyint DEFAULT '1'
) ;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor`, `genero`, `isbn`, `stock`, `activo`) VALUES
(1, '100 años de soledad', 'Gabriel García Marquéz', 'Drama', '18235236', 9, 1),
(3, 'El Principito', 'Antoine de Saint-Exupéry', 'Literatura infantil', '127722', 2, 1),
(5, 'El alquimista', ' Paulo Coelho', ' Novela', '156274', 4, 1),
(9, 'El monje que vendió su ferrari', ' Robin S. Sharma', ' Ficción', '23472894734', 2, 1),
(10, ' El Arte del Cuchiplancheo', ' Penélope Menchaca', 'Finanzas', '13245', 2, 1),
(11, 'Romeo y Julieta', ' William Shakespeare', ' Tragedia', '2864983', 5, 1),
(12, 'Hábitos Atómicos', 'James Clear', 'Libro de autoayuda', '1736923', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_libro` int DEFAULT NULL,
  `fecha_prestamo` date DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `fecha_real_devolucion` date DEFAULT NULL,
  `estado` enum('PENDIENTE','ACTIVO','DEVUELTO','RECHAZADO') DEFAULT 'PENDIENTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `id_usuario`, `id_libro`, `fecha_prestamo`, `fecha_devolucion`, `fecha_real_devolucion`, `estado`) VALUES
(1, 2, 1, '2026-04-23', NULL, '2026-04-23', 'DEVUELTO'),
(2, 1, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(3, 2, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(4, 2, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(5, 2, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(6, 2, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(7, 1, 1, '2026-04-23', '2026-04-30', '2026-04-23', 'DEVUELTO'),
(8, 1, 3, '2026-04-23', '2026-04-30', '2026-04-24', 'DEVUELTO'),
(9, 1, 3, '2026-04-24', '2026-05-01', NULL, 'ACTIVO'),
(10, 2, 5, '2026-04-24', '2026-05-01', '2026-04-26', 'DEVUELTO'),
(12, 2, 10, '2026-04-24', '2026-05-01', '2026-04-26', 'DEVUELTO'),
(13, 1, 9, '2026-04-24', '2026-05-01', '2026-04-25', 'DEVUELTO'),
(14, 1, 9, '2026-04-25', '2026-05-02', NULL, 'ACTIVO'),
(15, 2, 9, '2026-04-25', '2026-05-02', '2026-04-26', 'DEVUELTO'),
(16, 2, 5, '2026-04-26', '2026-05-03', '2026-04-26', 'DEVUELTO'),
(17, 2, 1, '2026-04-26', NULL, NULL, 'RECHAZADO'),
(18, 2, 1, '2026-04-26', NULL, NULL, 'RECHAZADO'),
(19, 2, 1, '2026-04-26', '2026-05-03', '2026-04-26', 'DEVUELTO'),
(20, 2, 3, '2026-04-26', '2026-05-03', NULL, 'ACTIVO'),
(21, 2, 10, '2026-04-26', '2026-05-03', NULL, 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'ADMIN'),
(2, 'USUARIO'),
(3, 'SUPERADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_rol` int DEFAULT NULL,
  `intentos_fallidos` int DEFAULT '0',
  `bloqueado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `id_rol`, `intentos_fallidos`, `bloqueado`) VALUES
(1, 'Admin', 'admin@correo.com', '$2y$10$Mavgsh/MWX6YbY6ej/UL1u84ZjKRibqwJiICXfCID0gJUuhdweJNO', 3, 0, 0),
(2, 'Usuario', 'quiensea@correo.com', '$2y$10$JCm167dwTm9ax1WEE1XbfOTTJcs6/HGMCmtH3oo.JiXahBwk8aP9K', 2, 0, 0),
(6, 'Admin2', 'admin2@correo.com', '$2y$10$ythUVXXzXt9QCiVUevnsJuOdmVEgieu51vS/nT2pBT/knTFyfFXVm', 1, 0, 0),
(7, 'admin3', 'admin3@correo.com', '$2y$10$R17qf4ygs34xHlU3//8a6ur0wJaNQhkgx/6qcBEgDVeQfu9aKaD5G', 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
