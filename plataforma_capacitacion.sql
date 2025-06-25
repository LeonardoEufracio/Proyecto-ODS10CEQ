-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2025 a las 17:35:33
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
-- Base de datos: `plataforma_capacitacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_paterno` varchar(100) NOT NULL,
  `apellido_materno` varchar(100) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `dni`, `nombres`, `apellido_paterno`, `apellido_materno`, `provincia`, `correo`, `celular`, `password`) VALUES
(1, '75784202', 'Adair', 'Ramirez', 'Caceres', 'LIMA', 'ramirezcaceres@gmail.com', '954786123', '$2y$10$zKVkRwTVDAgNFhaxJgxlDOBphoMmy7W6cdTrZ/7PO9hJ9euRvZq8K'),
(2, '74756515', 'Jose', 'Ramos', 'Caceres', 'ABANCAY', 'joseramos@gmail.com', '945786425', '$2y$10$MbIo1mj7omKlnoEbb0NpauVHCs7l0WrGejSBAGiQCxVWs8Bhz/Bhe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `dias` varchar(100) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `certificado_disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `categoria`, `dias`, `fecha_inicio`, `horario`, `certificado_disponible`) VALUES
(1, 'CCNA: Fundamentos de Redes', 'Redes', 'Lunes, Miércoles', '2025-07-01', '6:00 - 9:00 pm', 1),
(2, 'CCNA: Routing y Switching', 'Redes', 'Martes, Jueves', '2025-07-02', '6:00 - 9:00 pm', 1),
(3, 'CCNA: Seguridad de Redes', 'Redes', 'Viernes', '2025-07-03', '7:00 - 10:00 pm', 1),
(4, 'Administración de Redes Cisco', 'Redes', 'Lunes, Miércoles', '2025-07-04', '6:00 - 9:00 pm', 1),
(5, 'Redes Inalámbricas Empresariales', 'Redes', 'Martes', '2025-07-05', '5:00 - 8:00 pm', 1),
(6, 'Ciberseguridad Básica', 'Ciberseguridad', 'Martes', '2025-07-06', '4:00 - 7:00 pm', 1),
(7, 'Hacking Ético', 'Ciberseguridad', 'Sábado', '2025-07-07', '9:00 - 12:00 pm', 1),
(8, 'Pentesting Web Avanzado', 'Ciberseguridad', 'Lunes, Miércoles', '2025-07-08', '7:00 - 9:00 pm', 1),
(9, 'Ciberdefensa Corporativa', 'Ciberseguridad', 'Miércoles', '2025-07-09', '6:00 - 9:00 pm', 1),
(10, 'Auditoría de Seguridad Informática', 'Ciberseguridad', 'Viernes', '2025-07-10', '6:00 - 9:00 pm', 1),
(11, 'Python para Redes', 'Programación', 'Lunes, Jueves', '2025-07-11', '4:00 - 6:00 pm', 1),
(12, 'Automatización con Python', 'Programación', 'Martes', '2025-07-12', '6:00 - 8:00 pm', 1),
(13, 'JavaScript Básico', 'Programación', 'Lunes, Miércoles', '2025-07-13', '5:00 - 7:00 pm', 1),
(14, 'ReactJS desde cero', 'Programación', 'Viernes', '2025-07-14', '6:00 - 9:00 pm', 1),
(15, 'Programación Orientada a Objetos', 'Programación', 'Martes, Jueves', '2025-07-15', '6:00 - 8:00 pm', 1),
(16, 'Fundamentos de IoT', 'IoT', 'Miércoles, Viernes', '2025-07-16', '7:00 - 9:00 pm', 1),
(17, 'IoT en Smart Cities', 'IoT', 'Sábado', '2025-07-17', '8:00 - 11:00 am', 1),
(18, 'Automatización con Arduino', 'IoT', 'Lunes, Miércoles', '2025-07-18', '5:00 - 7:00 pm', 1),
(19, 'Domótica Inteligente', 'IoT', 'Martes, Jueves', '2025-07-19', '4:00 - 6:00 pm', 1),
(20, 'Proyectos con Raspberry Pi', 'IoT', 'Viernes', '2025-07-20', '6:00 - 9:00 pm', 1),
(21, 'Linux para Principiantes', 'Linux', 'Martes, Jueves', '2025-07-21', '6:00 - 8:00 pm', 1),
(22, 'Linux Intermedio', 'Linux', 'Viernes', '2025-07-22', '5:00 - 8:00 pm', 1),
(23, 'Administración de Servidores Linux', 'Linux', 'Lunes, Miércoles', '2025-07-23', '6:00 - 8:00 pm', 1),
(24, 'Comandos Avanzados en Bash', 'Linux', 'Martes', '2025-07-24', '5:00 - 7:00 pm', 1),
(25, 'Seguridad en Linux', 'Linux', 'Miércoles', '2025-07-25', '6:00 - 8:00 pm', 1),
(26, 'Inteligencia Emocional', 'Habilidades Blandas', 'Miércoles', '2025-07-26', '6:00 - 8:00 pm', 1),
(27, 'Comunicación Asertiva', 'Habilidades Blandas', 'Jueves', '2025-07-27', '5:00 - 7:00 pm', 1),
(28, 'Negociación Estratégica', 'Habilidades Blandas', 'Lunes, Viernes', '2025-07-28', '6:00 - 8:00 pm', 1),
(29, 'Liderazgo Transformacional', 'Habilidades Blandas', 'Martes', '2025-07-29', '6:00 - 8:00 pm', 1),
(30, 'Gestión del Tiempo', 'Habilidades Blandas', 'Miércoles', '2025-07-30', '6:00 - 8:00 pm', 1),
(31, 'Diseño Gráfico con Canva', 'Creatividad', 'Viernes', '2025-07-31', '5:00 - 7:00 pm', 1),
(32, 'Storytelling Digital', 'Creatividad', 'Lunes', '2025-08-01', '6:00 - 8:00 pm', 1),
(33, 'Fotografía con Smartphone', 'Creatividad', 'Martes', '2025-08-02', '6:00 - 8:00 pm', 1),
(34, 'Edición de Video para Redes', 'Creatividad', 'Miércoles', '2025-08-03', '6:00 - 8:00 pm', 1),
(35, 'Marketing de Contenidos', 'Creatividad', 'Sábado', '2025-08-04', '9:00 - 12:00 pm', 1),
(36, 'Desarrollo Web Full Stack', 'Top Demandados', 'Lunes a Viernes', '2025-08-05', '6:00 - 9:00 pm', 1),
(37, 'Python para Principiantes', 'Top Demandados', 'Lunes, Miércoles', '2025-08-06', '5:00 - 7:00 pm', 1),
(38, 'Machine Learning con Python', 'Top Demandados', 'Martes, Jueves', '2025-08-07', '6:00 - 9:00 pm', 1),
(39, 'Marketing Digital Estratégico', 'Top Demandados', 'Martes, Jueves', '2025-08-08', '5:00 - 7:00 pm', 1),
(40, 'Gestión de Proyectos con SCRUM', 'Top Demandados', 'Miércoles', '2025-08-09', '6:00 - 9:00 pm', 1),
(41, 'Excel para Negocios', 'Top Demandados', 'Lunes, Miércoles', '2025-08-10', '4:00 - 6:00 pm', 1),
(42, 'JavaScript Moderno', 'Top Demandados', 'Martes, Jueves', '2025-08-11', '6:00 - 8:00 pm', 1),
(43, 'ReactJS Intermedio', 'Top Demandados', 'Viernes', '2025-08-12', '6:00 - 9:00 pm', 1),
(44, 'Power BI Avanzado', 'Top Demandados', 'Sábado', '2025-08-13', '8:00 - 12:00 pm', 1),
(45, 'Análisis de Datos con Excel', 'Top Demandados', 'Miércoles, Viernes', '2025-08-14', '5:00 - 7:00 pm', 1),
(46, 'Ciberseguridad para Empresas', 'Top Demandados', 'Martes', '2025-08-15', '6:00 - 9:00 pm', 1),
(47, 'Automatización con PowerShell', 'Top Demandados', 'Jueves', '2025-08-16', '6:00 - 8:00 pm', 1),
(48, 'SQL para Análisis de Datos', 'Top Demandados', 'Martes, Jueves', '2025-08-17', '6:00 - 8:00 pm', 1),
(49, 'Scrum Master Certificación', 'Top Demandados', 'Sábado', '2025-08-18', '9:00 - 1:00 pm', 1),
(50, 'UX Research', 'Top Demandados', 'Miércoles', '2025-08-19', '6:00 - 8:00 pm', 1),
(51, 'Diseño de Interfaces Responsivas', 'Top Demandados', 'Martes', '2025-08-20', '5:00 - 7:00 pm', 1),
(52, 'Docker y Kubernetes', 'Top Demandados', 'Viernes', '2025-08-21', '6:00 - 9:00 pm', 1),
(53, 'Inteligencia Artificial en Negocios', 'Top Demandados', 'Lunes', '2025-08-22', '6:00 - 9:00 pm', 1),
(54, 'Técnicas de Ventas Modernas', 'Top Demandados', 'Martes', '2025-08-23', '5:00 - 7:00 pm', 1),
(55, 'Cultura DevOps', 'Top Demandados', 'Miércoles', '2025-08-24', '6:00 - 8:00 pm', 1),
(56, 'Introducción a AWS', 'Cloud Computing', 'Lunes, Miércoles', '2025-08-25', '6:00 - 8:00 pm', 1),
(57, 'Microsoft Azure Básico', 'Cloud Computing', 'Martes, Jueves', '2025-08-26', '5:00 - 7:00 pm', 1),
(58, 'Google Cloud Platform Essentials', 'Cloud Computing', 'Viernes', '2025-08-27', '6:00 - 9:00 pm', 1),
(59, 'Infraestructura como Código con Terraform', 'Cloud Computing', 'Miércoles', '2025-08-28', '6:00 - 9:00 pm', 1),
(60, 'DevOps en la Nube', 'Cloud Computing', 'Sábado', '2025-08-29', '9:00 - 12:00 pm', 1),
(61, 'Fundamentos de Ciencia de Datos', 'Ciencia de Datos', 'Lunes, Miércoles', '2025-08-30', '5:00 - 7:00 pm', 1),
(62, 'Visualización de Datos con Power BI', 'Ciencia de Datos', 'Martes', '2025-08-31', '6:00 - 8:00 pm', 1),
(63, 'Estadística para Ciencia de Datos', 'Ciencia de Datos', 'Jueves', '2025-09-01', '6:00 - 8:00 pm', 1),
(64, 'Introducción a Python para Datos', 'Ciencia de Datos', 'Martes, Jueves', '2025-09-02', '6:00 - 8:00 pm', 1),
(65, 'Dashboards con Tableau', 'Ciencia de Datos', 'Viernes', '2025-09-03', '5:00 - 7:00 pm', 1),
(66, 'Fundamentos de Inteligencia Artificial', 'Inteligencia Artificial', 'Lunes, Miércoles', '2025-09-04', '6:00 - 8:00 pm', 1),
(67, 'Modelos de Lenguaje con IA (LLMs)', 'Inteligencia Artificial', 'Martes', '2025-09-05', '5:00 - 7:00 pm', 1),
(68, 'Aplicaciones con ChatGPT y GPT-4', 'Inteligencia Artificial', 'Miércoles', '2025-09-06', '6:00 - 8:00 pm', 1),
(69, 'Redes Neuronales con TensorFlow', 'Inteligencia Artificial', 'Jueves', '2025-09-07', '6:00 - 9:00 pm', 1),
(70, 'Visión Computacional con OpenCV', 'Inteligencia Artificial', 'Sábado', '2025-09-08', '8:00 - 11:00 am', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `id_alumno` int(11) DEFAULT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `desea_certificado` tinyint(1) DEFAULT NULL,
  `fecha_matricula` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id`, `id_alumno`, `id_curso`, `desea_certificado`, `fecha_matricula`) VALUES
(64, 1, 10, 0, '2025-06-15 21:18:25'),
(65, 1, 9, 0, '2025-06-15 21:19:38'),
(66, 1, 6, 0, '2025-06-15 21:19:56'),
(67, 1, 7, 0, '2025-06-15 21:19:56'),
(68, 1, 8, 0, '2025-06-15 21:19:56'),
(69, 2, 6, 0, '2025-06-16 10:48:37'),
(70, 2, 7, 0, '2025-06-16 10:48:38'),
(71, 2, 8, 0, '2025-06-25 02:17:24'),
(72, 2, 62, 0, '2025-06-25 02:17:25'),
(73, 2, 64, 0, '2025-06-25 02:17:26');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_curso` (`id_curso`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
