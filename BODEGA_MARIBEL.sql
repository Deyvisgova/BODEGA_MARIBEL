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
  `descripcion` varchar(255) DEFAULT NULL,
  `id_proveedor` int(11) NOT NULL,
  `activo` varchar(30) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_entrada_detalle`
--

CREATE TABLE `guia_de_entrada_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_guia_entrada` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_entrada` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `guia_de_entrada`
--

INSERT INTO `guia_de_entrada` (`id_guia_entrada`, `fecha_entrada`, `descripcion`, `id_proveedor`, `activo`) VALUES
(1, '2023-12-04', 'Recibir 450 cajas de Leche Gloria', 1, 'pendiente'),
(2, '2023-12-05', 'Recibir 200 cajas de Aceite 1L', 1, 'pendiente'),
(3, '2023-12-06', 'Recibir 100 cajas de Leche Gloria', 1, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_salida`
--

CREATE TABLE `guia_de_salida` (
  `id_guia_salida` int(20) NOT NULL,
  `fecha_salida` date NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `cantidad_salida` int(11) NOT NULL,
  `producto` varchar(200) NOT NULL,
  `destino` varchar(50) NOT NULL,
  `encargado` varchar(50) NOT NULL,
  `activo` varchar(20) NOT NULL,
  `numero_documento` varchar(30) DEFAULT NULL,
  `domicilio_fiscal` varchar(255) DEFAULT NULL,
  `fecha_inicio_traslado` date DEFAULT NULL,
  `destinatario` varchar(150) DEFAULT NULL,
  `ruc_dni_destinatario` varchar(30) DEFAULT NULL,
  `punto_partida` varchar(150) DEFAULT NULL,
  `punto_llegada` varchar(150) DEFAULT NULL,
  `motivo_traslado` varchar(60) DEFAULT NULL,
  `modalidad_transporte` varchar(30) DEFAULT NULL,
  `marca_placa` varchar(60) DEFAULT NULL,
  `licencia_conducir` varchar(60) DEFAULT NULL,
  `ruc_transporte` varchar(30) DEFAULT NULL,
  `denominacion_conductor` varchar(150) DEFAULT NULL
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
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `precio_producto` decimal(10,2) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `activo` varchar(20) NOT NULL,
  `provedor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `descripcion`, `stock_actual`, `cantidad`, `precio_producto`, `categoria`, `activo`, `provedor`) VALUES
(1, 'arroz', 'Arroz de grano largo', 450, 450, '20.00', '    Lacteos', 'activo', '  Nestle'),
(2, 'fideos', 'Fideos de trigo', 25, 25, '10.00', 'Cereales', 'activo', 'Aro'),
(3, 'leche Nesle', 'Leche evaporada marca Nestlé', 15, 15, '20.00', '    Lacteos', 'activo', '  Nestle'),
(6, 'leche Gloria', 'Leche evaporada marca Gloria', 50, 50, '30.00', '    Lacteos', 'activo', 'Gloria'),
(7, 'leche Inka', 'Leche evaporada marca Inka', 50, 50, '30.00', '    Lacteos', 'activo', '  Nestle'),
(8, 'Aceite', 'Aceite vegetal 1L', 0, 0, '0.00', 'Cereales', 'activo', '  Nestle'),
(9, 'Jamonadas', 'Embutido de cerdo', 0, 0, '0.00', 'embutidos', 'activo', 'Aro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_lote` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_recibida` int(11) NOT NULL,
  `cantidad_disponible` int(11) NOT NULL DEFAULT 0,
  `fecha_vencimiento` date NOT NULL,
  `fecha_ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_lote`, `id_producto`, `cantidad_recibida`, `cantidad_disponible`, `fecha_vencimiento`, `fecha_ingreso`) VALUES
(1, 1, 200, 200, '2024-08-31', '2024-07-01'),
(2, 3, 80, 80, '2024-09-15', '2024-07-10'),
(3, 6, 120, 120, '2024-10-05', '2024-07-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_de_salida_detalle`
--

CREATE TABLE `guia_de_salida_detalle` (
  `id_detalle_salida` int(11) NOT NULL,
  `id_guia_salida` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad_medida` varchar(50) DEFAULT NULL,
  `peso_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre_categoria_unico` (`nombre_categoria`);

--
-- Indices de la tabla `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`id_colab`);

--
-- Indices de la tabla `guia_de_entrada`
--
ALTER TABLE `guia_de_entrada`
  ADD PRIMARY KEY (`id_guia_entrada`),
  ADD KEY `idx_guia_entrada_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `guia_de_entrada_detalle`
--
ALTER TABLE `guia_de_entrada_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `idx_detalle_guia` (`id_guia_entrada`),
  ADD KEY `idx_detalle_producto` (`id_producto`),
  ADD KEY `idx_detalle_lote` (`id_lote`);

--
-- Indices de la tabla `guia_de_salida`
--
ALTER TABLE `guia_de_salida`
  ADD PRIMARY KEY (`id_guia_salida`),
  ADD KEY `idx_guia_salida_producto` (`producto`);

--
-- Indices de la tabla `guia_de_salida_detalle`
--
ALTER TABLE `guia_de_salida_detalle`
  ADD PRIMARY KEY (`id_detalle_salida`),
  ADD KEY `idx_salida_detalle_guia` (`id_guia_salida`),
  ADD KEY `idx_salida_detalle_producto` (`id_producto`),
  ADD KEY `idx_salida_detalle_lote` (`id_lote`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id_kardex`),
  ADD KEY `idx_kardex_producto` (`producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `nombre_producto_unico` (`nombre_producto`),
  ADD KEY `idx_producto_categoria` (`categoria`),
  ADD KEY `idx_producto_provedor` (`provedor`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `idx_lote_producto` (`id_producto`);

--
-- Indices de la tabla `provedor`
--
ALTER TABLE `provedor`
  ADD PRIMARY KEY (`id_provedor`),
  ADD UNIQUE KEY `nombre_empresa_unico` (`Nombre_de_la_empresa`);


--
-- Restricciones para tablas volcadas
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`nombre_categoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_provedor` FOREIGN KEY (`provedor`) REFERENCES `provedor` (`Nombre_de_la_empresa`) ON UPDATE CASCADE;

ALTER TABLE `guia_de_entrada`
  ADD CONSTRAINT `fk_entrada_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `provedor` (`id_provedor`) ON UPDATE CASCADE;

ALTER TABLE `guia_de_entrada_detalle`
  ADD CONSTRAINT `fk_detalle_guia` FOREIGN KEY (`id_guia_entrada`) REFERENCES `guia_de_entrada` (`id_guia_entrada`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_lote` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id_lote`) ON UPDATE CASCADE;

ALTER TABLE `guia_de_salida`
  ADD CONSTRAINT `fk_salida_producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`nombre_producto`) ON UPDATE CASCADE;

ALTER TABLE `guia_de_salida_detalle`
  ADD CONSTRAINT `fk_detalle_salida_guia` FOREIGN KEY (`id_guia_salida`) REFERENCES `guia_de_salida` (`id_guia_salida`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_salida_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_salida_lote` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id_lote`) ON UPDATE CASCADE;

ALTER TABLE `kardex`
  ADD CONSTRAINT `fk_kardex_producto` FOREIGN KEY (`producto`) REFERENCES `producto` (`nombre_producto`) ON UPDATE CASCADE;

ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON UPDATE CASCADE;

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
-- AUTO_INCREMENT de la tabla `guia_de_entrada_detalle`
--
ALTER TABLE `guia_de_entrada_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_de_salida`
--
ALTER TABLE `guia_de_salida`
  MODIFY `id_guia_salida` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `guia_de_salida_detalle`
--
ALTER TABLE `guia_de_salida_detalle`
  MODIFY `id_detalle_salida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id_kardex` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `provedor`
--
ALTER TABLE `provedor`
  MODIFY `id_provedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
