-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2020 at 11:49 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parcial`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnos_materias`
--

CREATE TABLE `alumnos_materias` (
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `nota` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `alumnos_materias`
--

INSERT INTO `alumnos_materias` (`id_alumno`, `id_materia`, `nota`, `created_at`, `updated_at`) VALUES
(2, 4, 0, '2020-11-17 06:01:09', '2020-11-17 06:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `materia` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cuatrimestre` int(11) NOT NULL,
  `cupos` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `materias`
--

INSERT INTO `materias` (`id`, `materia`, `cuatrimestre`, `cupos`, `created_at`, `updated_at`) VALUES
(1, 'P3', 3, 20, '2020-11-17 05:41:05', '2020-11-17 05:41:05'),
(2, 'P2', 2, 20, '2020-11-17 05:46:37', '2020-11-17 05:46:37'),
(3, 'P1', 1, 20, '2020-11-17 05:46:44', '2020-11-17 05:46:44'),
(4, 'SPD', 1, 19, '2020-11-17 05:47:02', '2020-11-17 06:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombre`, `clave`, `tipo`, `created_at`, `updated_at`) VALUES
(2, 'PEPE@MAIL.COM', 'PEPE', '123456', 'ALUMNO', '2020-11-17 05:22:49', '2020-11-17 05:22:49'),
(3, 'ADMIN@MAIL.COM', 'ADMIN', '12345', 'ADMIN', '2020-11-17 05:28:41', '2020-11-17 05:28:41'),
(4, 'BRIAN@MAIL.COM', 'BRIAN', '1234567', 'ALUMNO', '2020-11-17 06:03:52', '2020-11-17 06:03:52'),
(5, 'PROFESOR@MAIL.COM', 'PROFESOR', '1234567', 'PROFESOR', '2020-11-17 06:05:20', '2020-11-17 06:05:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
