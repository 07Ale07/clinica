-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2025 a las 22:27:05
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
-- Base de datos: `clinica_dental2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes_medicos`
--

CREATE TABLE `antecedentes_medicos` (
  `id_antecedente` int(11) NOT NULL,
  `id_paciente` int(100) NOT NULL,
  `tipo_antecedente` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_paciente`
--

CREATE TABLE `archivos_paciente` (
  `id_archivo` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_consulta` int(11) DEFAULT NULL,
  `nombre_archivo` varchar(150) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bloqueos_horarios`
--

CREATE TABLE `bloqueos_horarios` (
  `id_bloqueo` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `id_sillon` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `motivo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_materiales`
--

CREATE TABLE `categorias_materiales` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_honorarios`
--

CREATE TABLE `config_honorarios` (
  `id_configuracion` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `tipo_liquidacion` varchar(100) NOT NULL,
  `valor` int(100) NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `id_turno` int(11) DEFAULT NULL,
  `fecha_consulta` date NOT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `diagnostico` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta_corriente`
--

CREATE TABLE `cuenta_corriente` (
  `id_movimiento` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `id_pago` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `tipo_movimiento` varchar(20) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `saldo` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `barrio` varchar(1000) NOT NULL,
  `calle` varchar(1000) NOT NULL,
  `altura` int(255) NOT NULL,
  `indicaciones` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `pais`, `provincia`, `barrio`, `calle`, `altura`, `indicaciones`) VALUES
(1, 'Argentina', 'Buenos Aires', 'Palermo', 'Av. Santa Fe', 2450, 'Depto 3B'),
(2, 'Argentina', 'Córdoba', 'Nueva Córdoba', 'Obispo Trejo', 150, 'Cerca del Buen Pastor'),
(3, 'Argentina', 'Mendoza', 'Centro', 'San Martín', 800, 'Frente a plaza'),
(4, 'Argentina', 'Santa Fe', 'Rosario Norte', 'Oroño', 1234, 'Casa blanca esquina'),
(5, 'Argentina', 'Buenos Aires', 'La Plata', '7', 456, 'Entre 42 y 43'),
(6, 'Argentina', 'Buenos Aires', 'Palermo', 'Av. Santa Fe', 2450, 'Depto 3B'),
(7, 'Argentina', 'Córdoba', 'Nueva Córdoba', 'Bv. Chacabuco', 1220, 'Frente a la plaza'),
(8, 'Argentina', 'Mendoza', 'Godoy Cruz', 'San Martín', 350, 'Casa esquina'),
(9, 'Argentina', 'Santa Fe', 'Rosario Centro', 'Córdoba', 890, 'Piso 5'),
(10, 'Argentina', 'Tucumán', 'Yerba Buena', 'Aconquija', 150, 'Casa con rejas verdes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

CREATE TABLE `emails` (
  `id_email` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `emails`
--

INSERT INTO `emails` (`id_email`, `correo`) VALUES
(1, 'juan.perez@mail.com'),
(2, 'maria.gomez@mail.com'),
(3, 'lucas.fernandez@mail.com'),
(4, 'sofia.martinez@mail.com'),
(5, 'carlos.lopez@mail.com'),
(6, 'lucas.perez@example.com'),
(7, 'sofia.gomez@example.com'),
(8, 'martin.fernandez@example.com'),
(9, 'camila.rodriguez@example.com'),
(10, 'julian.lopez@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipamiento_sillones`
--

CREATE TABLE `equipamiento_sillones` (
  `id_equipamiento` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `id_sillon` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `fecha_factura` date NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `estado` varchar(20) DEFAULT 'Emitida'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_procedimiento` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_pago`
--

CREATE TABLE `formas_pago` (
  `id_forma_pago` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_familiares`
--

CREATE TABLE `grupos_familiares` (
  `id_grupo_familiar` int(11) NOT NULL,
  `nombre_grupo` varchar(100) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos_familiares`
--

INSERT INTO `grupos_familiares` (`id_grupo_familiar`, `nombre_grupo`, `fecha_creacion`) VALUES
(1, 'Familia Pérez', '2024-01-01'),
(2, 'Familia Gómez', '2024-01-05'),
(3, 'Familia Fernández', '2024-01-10'),
(4, 'Familia Martínez', '2024-01-15'),
(5, 'Familia López', '2024-01-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_profesionales`
--

CREATE TABLE `horarios_profesionales` (
  `id_horario` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `dia_semana` varchar(45) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios_profesionales`
--

INSERT INTO `horarios_profesionales` (`id_horario`, `id_profesional`, `dia_semana`, `hora_inicio`, `hora_fin`, `activo`) VALUES
(1, 1, 'Lunes', '08:00:00', '12:00:00', 1),
(2, 1, 'Miércoles', '14:00:00', '18:00:00', 1),
(3, 2, 'Martes', '09:00:00', '13:00:00', 1),
(4, 2, 'Jueves', '15:00:00', '19:00:00', 1),
(5, 3, 'Lunes', '10:00:00', '14:00:00', 1),
(6, 3, 'Viernes', '08:00:00', '12:00:00', 1),
(7, 4, 'Miércoles', '09:00:00', '13:00:00', 1),
(8, 4, 'Viernes', '15:00:00', '19:00:00', 1),
(9, 5, 'Martes', '08:00:00', '12:00:00', 1),
(10, 5, 'Jueves', '14:00:00', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidaciones`
--

CREATE TABLE `liquidaciones` (
  `id_liquidacion` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `periodo_desde` date NOT NULL,
  `periodo_hasta` date NOT NULL,
  `total_bruto` int(100) NOT NULL,
  `descuentos` int(100) NOT NULL,
  `total_neto` int(100) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidacion_detalle`
--

CREATE TABLE `liquidacion_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_liquidacion` int(11) NOT NULL,
  `id_procedimiento` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `base_calculo` decimal(10,2) NOT NULL,
  `porcentaje` int(100) NOT NULL,
  `importe` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas_precios`
--

CREATE TABLE `listas_precios` (
  `id_lista` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `id_obra_social` int(11) DEFAULT NULL,
  `fecha_vigencia_desde` date NOT NULL,
  `fecha_vigencia_hasta` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_espera`
--

CREATE TABLE `lista_espera` (
  `id_espera` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `prioridad` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes_materiales`
--

CREATE TABLE `lotes_materiales` (
  `id_lote` int(11) NOT NULL,
  `id_material` int(11) DEFAULT NULL,
  `numero_lote` varchar(50) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `cantidad` int(11) DEFAULT 0,
  `precio_compra` decimal(10,2) DEFAULT 0.00,
  `fecha_ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id_material` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `unidad_medida` varchar(50) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT 0,
  `stock_actual` int(11) DEFAULT 0,
  `precio_compra` decimal(10,2) DEFAULT 0.00,
  `precio_venta` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material_tratamiento`
--

CREATE TABLE `material_tratamiento` (
  `id_uso` int(11) NOT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `id_lote` int(11) DEFAULT NULL,
  `cantidad_usada` int(11) DEFAULT 0,
  `fecha_uso` date DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomencladores`
--

CREATE TABLE `nomencladores` (
  `id_nomenclador` int(11) NOT NULL,
  `id_obra_social` int(11) NOT NULL,
  `codigo_practica` varchar(45) NOT NULL,
  `descripcion_practica` varchar(100) NOT NULL,
  `valor` int(100) NOT NULL,
  `porcentaje_cobertura` int(100) NOT NULL,
  `fecha_vigente_desde` date NOT NULL,
  `fecha_vigente_hasta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras_sociales`
--

CREATE TABLE `obras_sociales` (
  `id_obra_social` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_direccion` int(100) NOT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `obras_sociales`
--

INSERT INTO `obras_sociales` (`id_obra_social`, `nombre`, `codigo`, `telefono`, `email`, `id_direccion`, `activo`) VALUES
(1, 'OSDE', 'OSDE001', 1140001111, 'info@osde.com', 1, 1),
(2, 'Swiss Medical', 'SWM001', 1140002222, 'info@swissmedical.com', 2, 1),
(3, 'IOMA', 'IOMA001', 2147483647, 'info@ioma.com', 3, 1),
(4, 'Medifé', 'MED001', 1140004444, 'info@medife.com', 4, 1),
(5, 'Galeno', 'GAL001', 1140005555, 'info@galeno.com', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontograma`
--

CREATE TABLE `odontograma` (
  `id_odontograma` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_pieza` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `id_profesional` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compra`
--

CREATE TABLE `ordenes_compra` (
  `id_orden` int(11) NOT NULL,
  `numero_orden` varchar(50) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha_orden` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT 0.00,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra_detalle`
--

CREATE TABLE `orden_compra_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_orden` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT 0,
  `precio_unitario` decimal(10,2) DEFAULT 0.00,
  `subtotal` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `id_persona` int(100) NOT NULL,
  `id_grupo_familiar` int(100) NOT NULL,
  `id_obra_social` int(100) NOT NULL,
  `nro_afiliado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `id_persona`, `id_grupo_familiar`, `id_obra_social`, `nro_afiliado`) VALUES
(1, 1, 1, 1, 'OSDE-12345'),
(2, 2, 2, 2, 'SWM-54321'),
(3, 3, 3, 3, 'IOMA-67890'),
(4, 4, 4, 4, 'MED-11223'),
(5, 5, 5, 5, 'GAL-99887'),
(6, 11, 0, 1, 'osde509'),
(7, 12, 0, 4, 'medife009');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `id_forma_pago` int(11) NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `fecha_pago` date NOT NULL,
  `numero_recibo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nac` date NOT NULL,
  `dni` int(8) NOT NULL,
  `telefono` int(11) NOT NULL,
  `id_email` int(100) NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `id_direccion` int(100) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `apellido`, `fecha_nac`, `dni`, `telefono`, `id_email`, `sexo`, `id_direccion`, `estado`) VALUES
(1, 'Juan', 'Pérez', '1990-05-12', 30111222, 1145678900, 1, 'M', 1, 1),
(2, 'María', 'Gómez', '1985-09-30', 28999888, 2147483647, 2, 'F', 2, 1),
(3, 'Lucas', 'Fernández', '2000-02-18', 40988776, 2147483647, 3, 'M', 3, 1),
(4, 'Sofía', 'Martínez', '1995-11-22', 37222444, 2147483647, 4, 'F', 4, 1),
(5, 'Carlos', 'López', '1988-03-05', 29911333, 2147483647, 5, 'M', 5, 1),
(6, 'Lucas', 'Perez', '1990-03-15', 30123456, 1134567890, 6, 'M', 6, 1),
(7, 'Sofia', 'Gomez', '1995-07-20', 34567890, 1145678901, 7, 'F', 7, 1),
(8, 'Martin', 'Fernandez', '1988-11-05', 28900123, 1123456789, 8, 'M', 8, 1),
(9, 'Camila', 'Rodriguez', '2000-01-10', 40222333, 1156789012, 9, 'F', 9, 1),
(10, 'Julian', 'Lopez', '1992-09-25', 32555666, 1167890123, 10, 'M', 10, 1),
(11, 'solange', 'deutz', '2007-03-17', 46783531, 2147483647, 0, 'F', 0, 1),
(12, 'cristian', 'armoa', '2007-02-14', 46783108, 2147483647, 0, 'F', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piezas_dentales`
--

CREATE TABLE `piezas_dentales` (
  `id_pieza` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_diente` varchar(50) DEFAULT NULL,
  `arcada` varchar(20) DEFAULT NULL,
  `cuadrante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_tratamiento`
--

CREATE TABLE `planes_tratamiento` (
  `id_plan` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `fecha_plan` date NOT NULL,
  `estado` varchar(50) DEFAULT 'Pendiente',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_tratamiento_detalle`
--

CREATE TABLE `plan_tratamiento_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `id_tratamiento` int(11) NOT NULL,
  `id_pieza` int(11) DEFAULT NULL,
  `etapa` int(11) DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_tratamientos`
--

CREATE TABLE `precios_tratamientos` (
  `id_precio` int(11) NOT NULL,
  `id_lista` int(11) NOT NULL,
  `id_tratamiento` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_actualizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_plan` int(11) DEFAULT NULL,
  `numero_presupuesto` varchar(50) NOT NULL,
  `fecha_presupuesto` date NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `estado` varchar(20) DEFAULT 'Pendiente',
  `fecha_vencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuesto_detalle`
--

CREATE TABLE `presupuesto_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL,
  `id_tratamiento` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos_realizados`
--

CREATE TABLE `procedimientos_realizados` (
  `id_procedimiento` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `id_tratamiento` int(11) NOT NULL,
  `id_pieza` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesionales`
--

CREATE TABLE `profesionales` (
  `id_profesional` int(11) NOT NULL,
  `id_persona` int(100) NOT NULL,
  `matricula` varchar(100) NOT NULL,
  `id_tipo_profesional` int(11) NOT NULL,
  `id_especialidad` int(100) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesionales`
--

INSERT INTO `profesionales` (`id_profesional`, `id_persona`, `matricula`, `id_tipo_profesional`, `id_especialidad`, `activo`) VALUES
(1, 6, 'MAT-ODO-1234', 1, 1, 1),
(2, 7, 'MAT-ODO-5678', 1, 1, 1),
(3, 8, 'MAT-ODO-9101', 1, 1, 1),
(4, 9, 'MAT-CARD-2020', 2, 2, 1),
(5, 10, 'MAT-PED-3030', 3, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesional_especialidades`
--

CREATE TABLE `profesional_especialidades` (
  `id_profesional` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `fecha_certificacion` date DEFAULT NULL,
  `institucion_certificadora` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `cuit` varchar(20) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sillones`
--

CREATE TABLE `sillones` (
  `id_sillon` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_creacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sillones`
--

INSERT INTO `sillones` (`id_sillon`, `nombre`, `descripcion`, `activo`, `fecha_creacion`) VALUES
(1, 'Sillón 1', 'Sillón odontológico estándar', 1, '2024-01-01'),
(2, 'Sillón 2', 'Sillón odontológico con lámpara LED', 1, '2024-01-01'),
(3, 'Sillón 3', 'Sillón para cirugías dentales', 1, '2024-01-01'),
(4, 'Sillón 4', 'Sillón para revisiones generales', 1, '2024-01-01'),
(5, 'Sillón 5', 'Sillón pediátrico', 1, '2024-01-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_profesional`
--

CREATE TABLE `tipo_profesional` (
  `id_tipo_profesional` int(11) NOT NULL,
  `tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_profesional`
--

INSERT INTO `tipo_profesional` (`id_tipo_profesional`, `tipo`) VALUES
(1, 'Odontólogo'),
(2, 'Radiologo'),
(3, 'Asistente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuarios`
--

CREATE TABLE `tipo_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuarios`
--

INSERT INTO `tipo_usuarios` (`id_tipo_usuario`, `tipo`) VALUES
(1, 'Admin'),
(2, 'paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `id_tratamiento` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `duracion_estimada` int(11) DEFAULT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_profesional` int(11) NOT NULL,
  `id_sillon` int(11) NOT NULL,
  `fecha_turno` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` varchar(20) NOT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turno`, `id_paciente`, `id_profesional`, `id_sillon`, `fecha_turno`, `hora_inicio`, `hora_fin`, `estado`, `observaciones`) VALUES
(1, 1, 1, 1, '2024-08-26', '09:00:00', '09:30:00', 'Confirmado', 'Consulta inicial odontológica'),
(2, 2, 2, 2, '2024-08-26', '10:00:00', '10:30:00', 'Pendiente', 'Chequeo dental'),
(3, 3, 3, 3, '2024-08-27', '11:00:00', '11:45:00', 'Cancelado', 'Extracción de muela'),
(4, 4, 4, 4, '2024-08-28', '15:00:00', '15:30:00', 'Confirmado', 'Consulta cardiológica'),
(5, 5, 5, 5, '2024-08-29', '16:00:00', '16:30:00', 'Pendiente', 'Control pediátrico'),
(6, 6, 1, 1, '2025-09-01', '08:00:00', '09:00:00', 'pendiente', 'dolor fuerte en la muela'),
(7, 7, 1, 2, '2025-09-03', '14:00:00', '15:00:00', 'pendiente', 'caries frecuentes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `id_tipo_usuario` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombre`, `clave`, `id_tipo_usuario`) VALUES
(1, 'solchi', '1234', 1),
(2, 'silvi', '1122', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD PRIMARY KEY (`id_antecedente`);

--
-- Indices de la tabla `archivos_paciente`
--
ALTER TABLE `archivos_paciente`
  ADD PRIMARY KEY (`id_archivo`);

--
-- Indices de la tabla `bloqueos_horarios`
--
ALTER TABLE `bloqueos_horarios`
  ADD PRIMARY KEY (`id_bloqueo`);

--
-- Indices de la tabla `categorias_materiales`
--
ALTER TABLE `categorias_materiales`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `config_honorarios`
--
ALTER TABLE `config_honorarios`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `cuenta_corriente`
--
ALTER TABLE `cuenta_corriente`
  ADD PRIMARY KEY (`id_movimiento`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id_email`);

--
-- Indices de la tabla `equipamiento_sillones`
--
ALTER TABLE `equipamiento_sillones`
  ADD PRIMARY KEY (`id_equipamiento`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `formas_pago`
--
ALTER TABLE `formas_pago`
  ADD PRIMARY KEY (`id_forma_pago`);

--
-- Indices de la tabla `grupos_familiares`
--
ALTER TABLE `grupos_familiares`
  ADD PRIMARY KEY (`id_grupo_familiar`);

--
-- Indices de la tabla `horarios_profesionales`
--
ALTER TABLE `horarios_profesionales`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `liquidacion_detalle`
--
ALTER TABLE `liquidacion_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `listas_precios`
--
ALTER TABLE `listas_precios`
  ADD PRIMARY KEY (`id_lista`);

--
-- Indices de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`id_espera`);

--
-- Indices de la tabla `lotes_materiales`
--
ALTER TABLE `lotes_materiales`
  ADD PRIMARY KEY (`id_lote`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `material_tratamiento`
--
ALTER TABLE `material_tratamiento`
  ADD PRIMARY KEY (`id_uso`);

--
-- Indices de la tabla `odontograma`
--
ALTER TABLE `odontograma`
  ADD PRIMARY KEY (`id_odontograma`);

--
-- Indices de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indices de la tabla `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `piezas_dentales`
--
ALTER TABLE `piezas_dentales`
  ADD PRIMARY KEY (`id_pieza`);

--
-- Indices de la tabla `planes_tratamiento`
--
ALTER TABLE `planes_tratamiento`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `plan_tratamiento_detalle`
--
ALTER TABLE `plan_tratamiento_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `precios_tratamientos`
--
ALTER TABLE `precios_tratamientos`
  ADD PRIMARY KEY (`id_precio`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`);

--
-- Indices de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `procedimientos_realizados`
--
ALTER TABLE `procedimientos_realizados`
  ADD PRIMARY KEY (`id_procedimiento`);

--
-- Indices de la tabla `profesionales`
--
ALTER TABLE `profesionales`
  ADD PRIMARY KEY (`id_profesional`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `sillones`
--
ALTER TABLE `sillones`
  ADD PRIMARY KEY (`id_sillon`);

--
-- Indices de la tabla `tipo_profesional`
--
ALTER TABLE `tipo_profesional`
  ADD PRIMARY KEY (`id_tipo_profesional`);

--
-- Indices de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`id_tratamiento`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id_turno`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  MODIFY `id_antecedente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivos_paciente`
--
ALTER TABLE `archivos_paciente`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bloqueos_horarios`
--
ALTER TABLE `bloqueos_horarios`
  MODIFY `id_bloqueo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_materiales`
--
ALTER TABLE `categorias_materiales`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `config_honorarios`
--
ALTER TABLE `config_honorarios`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuenta_corriente`
--
ALTER TABLE `cuenta_corriente`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `emails`
--
ALTER TABLE `emails`
  MODIFY `id_email` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `equipamiento_sillones`
--
ALTER TABLE `equipamiento_sillones`
  MODIFY `id_equipamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formas_pago`
--
ALTER TABLE `formas_pago`
  MODIFY `id_forma_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos_familiares`
--
ALTER TABLE `grupos_familiares`
  MODIFY `id_grupo_familiar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `horarios_profesionales`
--
ALTER TABLE `horarios_profesionales`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `liquidacion_detalle`
--
ALTER TABLE `liquidacion_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `listas_precios`
--
ALTER TABLE `listas_precios`
  MODIFY `id_lista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `id_espera` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes_materiales`
--
ALTER TABLE `lotes_materiales`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `material_tratamiento`
--
ALTER TABLE `material_tratamiento`
  MODIFY `id_uso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `odontograma`
--
ALTER TABLE `odontograma`
  MODIFY `id_odontograma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ordenes_compra`
--
ALTER TABLE `ordenes_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_compra_detalle`
--
ALTER TABLE `orden_compra_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `piezas_dentales`
--
ALTER TABLE `piezas_dentales`
  MODIFY `id_pieza` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes_tratamiento`
--
ALTER TABLE `planes_tratamiento`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_tratamiento_detalle`
--
ALTER TABLE `plan_tratamiento_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios_tratamientos`
--
ALTER TABLE `precios_tratamientos`
  MODIFY `id_precio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuesto_detalle`
--
ALTER TABLE `presupuesto_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimientos_realizados`
--
ALTER TABLE `procedimientos_realizados`
  MODIFY `id_procedimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesionales`
--
ALTER TABLE `profesionales`
  MODIFY `id_profesional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sillones`
--
ALTER TABLE `sillones`
  MODIFY `id_sillon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_profesional`
--
ALTER TABLE `tipo_profesional`
  MODIFY `id_tipo_profesional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuarios`
--
ALTER TABLE `tipo_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `id_tratamiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
