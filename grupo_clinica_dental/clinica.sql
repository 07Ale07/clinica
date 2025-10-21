-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2025 a las 16:28:05
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
-- Base de datos: `clinica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `admin` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id_admin`, `admin`, `clave`) VALUES
(1, 'sol', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_permisos`
--

CREATE TABLE `admin_permisos` (
  `id_admin_permiso` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_permiso` int(11) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes_medicos`
--

CREATE TABLE `antecedentes_medicos` (
  `id_antecedente` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `enfermedades_cronicas` text DEFAULT NULL,
  `medicamentos_actuales` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `id_asistente` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id_cargo` int(11) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `puede_liquidar_honorarios` tinyint(1) DEFAULT 0,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id_cargo`, `cargo`, `descripcion`, `puede_liquidar_honorarios`, `activo`) VALUES
(1, 'Odontólogo Genera', 'Profesional encargado de la atención odontológica básica, diagnóstico y tratamientos generales.', 1, 0),
(2, 'Recepcionista', 'Personal administrativo responsable de la atención al paciente, turnos y gestión de historias clínicas.', 0, 1),
(3, 'Radiologo', 'hace radiografias', 1, 0),
(4, 'farmaceutico', 'farmaceutico', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo_empleados`
--

CREATE TABLE `cargo_empleados` (
  `id_cargo_empleados` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo_empleados`
--

INSERT INTO `cargo_empleados` (`id_cargo_empleados`, `id_empleado`, `id_cargo`, `activo`) VALUES
(6, 1, 1, 1),
(7, 2, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_material`
--

CREATE TABLE `categorias_material` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_sillon` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `estado` enum('pendiente','confirmada','completada','cancelada','no_asistio') DEFAULT NULL,
  `tipo` enum('consulta','tratamiento','control') DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_paciente`, `id_empleado`, `id_sillon`, `fecha_inicio`, `fecha_fin`, `estado`, `tipo`, `id_procedimiento`, `observaciones`) VALUES
(1, 3, 1, 1, '2026-03-02 09:00:00', '2026-03-02 10:00:00', 'pendiente', 'consulta', 1, 'ninguna'),
(2, 3, 4, 2, '2025-09-23 09:00:00', '2025-09-23 10:00:00', 'pendiente', 'consulta', 2, 'ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `numero_factura` varchar(50) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `estado` enum('pendiente','recibida','cancelada') DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_recordatorios`
--

CREATE TABLE `configuracion_recordatorios` (
  `id_configuracion` int(11) NOT NULL,
  `horas_antes` int(11) DEFAULT 24,
  `metodo_primario` enum('email','sms','whatsapp') DEFAULT NULL,
  `metodo_secundario` enum('email','sms','whatsapp','ninguno') DEFAULT NULL,
  `plantilla_mensaje` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_consulta` datetime DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos_emergencia`
--

CREATE TABLE `contactos_emergencia` (
  `id_contacto` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `parentesco` varchar(30) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_configs`
--

CREATE TABLE `contact_configs` (
  `id` int(11) NOT NULL,
  `config_json` text NOT NULL,
  `status` enum('aplicado','espera') NOT NULL DEFAULT 'espera',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contact_configs`
--

INSERT INTO `contact_configs` (`id`, `config_json`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"contact_address\":\"Av. Principal \",\"contact_phones\":\"(123) 456-7890\\r\\n(123) 456-7891\",\"contact_emails\":\"info@dentalsmile.com\\r\\ncitas@dentalsmile.com\",\"contact_hours\":\"Lunes a Viernes: 9:00 - 18:00\\r\\nSábados: 9:00 - 13:00\\r\\nDomingos: Cerrado\",\"social_facebook\":\"#\",\"social_instagram\":\"#\",\"social_twitter\":\"#\",\"social_youtube\":\"#\"}', 'espera', '2025-09-05 03:02:55', '2025-09-05 03:17:58'),
(2, '{\"contact_address\":\"Av. Principal mn\",\"contact_phones\":\"(123) 456-7890\\r\\n(123) 456-7891\",\"contact_emails\":\"info@dentalsmile.com\\r\\ncitas@dentalsmile.com\",\"contact_hours\":\"Lunes a Viernes: 9:00 - 18:00\\r\\nSábados: 9:00 - 13:00\\r\\nDomingos: Cerrado\",\"social_facebook\":\"#\",\"social_instagram\":\"#\",\"social_twitter\":\"#\",\"social_youtube\":\"#\"}', 'aplicado', '2025-09-05 03:17:54', '2025-09-05 03:17:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `convenios`
--

CREATE TABLE `convenios` (
  `id_convenio` int(11) NOT NULL,
  `id_obra_social` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `porcentaje_cobertura` decimal(5,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id_detalle_compra` int(11) NOT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_material` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `id_lote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_facturas`
--

CREATE TABLE `detalle_facturas` (
  `id_detalle` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_liquidaciones`
--

CREATE TABLE `detalle_liquidaciones` (
  `id_detalle_liquidacion` int(11) NOT NULL,
  `id_liquidacion` int(11) DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `monto_base` decimal(10,2) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `monto_honorario` decimal(10,2) DEFAULT NULL,
  `fecha_procedimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_presupuestos`
--

CREATE TABLE `detalle_presupuestos` (
  `id_detalle_presupuesto` int(11) NOT NULL,
  `id_presupuesto` int(11) DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnosticos`
--

CREATE TABLE `diagnosticos` (
  `id_diagnostico` int(11) NOT NULL,
  `id_consulta` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion_os`
--

CREATE TABLE `documentacion_os` (
  `id_documento` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_obra_social` int(11) DEFAULT NULL,
  `tipo` enum('autorizacion','presentacion','reintegro') DEFAULT NULL,
  `fecha_documento` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `estado` enum('pendiente','presentado','aprobado','rechazado') DEFAULT NULL,
  `archivo` longblob DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `numero_legajo` varchar(20) DEFAULT NULL,
  `id_persona` int(11) NOT NULL,
  `tipo_contrato` enum('permanente','temporal','honorarios','pasantia') NOT NULL,
  `telefono_interno` varchar(15) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `numero_legajo`, `id_persona`, `tipo_contrato`, `telefono_interno`, `foto`) VALUES
(1, 'OD001', 10, 'permanente', '101', 'doctora.png'),
(2, 'OD002', 11, 'permanente', '102', 'doctor.png'),
(3, 'OD003', 12, 'honorarios', '103', 'doctora2.png'),
(4, 'OD004', 13, 'temporal', '104', 'doctor1.png'),
(5, 'OD005', 14, 'permanente', '105', 'doctora3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_asistidos`
--

CREATE TABLE `empleado_asistidos` (
  `id_empleado_asistido` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_asistente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_especialidades`
--

CREATE TABLE `empleado_especialidades` (
  `id_emplado_especialidad` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_especialidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado_especialidades`
--

INSERT INTO `empleado_especialidades` (`id_emplado_especialidad`, `id_empleado`, `id_especialidad`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado_liquidaciones`
--

CREATE TABLE `empleado_liquidaciones` (
  `id_empleado_liquidacion` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL,
  `parametros` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL,
  `especialidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudios_odontologicos`
--

CREATE TABLE `estudios_odontologicos` (
  `id_estudio` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `tipo` enum('radiografia','foto_intraoral','modelo','otro') DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `archivo` longblob DEFAULT NULL,
  `fecha_carga` datetime DEFAULT NULL,
  `formato_archivo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas_tratamiento`
--

CREATE TABLE `etapas_tratamiento` (
  `id_etapa` int(11) NOT NULL,
  `id_plan` int(11) DEFAULT NULL,
  `numero_etapa` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio_estimada` date DEFAULT NULL,
  `fecha_fin_estimada` date DEFAULT NULL,
  `estado` enum('pendiente','en_progreso','completado','cancelado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `excepciones_horario`
--

CREATE TABLE `excepciones_horario` (
  `id_excepcion` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `tipo` enum('vacaciones','permiso','capacitación','otro') DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `estado` enum('pendiente','pagada','anulada') DEFAULT NULL,
  `tipo` enum('A','B','C') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiares`
--

CREATE TABLE `familiares` (
  `id_familiar` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `parentesco` varchar(30) DEFAULT NULL,
  `responsable` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_familiares`
--

CREATE TABLE `grupos_familiares` (
  `id_grupo` int(11) NOT NULL,
  `nombre_familia` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_administrativo`
--

CREATE TABLE `historial_administrativo` (
  `id_historial` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `tipo` enum('llamada','email','mensaje','otro') DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `responsable` varchar(100) DEFAULT NULL,
  `resumen` text DEFAULT NULL,
  `seguimiento_requerido` tinyint(1) DEFAULT 0,
  `fecha_seguimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_empleados`
--

CREATE TABLE `horario_empleados` (
  `id_horario` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_desde` date DEFAULT NULL,
  `fecha_hasta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario_empleados`
--

INSERT INTO `horario_empleados` (`id_horario`, `id_empleado`, `dia_semana`, `hora_inicio`, `hora_fin`, `activo`, `fecha_desde`, `fecha_hasta`) VALUES
(1, 1, 'Lunes', '08:00:00', '12:00:00', 1, '2025-01-01', NULL),
(2, 2, 'Martes', '14:00:00', '20:00:00', 1, '2025-01-01', NULL),
(3, 3, 'Miércoles', '09:00:00', '13:00:00', 1, '2025-01-01', '2025-12-31'),
(4, 4, 'Jueves', '10:00:00', '18:00:00', 1, '2025-02-01', NULL),
(5, 5, 'Sábado', '08:30:00', '12:30:00', 1, '2025-03-01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `landing_configs`
--

CREATE TABLE `landing_configs` (
  `id` int(11) NOT NULL,
  `config_json` longtext NOT NULL,
  `status` enum('espera','aplicado') DEFAULT 'espera',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `landing_configs`
--

INSERT INTO `landing_configs` (`id`, `config_json`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"test\":\"prueba\"}', 'espera', '2025-09-02 02:54:37', '0000-00-00 00:00:00'),
(2, '{\"header_title\":\"DentalSmile Alejandro magno ahre\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\",\"Ubicación\"],\"hero_title\":\"Tu sonrisa es nuestra prioridad\",\"hero_description\":\"Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad\",\"hero_button1\":\"Solicitar Cita\",\"hero_button2\":\"Nuestros Servicios\",\"services_title\":\"Nuestros Servicios\",\"services\":[{\"image\":\"\",\"title\":\"Blanqueamiento Dental\",\"description\":\"Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.\",\"icon\":\"fas fa-tooth\"},{\"image\":\"\",\"title\":\"Ortodoncia\",\"description\":\"Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.\",\"icon\":\"fas fa-teeth\"},{\"image\":\"\",\"title\":\"Limpieza Dental\",\"description\":\"Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.\",\"icon\":\"fas fa-toothbrush\"},{\"image\":\"\",\"title\":\"Implantes Dentales\",\"description\":\"Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.\",\"icon\":\"fas fa-teeth-open\"}],\"about_title\":\"Expertos en salud dental\",\"about_description\":\"En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.\",\"about_button\":\"Conoce más sobre nosotros\",\"about_image\":\"https:\\/\\/images.unsplash.com\\/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80\",\"testimonials_title\":\"Lo que dicen nuestros pacientes\",\"testimonials\":[{\"quote\":\"\\\"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente.\\\"\",\"name\":\"María González\",\"since\":\"Paciente desde 2018\"},{\"quote\":\"\\\"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!\\\"\",\"name\":\"Carlos Rodríguez\",\"since\":\"Paciente desde 2020\"},{\"quote\":\"\\\"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales.\\\"\",\"name\":\"Ana Martínez\",\"since\":\"Paciente desde 2015\"}],\"cta_title\":\"¿Necesitas una consulta?\",\"cta_description\":\"Solicita tu cita ahora y recibe una evaluación completa sin compromiso\",\"cta_button\":\"\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\r\\nSábado: 9:00 - 13:00\\r\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'espera', '2025-09-02 03:12:42', '2025-09-02 11:38:39'),
(3, '{\"header_title\":\"DentalSmile Alejandro \",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\",\"Ubicación\"],\"hero_title\":\"Tu sonrisa es nuestra prioridad\",\"hero_description\":\"Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad\",\"hero_button1\":\"Solicitar Cita\",\"hero_button2\":\"Nuestros Servicios\",\"services_title\":\"Nuestros Servicios\",\"services\":[{\"image\":\"\",\"title\":\"Blanqueamiento Dental\",\"description\":\"Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.\",\"icon\":\"fas fa-tooth\"},{\"image\":\"\",\"title\":\"Ortodoncia\",\"description\":\"Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.\",\"icon\":\"fas fa-teeth\"},{\"image\":\"\",\"title\":\"Limpieza Dental\",\"description\":\"Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.\",\"icon\":\"fas fa-toothbrush\"},{\"image\":\"\",\"title\":\"Implantes Dentales\",\"description\":\"Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.\",\"icon\":\"fas fa-teeth-open\"}],\"about_title\":\"Expertos en salud dental\",\"about_description\":\"En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.\",\"about_button\":\"Conoce más sobre nosotros\",\"about_image\":\"https:\\/\\/images.unsplash.com\\/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80\",\"testimonials_title\":\"Lo que dicen nuestros pacientes\",\"testimonials\":[{\"quote\":\"\\\"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente.\\\"\",\"name\":\"María González\",\"since\":\"Paciente desde 2018\"},{\"quote\":\"\\\"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!\\\"\",\"name\":\"Carlos Rodríguez\",\"since\":\"Paciente desde 2020\"},{\"quote\":\"\\\"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales.\\\"\",\"name\":\"Ana Martínez\",\"since\":\"Paciente desde 2015\"}],\"cta_title\":\"¿Necesitas una consulta?\",\"cta_description\":\"Solicita tu cita ahora y recibe una evaluación completa sin compromiso\",\"cta_button\":\"\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\r\\nSábado: 9:00 - 13:00\\r\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'aplicado', '2025-09-02 04:16:22', '2025-09-02 12:22:42'),
(4, '{\"header_title\":\"DentalSmile\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\",\"Ubicación\"],\"hero_title\":\"Tu sonrisa es nuestra prioridad\",\"hero_description\":\"Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad\",\"hero_button1\":\"Solicitar Cita\",\"hero_button2\":\"Nuestros Servicios\",\"services_title\":\"Nuestros Servicios\",\"services\":[{\"image\":\"\",\"title\":\"Blanqueamiento Dental\",\"description\":\"Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.\",\"icon\":\"fas fa-tooth\"},{\"image\":\"\",\"title\":\"Ortodoncia\",\"description\":\"Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.\",\"icon\":\"fas fa-teeth\"},{\"image\":\"\",\"title\":\"Limpieza Dental\",\"description\":\"Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.\",\"icon\":\"fas fa-toothbrush\"},{\"image\":\"\",\"title\":\"Implantes Dentales\",\"description\":\"Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.\",\"icon\":\"fas fa-teeth-open\"}],\"about_title\":\"Expertos en salud dental\",\"about_description\":\"En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.\",\"about_button\":\"Conoce más sobre nosotros\",\"about_image\":\"https:\\/\\/images.unsplash.com\\/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80\",\"testimonials_title\":\"Lo que dicen nuestros pacientes\",\"testimonials\":[{\"quote\":\"\\\"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente.\\\"\",\"name\":\"María González\",\"since\":\"Paciente desde 2018\"},{\"quote\":\"\\\"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!\\\"\",\"name\":\"Carlos Rodríguez\",\"since\":\"Paciente desde 2020\"},{\"quote\":\"\\\"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales.\\\"\",\"name\":\"Ana Martínez\",\"since\":\"Paciente desde 2015\"}],\"cta_title\":\"¿Necesitas una consulta?\",\"cta_description\":\"Solicita tu cita ahora y recibe una evaluación completa sin compromiso\",\"cta_button\":\"\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\r\\nSábado: 9:00 - 13:00\\r\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'espera', '2025-09-02 11:34:09', '2025-09-02 12:22:42'),
(5, '{\"header_title\":\"clase de la profe fide\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\",\"Ubicación\"],\"hero_title\":\"Tu sonrisa es nuestra prioridad\",\"hero_description\":\"Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad\",\"hero_button1\":\"Solicitar Cita\",\"hero_button2\":\"Nuestros Servicios\",\"services_title\":\"Nuestros Servicios\",\"services\":[{\"image\":\"\",\"title\":\"Blanqueamiento Dental\",\"description\":\"Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.\",\"icon\":\"fas fa-tooth\"},{\"image\":\"\",\"title\":\"Ortodoncia\",\"description\":\"Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.\",\"icon\":\"fas fa-teeth\"},{\"image\":\"\",\"title\":\"Limpieza Dental\",\"description\":\"Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.\",\"icon\":\"fas fa-toothbrush\"},{\"image\":\"\",\"title\":\"Implantes Dentales\",\"description\":\"Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.\",\"icon\":\"fas fa-teeth-open\"}],\"about_title\":\"Expertos en salud dental\",\"about_description\":\"En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.\",\"about_button\":\"Conoce más sobre nosotros\",\"about_image\":\"https:\\/\\/images.unsplash.com\\/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80\",\"testimonials_title\":\"Lo que dicen nuestros pacientes\",\"testimonials\":[{\"quote\":\"\\\"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente.\\\"\",\"name\":\"María González\",\"since\":\"Paciente desde 2018\"},{\"quote\":\"\\\"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!\\\"\",\"name\":\"Carlos Rodríguez\",\"since\":\"Paciente desde 2020\"},{\"quote\":\"\\\"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales.\\\"\",\"name\":\"Ana Martínez\",\"since\":\"Paciente desde 2015\"}],\"cta_title\":\"¿Necesitas una consulta?\",\"cta_description\":\"Solicita tu cita ahora y recibe una evaluación completa sin compromiso\",\"cta_button\":\"\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\r\\nSábado: 9:00 - 13:00\\r\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'espera', '2025-09-02 11:36:56', '2025-09-02 11:37:45'),
(6, '{\"header_title\":\"clase de la profe fide\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\",\"Ubicación\"],\"hero_title\":\"Tu sonrisa es nuestra prioridad\",\"hero_description\":\"Profesionales dedicados a cuidar de tu salud dental con los más altos estándares de calidad\",\"hero_button1\":\"Solicitar Cita\",\"hero_button2\":\"Nuestros Servicios\",\"services_title\":\"Nuestros Servicios\",\"services\":[{\"image\":\"\",\"title\":\"Blanqueamiento Dental\",\"description\":\"Recupera el blanco natural de tus dientes con nuestro tratamiento profesional.\",\"icon\":\"fas fa-tooth\"},{\"image\":\"\",\"title\":\"Ortodoncia\",\"description\":\"Corrige la alineación de tus dientes con nuestros tratamientos de ortodoncia.\",\"icon\":\"fas fa-teeth\"},{\"image\":\"\",\"title\":\"Limpieza Dental\",\"description\":\"Elimina el sarro y mantén tus dientes libres de bacterias con nuestra limpieza profesional.\",\"icon\":\"fas fa-toothbrush\"},{\"image\":\"\",\"title\":\"Implantes Dentales\",\"description\":\"Recupera la funcionalidad y estética de tu sonrisa con implantes de la más alta calidad.\",\"icon\":\"fas fa-teeth-open\"}],\"about_title\":\"Expertos en salud mental\",\"about_description\":\"En DentalSmile llevamos más de 15 años cuidando de las sonrisas de nuestros pacientes. Contamos con tecnología de última generación y un equipo de profesionales altamente cualificados.\",\"about_button\":\"Conoce más sobre nosotros\",\"about_image\":\"https:\\/\\/images.unsplash.com\\/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80\",\"testimonials_title\":\"Lo que dicen nuestros pacientes\",\"testimonials\":[{\"quote\":\"\\\"El mejor tratamiento dental que he recibido. Profesionales y un trato excelente.\\\"\",\"name\":\"María González\",\"since\":\"Paciente desde 2018\"},{\"quote\":\"\\\"Me realizaron un blanqueamiento dental y los resultados fueron increíbles. ¡Totalmente recomendable!\\\"\",\"name\":\"Carlos Rodríguez\",\"since\":\"Paciente desde 2020\"},{\"quote\":\"\\\"Llevo a mis hijos desde hace años y siempre contentos con el trato recibido. Grandes profesionales.\\\"\",\"name\":\"Ana Martínez\",\"since\":\"Paciente desde 2015\"}],\"cta_title\":\"¿Necesitas una consulta?\",\"cta_description\":\"Solicita tu cita ahora y recibe una evaluación completa sin compromiso\",\"cta_button\":\"\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\r\\nSábado: 9:00 - 13:00\\r\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'espera', '2025-09-02 11:37:41', '2025-09-02 11:38:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `liquidaciones_honorarios`
--

CREATE TABLE `liquidaciones_honorarios` (
  `id_liquidacion` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `total_honorarios` decimal(12,2) DEFAULT NULL,
  `estado` enum('pendiente','calculada','pagada','cancelada') DEFAULT NULL,
  `fecha_calculo` datetime DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_espera`
--

CREATE TABLE `lista_espera` (
  `id_lista_espera` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `prioridad` enum('normal','alta','urgente') DEFAULT NULL,
  `estado` enum('activa','atendida','cancelada') DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `id_lote` int(11) NOT NULL,
  `id_material` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `numero_lote` varchar(50) DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `cantidad_inicial` int(11) DEFAULT NULL,
  `cantidad_actual` int(11) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `almacenado_en` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id_material` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `unidad_medida` varchar(20) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales_procedimientos`
--

CREATE TABLE `materiales_procedimientos` (
  `id_material_procedimiento` int(11) NOT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `id_lote` int(11) DEFAULT NULL,
  `cantidad_usada` decimal(10,2) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `asunto` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes_contacto`
--

INSERT INTO `mensajes_contacto` (`id`, `nombre`, `email`, `telefono`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1, 'rufino el preguntas', 'paredesalejo38@gmail.com', '13561456', 'info', 'tengo sueño', '2025-09-05 05:54:11'),
(2, 'Solange Deutz', 'soldeutz0@gmail.com', '03704790981', 'info', 'hola a que hora abren', '2025-09-05 14:22:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos_liquidacion`
--

CREATE TABLE `modelos_liquidacion` (
  `id_modelo` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `formula` varchar(100) DEFAULT NULL,
  `variables` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`variables`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomencladores`
--

CREATE TABLE `nomencladores` (
  `id_nomenclador` int(11) NOT NULL,
  `id_obra_social` int(11) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `valor_os` decimal(10,2) DEFAULT NULL,
  `valor_clinica` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_personas`
--

CREATE TABLE `obra_personas` (
  `id_obra_persona` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_obra_social` int(11) DEFAULT NULL,
  `numero_afiliado` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_sociales`
--

CREATE TABLE `obra_sociales` (
  `id_obra_social` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `codigo_nacional` varchar(20) DEFAULT NULL,
  `cuit` varchar(15) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `pagina_web` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `requiere_autorizacion` tinyint(1) DEFAULT 0,
  `dias_carencia` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `obra_sociales`
--

INSERT INTO `obra_sociales` (`id_obra_social`, `nombre`, `codigo_nacional`, `cuit`, `telefono`, `email`, `direccion`, `pagina_web`, `activo`, `requiere_autorizacion`, `dias_carencia`) VALUES
(1, 'OSDE', 'OS001', '30-70721673-5', '0810-555-6733', 'contacto@osde.com.ar', 'Av. Leandro N. Alem 1067, CABA', 'https://www.osde.com.ar', 1, 1, 30),
(2, 'Swiss Medical', 'OS002', '30-70722001-9', '0810-333-8876', 'info@swissmedical.com.ar', 'Av. Juan B. Justo 907, CABA', 'https://www.swissmedical.com.ar', 1, 1, 15),
(3, 'PAMI', 'OS003', '30-54667892-3', '138', 'atencion@pami.org.ar', 'Av. Corrientes 655, CABA', 'https://www.pami.org.ar', 1, 0, 0),
(4, 'Galeno', 'OS004', '30-61578964-2', '0810-999-2600', 'afiliados@galeno.com.ar', 'Av. de Mayo 701, CABA', 'https://www.galeno.com.ar', 1, 1, 20),
(5, 'Medifé', 'OS005', '30-54890123-6', '0810-333-2700', 'consultas@medife.com.ar', 'Suipacha 1175, CABA', 'https://www.medife.com.ar', 1, 0, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontogramas`
--

CREATE TABLE `odontogramas` (
  `id_odontograma` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `odontograma` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`odontograma`)),
  `hecho` tinyint(1) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `odontogramas`
--

INSERT INTO `odontogramas` (`id_odontograma`, `id_paciente`, `odontograma`, `hecho`, `fecha_inicio`, `fecha_fin`, `fecha_actualizacion`) VALUES
(6, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,\"caries\",\"caries\",null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-15 19:06:48'),
(7, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,\"caries\",\"caries\",null,null,null,null,\"restauracion\",null,\"restauracion\",null,\"caries\",null,null,null,null,null,\"restauracion\",null,null,\"restauracion\",\"caries\",null,null,null,null,null,null,null,null,null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-15 19:06:58'),
(8, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",\"restauracion\",null,null,null,null,null,null,null,null,\"restauracion\",null,\"caries\",null,null,\"restauracion\",null,null,\"restauracion\",null,null,\"restauracion\",\"caries\",null,null,null,null,null,null,null,null,null,null,null]', NULL, NULL, NULL, '2025-08-15 19:07:44'),
(9, 1, '[]', NULL, NULL, NULL, '2025-08-15 22:55:17'),
(10, 2, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,\"caries\",null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-15 22:56:58'),
(11, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"restauracion\",null,null,\"restauracion\",null,null,\"restauracion\",null,null,null,null,null,null,null,null,null,null,\"restauracion\",null,null,null,null,null,null,\"restauracion\"]', NULL, NULL, NULL, '2025-08-15 22:57:09'),
(12, 2, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,\"caries\",null,null,\"restauracion\",null,null,null,null,null,null,null,null,null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-15 22:57:28'),
(13, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",\"caries\",null,null,null,null,null,\"restauracion\",null,null,\"restauracion\",null,null,\"restauracion\",null,null,null,null,null,\"caries\",null,\"caries\",null,null,\"restauracion\",null,null,null,\"caries\",null,null,\"restauracion\"]', NULL, NULL, NULL, '2025-08-15 23:11:20'),
(14, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null]', NULL, NULL, NULL, '2025-08-15 23:22:49'),
(15, 2, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",\"caries\",null,null,null,null,null,null,null,null,\"caries\",null,null,\"restauracion\",null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-16 01:07:51'),
(16, 2, '[null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,\"caries\",\"caries\",null,null,null,null,null,null,null,null,\"caries\",null,null,\"restauracion\",null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,\"caries\",null,null,\"caries\"]', NULL, NULL, NULL, '2025-08-16 01:14:11'),
(17, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"extraccion\",\"extraccion\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"extraccion\",null,null,null,\"extraccion\",null,null,null]', NULL, NULL, NULL, '2025-08-16 01:14:27'),
(18, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"extraccion\",\"extraccion\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"extraccion\",null,null,null,\"extraccion\",null,null,null]', NULL, NULL, NULL, '2025-08-16 01:29:49'),
(19, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,\"extraccion\",\"extraccion\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"extraccion\",null,null,null,\"extraccion\",null,null,null]', NULL, NULL, NULL, '2025-08-16 01:32:33'),
(20, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,\"extraccion\",null,null,null,\"restauracion\",null,null,null]', NULL, NULL, NULL, '2025-08-16 01:45:49'),
(21, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,null,null,null,\"extraccion\",null,null,null,\"restauracion\",\"restauracion\",null,null]', NULL, NULL, NULL, '2025-08-16 01:45:58'),
(22, 2, '[null,null,null,null,null,null,null,null,null,null,null,null,\"caries\",null,\"caries\",null,null,null,null,null,null,\"caries\",null,\"caries\",null,\"caries\",null,null,null,null,null,\"caries\",null,\"caries\",null,\"caries\",null,null,\"caries\",null,null,\"caries\",null,null,\"caries\",null]', NULL, NULL, NULL, '2025-08-16 01:52:07'),
(23, 2, '{\"15\":\"restauracion\",\"22\":\"restauracion\",\"26\":\"restauracion\",\"36\":\"restauracion\"}', NULL, NULL, NULL, '2025-08-20 13:33:41'),
(24, 1, '[null,null,null,null,null,null,null,null,null,null,null,null,null,\"restauracion\",\"caries\",null,\"caries\",null,null,null,null,\"caries\",null,null,\"caries\",null,\"restauracion\",null,null,null,null,\"caries\",\"caries\",\"caries\",null,\"caries\",null,null,\"extraccion\",null,null,null,null,\"caries\",null,\"caries\",\"caries\"]', NULL, NULL, NULL, '2025-08-20 13:39:19'),
(25, 4, '[null,null,null,null,null,null,null,null,null,null,null,null,\"restauracion\",\"caries\"]', NULL, NULL, NULL, '2025-08-29 12:03:36'),
(26, 2, '{\"12\":\"caries\",\"15\":\"restauracion\",\"22\":\"restauracion\",\"26\":\"restauracion\",\"36\":\"restauracion\"}', NULL, NULL, NULL, '2025-08-29 12:04:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id_paciente` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `tipo` enum('adulto','menor','geriatrico') DEFAULT NULL,
  `alergias` text DEFAULT NULL,
  `observaciones_generales` text DEFAULT NULL,
  `foto` longblob DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_paciente`, `id_persona`, `fecha_registro`, `tipo`, `alergias`, `observaciones_generales`, `foto`, `activo`) VALUES
(1, 1, '2025-08-15', NULL, 'hormigas', 'diente feo ', NULL, 1),
(2, 2, '2025-08-16', 'menor', 'al popo', 'dsdds', NULL, 1),
(3, 3, '2025-08-26', 'adulto', NULL, NULL, NULL, 1),
(4, 15, '2025-08-26', 'adulto', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_factura` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `metodo` enum('efectivo','tarjeta','transferencia') DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `DNI` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `apellido`, `DNI`) VALUES
(1, 'raul', 'ayala', '46783108'),
(2, 'sofia', 'ayala', '56614262'),
(3, 'Rufino', 'Paredes', '46783531'),
(10, 'Laura', 'Fernandez', '30214567'),
(11, 'Martín', 'Gómez', '28965432'),
(12, 'Carolina', 'Pereyra', '31547896'),
(13, 'Diego', 'Mansilla', '27890123'),
(14, 'Julieta', 'Dominguez', '32659874'),
(15, 'Sebastian', 'Delgado', '12345676');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes_tratamiento`
--

CREATE TABLE `planes_tratamiento` (
  `id_plan` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('pendiente','en_progreso','completado','cancelado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `valido_hasta` date DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `estado` enum('pendiente','aceptado','rechazado','vencido') DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos`
--

CREATE TABLE `procedimientos` (
  `id_procedimiento` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `costo` decimal(10,2) DEFAULT NULL,
  `img` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `procedimientos`
--

INSERT INTO `procedimientos` (`id_procedimiento`, `descripcion`, `costo`, `img`) VALUES
(1, 'Limpieza dental profesional (profilaxis)', 3500.00, 'limpieza2.png'),
(2, 'Extracción de muela de juicio', 12000.00, 'extraccion.png'),
(3, 'Tratamiento de conducto (endodoncia)', 18000.00, 'endodoncia.png'),
(4, 'Colocación de corona de porcelana', 25000.00, 'cona.png'),
(5, 'Blanqueamiento dental con luz LED', 15000.00, 'luzled.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos_realizados`
--

CREATE TABLE `procedimientos_realizados` (
  `id_realizado` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_procedimiento` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `img_antes` varchar(255) DEFAULT NULL,
  `img_despues` varchar(255) DEFAULT NULL,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `procedimientos_realizados`
--

INSERT INTO `procedimientos_realizados` (`id_realizado`, `id_paciente`, `id_procedimiento`, `id_empleado`, `fecha`, `img_antes`, `img_despues`, `observaciones`) VALUES
(1, 1, 1, 1, '2025-08-20', 'limpieza_antes.png', 'limieza_despues.png', 'Limpieza dental sin complicaciones.'),
(2, 2, 2, 3, '2025-08-25', 'antes_extraccion2.png', 'despues_extraccion2.png', 'Extracción de muela de juicio inferior izquierda, paciente toleró bien.'),
(3, 3, 5, 4, '2025-09-01', 'blanqueamiento1.png', 'blanqueamiento2.png', 'Blanqueamiento LED con excelente resultado estético.'),
(5, 4, 4, 2, '2020-09-17', 'corona1.png', 'corona2.png', 'Fácil implante de corona.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento_estudios`
--

CREATE TABLE `procedimiento_estudios` (
  `id_procedimiento_estudio` int(11) NOT NULL,
  `id_procedimiento` int(11) DEFAULT NULL,
  `id_estudio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `id_recordatorio` int(11) NOT NULL,
  `id_cita` int(11) DEFAULT NULL,
  `tipo` enum('email','sms','whatsapp') DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `estado` enum('pendiente','enviado','fallido') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_plantilla` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_generacion` datetime DEFAULT NULL,
  `parametros_usados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros_usados`)),
  `formato` enum('pdf','excel','html') DEFAULT NULL,
  `archivo` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_plantillas`
--

CREATE TABLE `reporte_plantillas` (
  `id_plantilla` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `tipo` enum('inventario','financiero','clinico','otros') DEFAULT NULL,
  `sql_query` text DEFAULT NULL,
  `parametros` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parametros`)),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sillones`
--

CREATE TABLE `sillones` (
  `id_sillon` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sillones`
--

INSERT INTO `sillones` (`id_sillon`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Sillón Odontológico 1', 'Sillón principal de atención general en el consultorio 1', 1),
(2, 'Sillón Odontológico 2', 'Sillón con lámpara LED y bandeja auxiliar, consultorio 2', 1),
(3, 'Sillón Odontológico Infantil', 'Diseñado para atención de niños, con sistema de sujeción adaptado', 1),
(4, 'Sillón de Cirugía', 'Equipado con instrumental quirúrgico y aspiración de alta potencia', 1),
(5, 'Sillón en Mantenimiento', 'Actualmente fuera de servicio por tareas de mantenimiento', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `somos_configs`
--

CREATE TABLE `somos_configs` (
  `id` int(11) NOT NULL,
  `config_json` text NOT NULL,
  `status` enum('espera','aplicado') DEFAULT 'espera',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `somos_configs`
--

INSERT INTO `somos_configs` (`id`, `config_json`, `status`, `created_at`, `updated_at`) VALUES
(4, '{\"header_title\":\"DentalSmile\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Contacto\"],\"about_title\":\"Quiénes Somos\",\"about_subtitle\":\"Conoce más sobre nuestra historia, valores y equipo profesional\",\"history_title\":\"Nuestra Historia\",\"history_description\":\"DentalSmile nació en 2008 con la visión de crear un centro dental donde la excelencia médica se combine con un trato humano y personalizado. Desde nuestros humildes comienzos con apenas dos consultorios, hemos crecido hasta convertirnos en una clínica de referencia en la ciudad. Nuestro fundador, el Dr. Javier Martínez, imaginó un espacio donde los pacientes se sintieran cómodos y seguros, rompiendo con el estereotipo de que ir al dentista debe ser una experiencia traumática.\",\"values_title\":\"Nuestros Valores\",\"values\":[{\"icon\":\"fas fa-user-md\",\"title\":\"Profesionalidad\",\"description\":\"Contamos con dentistas altamente cualificados y en constante formación para ofrecer los tratamientos más avanzados.\"},{\"icon\":\"fas fa-heart\",\"title\":\"Compromiso\",\"description\":\"Nos comprometemos con cada paciente de manera individual, buscando siempre la mejor solución para sus necesidades.\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Seguridad\",\"description\":\"Cumplimos con todos los protocolos de esterilización y seguridad para garantizar tratamientos seguros y confiables.\"},{\"icon\":\"fas fa-hands-helping\",\"title\":\"Empatía\",\"description\":\"Comprendemos las preocupaciones de nuestros pacientes y trabajamos para hacer de su visita una experiencia agradable.\"}],\"team\":[{\"image\":\"\",\"name\":\"Laura Fernandez\",\"role\":\"Odontólogo\",\"description\":\"Profesional dedicado de DentalSmile, especializado en Odontólogo.\"},{\"image\":\"\",\"name\":\"Martín Gómez\",\"role\":\"Odontólogo\",\"description\":\"Profesional dedicado de DentalSmile, especializado en Odontólogo.\"}],\"team_title\":\"Nuestro Equipo\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\nSábado: 9:00 - 13:00\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'espera', '2025-09-05 03:55:06', '2025-09-05 04:48:46'),
(5, '{\"header_title\":\"DentalSmile\",\"menu_items\":[\"Inicio\",\"Quiénes Somos\",\"Contacto\"],\"about_title\":\"Quiénes Somos\",\"about_subtitle\":\"Conoce más sobre nuestra historia, valores y equipo profesional\",\"history_title\":\"Nuestra Historia\",\"history_description\":\"DentalSmile nació en 2008 con la visión de crear un centro dental donde la excelencia médica se combine con un trato humano y personalizado. Desde nuestros humildes comienzos con apenas dos consultorios, hemos crecido hasta convertirnos en una clínica de referencia en la ciudad. Nuestro fundador, el Dr. Javier Martínez, imaginó un espacio donde los pacientes se sintieran cómodos y seguros, rompiendo con el estereotipo de que ir al dentista debe ser una experiencia traumática.\",\"values_title\":\"Nuestros Valores\",\"values\":[{\"icon\":\"fas fa-user-md\",\"title\":\"Profesionalidad\",\"description\":\"Contamos con dentistas altamente cualificados y en constante formación para ofrecer los tratamientos más avanzados.\"},{\"icon\":\"fas fa-heart\",\"title\":\"Compromiso\",\"description\":\"Nos comprometemos con cada paciente de manera individual, buscando siempre la mejor solución para sus necesidades.\"},{\"icon\":\"fas fa-shield-alt\",\"title\":\"Seguridad\",\"description\":\"Cumplimos con todos los protocolos de esterilización y seguridad para garantizar tratamientos seguros y confiables.\"},{\"icon\":\"fas fa-hands-helping\",\"title\":\"Empatía\",\"description\":\"Comprendemos las preocupaciones de nuestros pacientes y trabajamos para hacer de su visita una experiencia agradable.\"}],\"team\":[{\"image\":\"..\\/public\\/logo.png\",\"name\":\"Laura Fernandez\",\"role\":\"Odontólogo\",\"description\":\"Profesional dedicado de DentalSmile, especializado en Odontólogo.\"},{\"image\":\"..\\/public\\/logo.png\",\"name\":\"Martín Gómez\",\"role\":\"Odontólogo\",\"description\":\"Profesional dedicado de DentalSmile, especializado en Odontólogo.\"}],\"team_title\":\"Nuestro Equipo\",\"footer_title\":\"DentalSmile\",\"footer_description\":\"Tu clínica dental de confianza donde cuidamos de tu sonrisa con los más altos estándares de calidad.\",\"footer_links\":[\"Inicio\",\"Quiénes Somos\",\"Servicios\",\"Contacto\"],\"footer_address\":\"Av. Principal #123, Ciudad\",\"footer_phone\":\"(123) 456-7890\",\"footer_email\":\"info@dentalsmile.com\",\"footer_hours\":\"Lunes - Viernes: 9:00 - 18:00\\nSábado: 9:00 - 13:00\\nDomingo: Cerrado\",\"footer_copyright\":\"© 2023 DentalSmile - Todos los derechos reservados\"}', 'aplicado', '2025-09-05 04:48:41', '2025-09-05 04:48:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_empleado`, `usuario`, `clave`) VALUES
(1, 1, 'laura.fernandez', 'clave123'),
(2, 2, 'martin.gomez', 'clave123'),
(3, 3, 'carolina.pereyra', 'clave123'),
(4, 4, 'diego.mansilla', 'clave123'),
(5, 5, 'julieta.dominguez', 'clave123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admin` (`admin`);

--
-- Indices de la tabla `admin_permisos`
--
ALTER TABLE `admin_permisos`
  ADD PRIMARY KEY (`id_admin_permiso`);

--
-- Indices de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD PRIMARY KEY (`id_antecedente`);

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`id_asistente`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `cargo_empleados`
--
ALTER TABLE `cargo_empleados`
  ADD PRIMARY KEY (`id_cargo_empleados`);

--
-- Indices de la tabla `categorias_material`
--
ALTER TABLE `categorias_material`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `configuracion_recordatorios`
--
ALTER TABLE `configuracion_recordatorios`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `contactos_emergencia`
--
ALTER TABLE `contactos_emergencia`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `contact_configs`
--
ALTER TABLE `contact_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `convenios`
--
ALTER TABLE `convenios`
  ADD PRIMARY KEY (`id_convenio`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id_detalle_compra`);

--
-- Indices de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `detalle_liquidaciones`
--
ALTER TABLE `detalle_liquidaciones`
  ADD PRIMARY KEY (`id_detalle_liquidacion`);

--
-- Indices de la tabla `detalle_presupuestos`
--
ALTER TABLE `detalle_presupuestos`
  ADD PRIMARY KEY (`id_detalle_presupuesto`);

--
-- Indices de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  ADD PRIMARY KEY (`id_diagnostico`);

--
-- Indices de la tabla `documentacion_os`
--
ALTER TABLE `documentacion_os`
  ADD PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `numero_legajo` (`numero_legajo`);

--
-- Indices de la tabla `empleado_asistidos`
--
ALTER TABLE `empleado_asistidos`
  ADD PRIMARY KEY (`id_empleado_asistido`);

--
-- Indices de la tabla `empleado_especialidades`
--
ALTER TABLE `empleado_especialidades`
  ADD PRIMARY KEY (`id_emplado_especialidad`);

--
-- Indices de la tabla `empleado_liquidaciones`
--
ALTER TABLE `empleado_liquidaciones`
  ADD PRIMARY KEY (`id_empleado_liquidacion`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `estudios_odontologicos`
--
ALTER TABLE `estudios_odontologicos`
  ADD PRIMARY KEY (`id_estudio`);

--
-- Indices de la tabla `etapas_tratamiento`
--
ALTER TABLE `etapas_tratamiento`
  ADD PRIMARY KEY (`id_etapa`);

--
-- Indices de la tabla `excepciones_horario`
--
ALTER TABLE `excepciones_horario`
  ADD PRIMARY KEY (`id_excepcion`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `familiares`
--
ALTER TABLE `familiares`
  ADD PRIMARY KEY (`id_familiar`);

--
-- Indices de la tabla `grupos_familiares`
--
ALTER TABLE `grupos_familiares`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `historial_administrativo`
--
ALTER TABLE `historial_administrativo`
  ADD PRIMARY KEY (`id_historial`);

--
-- Indices de la tabla `horario_empleados`
--
ALTER TABLE `horario_empleados`
  ADD PRIMARY KEY (`id_horario`);

--
-- Indices de la tabla `landing_configs`
--
ALTER TABLE `landing_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `liquidaciones_honorarios`
--
ALTER TABLE `liquidaciones_honorarios`
  ADD PRIMARY KEY (`id_liquidacion`);

--
-- Indices de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`id_lista_espera`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id_lote`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id_material`);

--
-- Indices de la tabla `materiales_procedimientos`
--
ALTER TABLE `materiales_procedimientos`
  ADD PRIMARY KEY (`id_material_procedimiento`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modelos_liquidacion`
--
ALTER TABLE `modelos_liquidacion`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Indices de la tabla `nomencladores`
--
ALTER TABLE `nomencladores`
  ADD PRIMARY KEY (`id_nomenclador`);

--
-- Indices de la tabla `obra_personas`
--
ALTER TABLE `obra_personas`
  ADD PRIMARY KEY (`id_obra_persona`);

--
-- Indices de la tabla `obra_sociales`
--
ALTER TABLE `obra_sociales`
  ADD PRIMARY KEY (`id_obra_social`);

--
-- Indices de la tabla `odontogramas`
--
ALTER TABLE `odontogramas`
  ADD PRIMARY KEY (`id_odontograma`);

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
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD UNIQUE KEY `permiso` (`permiso`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `DNI` (`DNI`);

--
-- Indices de la tabla `planes_tratamiento`
--
ALTER TABLE `planes_tratamiento`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`);

--
-- Indices de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  ADD PRIMARY KEY (`id_procedimiento`);

--
-- Indices de la tabla `procedimientos_realizados`
--
ALTER TABLE `procedimientos_realizados`
  ADD PRIMARY KEY (`id_realizado`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_procedimiento` (`id_procedimiento`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `procedimiento_estudios`
--
ALTER TABLE `procedimiento_estudios`
  ADD PRIMARY KEY (`id_procedimiento_estudio`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`id_recordatorio`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`);

--
-- Indices de la tabla `reporte_plantillas`
--
ALTER TABLE `reporte_plantillas`
  ADD PRIMARY KEY (`id_plantilla`);

--
-- Indices de la tabla `sillones`
--
ALTER TABLE `sillones`
  ADD PRIMARY KEY (`id_sillon`);

--
-- Indices de la tabla `somos_configs`
--
ALTER TABLE `somos_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `admin_permisos`
--
ALTER TABLE `admin_permisos`
  MODIFY `id_admin_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  MODIFY `id_antecedente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `id_asistente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cargo_empleados`
--
ALTER TABLE `cargo_empleados`
  MODIFY `id_cargo_empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias_material`
--
ALTER TABLE `categorias_material`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_recordatorios`
--
ALTER TABLE `configuracion_recordatorios`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contactos_emergencia`
--
ALTER TABLE `contactos_emergencia`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contact_configs`
--
ALTER TABLE `contact_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `convenios`
--
ALTER TABLE `convenios`
  MODIFY `id_convenio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_liquidaciones`
--
ALTER TABLE `detalle_liquidaciones`
  MODIFY `id_detalle_liquidacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_presupuestos`
--
ALTER TABLE `detalle_presupuestos`
  MODIFY `id_detalle_presupuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `diagnosticos`
--
ALTER TABLE `diagnosticos`
  MODIFY `id_diagnostico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documentacion_os`
--
ALTER TABLE `documentacion_os`
  MODIFY `id_documento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleado_asistidos`
--
ALTER TABLE `empleado_asistidos`
  MODIFY `id_empleado_asistido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado_especialidades`
--
ALTER TABLE `empleado_especialidades`
  MODIFY `id_emplado_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleado_liquidaciones`
--
ALTER TABLE `empleado_liquidaciones`
  MODIFY `id_empleado_liquidacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudios_odontologicos`
--
ALTER TABLE `estudios_odontologicos`
  MODIFY `id_estudio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etapas_tratamiento`
--
ALTER TABLE `etapas_tratamiento`
  MODIFY `id_etapa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `excepciones_horario`
--
ALTER TABLE `excepciones_horario`
  MODIFY `id_excepcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `familiares`
--
ALTER TABLE `familiares`
  MODIFY `id_familiar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos_familiares`
--
ALTER TABLE `grupos_familiares`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_administrativo`
--
ALTER TABLE `historial_administrativo`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario_empleados`
--
ALTER TABLE `horario_empleados`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `landing_configs`
--
ALTER TABLE `landing_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `liquidaciones_honorarios`
--
ALTER TABLE `liquidaciones_honorarios`
  MODIFY `id_liquidacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `id_lista_espera` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materiales_procedimientos`
--
ALTER TABLE `materiales_procedimientos`
  MODIFY `id_material_procedimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `modelos_liquidacion`
--
ALTER TABLE `modelos_liquidacion`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nomencladores`
--
ALTER TABLE `nomencladores`
  MODIFY `id_nomenclador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obra_personas`
--
ALTER TABLE `obra_personas`
  MODIFY `id_obra_persona` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `obra_sociales`
--
ALTER TABLE `obra_sociales`
  MODIFY `id_obra_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `odontogramas`
--
ALTER TABLE `odontogramas`
  MODIFY `id_odontograma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `planes_tratamiento`
--
ALTER TABLE `planes_tratamiento`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  MODIFY `id_procedimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `procedimientos_realizados`
--
ALTER TABLE `procedimientos_realizados`
  MODIFY `id_realizado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `procedimiento_estudios`
--
ALTER TABLE `procedimiento_estudios`
  MODIFY `id_procedimiento_estudio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_plantillas`
--
ALTER TABLE `reporte_plantillas`
  MODIFY `id_plantilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sillones`
--
ALTER TABLE `sillones`
  MODIFY `id_sillon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `somos_configs`
--
ALTER TABLE `somos_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `procedimientos_realizados`
--
ALTER TABLE `procedimientos_realizados`
  ADD CONSTRAINT `procedimientos_realizados_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`),
  ADD CONSTRAINT `procedimientos_realizados_ibfk_2` FOREIGN KEY (`id_procedimiento`) REFERENCES `procedimientos` (`id_procedimiento`),
  ADD CONSTRAINT `procedimientos_realizados_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
