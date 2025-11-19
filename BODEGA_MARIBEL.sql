-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2023 a las 18:05:38
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `makro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_adm` int(11) NOT NULL,
  `dni_adm` varchar(50) DEFAULT NULL,
  `nombre_adm` varchar(50) DEFAULT NULL,
  `apellido_adm` varchar(50) DEFAULT NULL,
  `genero_adm` varchar(50) DEFAULT NULL,
  `direccion_adm` varchar(50) DEFAULT NULL,
  `telefono_adm` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_adm`, `dni_adm`, `nombre_adm`, `apellido_adm`, `genero_adm`, `direccion_adm`, `telefono_adm`, `email`, `password`, `user_type`) VALUES
(1, '74683422', 'Ana', 'leyva fernandez', 'femenino', 'Mz A las viñas 233', '953423873', 'ana@admin.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(2, '  79241289', '  Juan', '  Garcia Perez', 'Masculino', '  Mz los lirios 123', '  954387339', 'juan@admin.com', '202cb962ac59075b964b07152d234b70', 'admin'),
(3, '74125896', 'bill', 'man', 'Masculino', 'manturano', '987456321', 'bill@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre_categoria`) VALUES
(1, '    Lacteos'),
(2, 'Cereales'),
(3, 'Arroz'),
(5, 'embutidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `dni_cliente` varchar(20) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `apellido_cliente` varchar(50) NOT NULL,
  `genero_cliente` varchar(50) NOT NULL,
  `direccion_cliente` varchar(50) NOT NULL,
  `telefono_cliente` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `dni_cliente`, `nombre_cliente`, `apellido_cliente`, `genero_cliente`, `direccion_cliente`, `telefono_cliente`, `email`, `password`, `user_type`) VALUES
(1, '75476991', 'Augusto', 'Barrientos Mejia', 'masculino', 'mz L lote 1B', '974746542', 'u20204717@utp.edu.pe', '202cb962ac59075b964b07152d234b70', 'user'),
(2, '73621424', 'Nicole', 'Quispe Florez', 'femenino', 'Mz las flores L 123', '954832754', 'nicole@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(3, '73621424', 'Alvaro', 'Vargas Medina', 'masculino', 'Mz los jazmineL 123', '954832364', 'alvaro@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(4, '72711588', 'Raul', 'Reynaga', 'masculino', 'que te importa', '973204176', 'reynagagraul@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(6, '12345678', 'ALX', 'MAN', 'Masculino', 'sdadas', '987456321', 'alx@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(7, '12345678', 'elx', 'MAN', 'Masculino', 'sdadas', '987456321', 'elx@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(8, '74125836', 'dsadsa', 'dsadsa', 'Masculino', 'csadasdas', '123456789', 'ulx@gmail.com', '202cb962ac59075b964b07152d234b70', 'user');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colaborador`
--

CREATE TABLE `colaborador` (
  `id_colab` int(11) NOT NULL,
  `dni_colab` varchar(50) NOT NULL,
  `nombre_colab` varchar(50) NOT NULL,
  `apellido_colab` varchar(50) NOT NULL,
  `genero_colab` varchar(50) NOT NULL,
  `direccion_colab` varchar(50) NOT NULL,
  `telefono_colab` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `colaborador`
--

INSERT INTO `colaborador` (`id_colab`, `dni_colab`, `nombre_colab`, `apellido_colab`, `genero_colab`, `direccion_colab`, `telefono_colab`, `email`, `password`, `user_type`) VALUES
(1, '74683422', 'Luis', 'leyva fernandez', 'femenino', 'Mz A las viñas 233', '953423873', 'luiscolab@admin.com', '827ccb0eea8a706c4c34a16891f84e7b', 'colab'),
(2, '74125698', 'willi', 'wonka', 'Femenino', 'sasfdsf', '987654123', 'willicolab@gmail.com', '202cb962ac59075b964b07152d234b70', 'colab');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_entrada`
--

CREATE TABLE `guia_de_entrada` (
  `id_guia_entrada` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `cantidad_entrada` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `provedor` varchar(50) NOT NULL,
  `activo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `guia_de_entrada`
--

INSERT INTO `guia_de_entrada` (`id_guia_entrada`, `fecha_entrada`, `descripcion`, `cantidad_entrada`, `producto`, `provedor`, `activo`) VALUES
(1, '2023-12-04', 'Recibir 450 cajas de Leche Gloria', 450, 'arroz', '  Nestle', 'pendiente'),
(2, '2023-12-05', 'Recibir 200 cajas de Aceite 1L', 250, 'Aceite', '  Nestle', 'pendiente'),
(3, '2023-12-06', 'Recibir 100 cajas de Leche Gloria', 20, 'Leche Gloria', '  Nestle', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_salida`
--

CREATE TABLE `guia_de_salida` (
  `id_guia_salida` int(20) NOT NULL,
  `fecha_salida` date NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `cantidad_salida` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `destino` varchar(50) NOT NULL,
  `encargado` varchar(50) NOT NULL,
  `activo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `guia_de_salida`
--

INSERT INTO `guia_de_salida` (`id_guia_salida`, `fecha_salida`, `descripcion`, `cantidad_salida`, `producto`, `destino`, `encargado`, `activo`) VALUES
(1, '2023-12-05', 'Retiro de 20 cajas de leche Gloria', 20, 'arroz', 'Area Lacteos', 'Luis Hernan', 'pendiente'),
(2, '2023-12-05', 'Recibir 100 cajas de Jamonada', 100, 'Jamonadas', 'Area Embutidos', 'Jesus', 'pendiente'),
(3, '2023-12-17', 'Retiro de 600cajas de leche Gloria', 20, 'Jamonadas', 'Casa', 'Mauricio mesones', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `activo` varchar(20) NOT NULL,
  `provedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `cantidad`, `precio_producto`, `categoria`, `activo`, `provedor`) VALUES
(1, 'arroz', 450, '20.00', '    Lacteos', 'activo', '  Nestle'),
(2, 'fideos', 25, '10.00', 'Cereales', 'activo', 'Aro'),
(3, 'leche Nesle', 15, '20.00', '    Lacteos', 'activo', '  Nestle'),
(6, 'leche Gloria', 50, '30.00', '    Lacteos', 'activo', 'Gloria'),
(7, 'leche Inka', 50, '30.00', '    Lacteos', 'activo', '  Nestle');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedor`
--

CREATE TABLE `provedor` (
  `id_provedor` int(11) NOT NULL,
  `Nombre_de_la_empresa` varchar(100) NOT NULL,
  `ruc` int(11) NOT NULL,
  `Persona_de_Contacto` varchar(100) NOT NULL,
  `Numero_de_contacto` int(9) NOT NULL,
  `correo_electronico` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `provedor`
--

INSERT INTO `provedor` (`id_provedor`, `Nombre_de_la_empresa`, `ruc`, `Persona_de_Contacto`, `Numero_de_contacto`, `correo_electronico`) VALUES
(1, '  Nestle', 23456789, '  Jhon mansanal', 987654321, '  JhonMansanal@Nestle.com'),
(2, 'Gloria', 123456789, ' Richard Acuña', 987541222, ' Richard@Gloria.com'),
(3, 'Aro', 987456, '    Yulissa', 123456789, ' yulissa@Aro.com'),
(5, 'Costeño', 2147483647, '  Yulisa', 957862456, ' yulisa@Costeño.com'),
(7, 'Anita', 2147483647, 'Luis fer', 957862456, 'Luis@Anita.com'),
(8, 'Cusqueña', 1265478, 'Patrioclo', 78964412, 'Patrioclo@cusqueña.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id_kardex` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `producto` varchar(200) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `referencia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_adm`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`id_colab`);

--
-- Indices de la tabla `guia_de_entrada`
--
ALTER TABLE `guia_de_entrada`
  ADD PRIMARY KEY (`id_guia_entrada`);

--
-- Indices de la tabla `guia_de_salida`
--
ALTER TABLE `guia_de_salida`
  ADD PRIMARY KEY (`id_guia_salida`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id_kardex`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `provedor`
--
ALTER TABLE `provedor`
  ADD PRIMARY KEY (`id_provedor`);


--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `id_colab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `guia_de_entrada`
--
ALTER TABLE `guia_de_entrada`
  MODIFY `id_guia_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `guia_de_salida`
--
ALTER TABLE `guia_de_salida`
  MODIFY `id_guia_salida` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id_kardex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `provedor`
--
ALTER TABLE `provedor`
  MODIFY `id_provedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
