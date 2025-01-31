-- Tabla estudiantes
CREATE TABLE estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    curp VARCHAR(18) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    estatura DECIMAL(3,2) NOT NULL,
    telefono VARCHAR(10) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    boleta VARCHAR(10) NOT NULL UNIQUE,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    credencial VARCHAR(255), -- Ruta al archivo de credencial
    horario VARCHAR(255) -- Ruta al archivo de horario
);

-- Tabla casilleros
CREATE TABLE casilleros (
    id_Casillero INT AUTO_INCREMENT PRIMARY KEY,
    numero_casillero INT NOT NULL UNIQUE,
    estatus ENUM('Disponible', 'No disponible') NOT NULL DEFAULT 'Disponible',
    altura DECIMAL(3,2) DEFAULT NULL -- Permite que la altura sea NULL
);

-- Tabla solicitudes
CREATE TABLE solicitudes (
    id_solicitud INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT NOT NULL,
    tipo_solicitud ENUM('Registro', 'Renovación') NOT NULL,
    casillero_anterior INT,
    estatus ENUM('Pendiente', 'Asignado', 'Lista de espera') NOT NULL DEFAULT 'Pendiente',
    numero_casillero INT,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    comprobante VARCHAR(255),
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante),
    FOREIGN KEY (numero_casillero) REFERENCES casilleros(numero_casillero)
);

CREATE TABLE administradores (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    num_trabajador VARCHAR(10) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE
);
INSERT INTO administradores (num_trabajador, nombre, usuario, contraseña, correo)
VALUES 
('2020030060', 'Saul Asaph', 'admin1', 'admin123', 'admin@ejemplo.com'),
('2023630227', 'Brandon Castillo', 'admin2', '241019', 'brandon@admon.com');


INSERT INTO estudiantes(curp, nombre, primer_apellido, segundo_apellido, estatura, telefono, correo, boleta, usuario, contraseña, credencial, horario)
VALUES
('AAMJ030312MMCMRCA3', 'Jocelyn Lucia', 'Amador', 'Martínez', '1.65', '5549037335', 'jamador1800@alumno.ipn.mx', '2023630284','luci03', '12345678', 'credencial_67889d52f19144.43948510.pdf', 'credencial_67889d52f19144.43948510.pdf');

INSERT INTO solicitudes(id_estudiante, tipo_solicitud, casillero_anterior, estatus,numero_casillero, fecha_registro)
VALUES
('1', 'Registro', '', 'Asignado', '1', '');
-- Insertar 100 casilleros en la tabla casilleros
INSERT INTO casilleros (numero_casillero, estatus, altura) VALUES
(1, 'Disponible', NULL),
(2, 'Disponible', NULL),
(3, 'Disponible', NULL),
(4, 'Disponible', NULL),
(5, 'Disponible', NULL),
(6, 'Disponible', NULL),
(7, 'Disponible', NULL),
(8, 'Disponible', NULL),
(9, 'Disponible', NULL),
(10, 'Disponible', NULL),
(11, 'Disponible', NULL),
(12, 'Disponible', NULL),
(13, 'Disponible', NULL),
(14, 'Disponible', NULL),
(15, 'Disponible', NULL),
(16, 'Disponible', NULL),
(17, 'Disponible', NULL),
(18, 'Disponible', NULL),
(19, 'Disponible', NULL),
(20, 'Disponible', NULL),
(21, 'Disponible', NULL),
(22, 'Disponible', NULL),
(23, 'Disponible', NULL),
(24, 'Disponible', NULL),
(25, 'Disponible', NULL),
(26, 'Disponible', NULL),
(27, 'Disponible', NULL),
(28, 'Disponible', NULL),
(29, 'Disponible', NULL),
(30, 'Disponible', NULL),
(31, 'Disponible', NULL),
(32, 'Disponible', NULL),
(33, 'Disponible', NULL),
(34, 'Disponible', NULL),
(35, 'Disponible', NULL),
(36, 'Disponible', NULL),
(37, 'Disponible', NULL),
(38, 'Disponible', NULL),
(39, 'Disponible', NULL),
(40, 'Disponible', NULL),
(41, 'Disponible', NULL),
(42, 'Disponible', NULL),
(43, 'Disponible', NULL),
(44, 'Disponible', NULL),
(45, 'Disponible', NULL),
(46, 'Disponible', NULL),
(47, 'Disponible', NULL),
(48, 'Disponible', NULL),
(49, 'Disponible', NULL),
(50, 'Disponible', NULL),
(51, 'Disponible', NULL),
(52, 'Disponible', NULL),
(53, 'Disponible', NULL),
(54, 'Disponible', NULL),
(55, 'Disponible', NULL),
(56, 'Disponible', NULL),
(57, 'Disponible', NULL),
(58, 'Disponible', NULL),
(59, 'Disponible', NULL),
(60, 'Disponible', NULL),
(61, 'Disponible', NULL),
(62, 'Disponible', NULL),
(63, 'Disponible', NULL),
(64, 'Disponible', NULL),
(65, 'Disponible', NULL),
(66, 'Disponible', NULL),
(67, 'Disponible', NULL),
(68, 'Disponible', NULL),
(69, 'Disponible', NULL),
(70, 'Disponible', NULL),
(71, 'Disponible', NULL),
(72, 'Disponible', NULL),
(73, 'Disponible', NULL),
(74, 'Disponible', NULL),
(75, 'Disponible', NULL),
(76, 'Disponible', NULL),
(77, 'Disponible', NULL),
(78, 'Disponible', NULL),
(79, 'Disponible', NULL),
(80, 'Disponible', NULL),
(81, 'Disponible', NULL),
(82, 'Disponible', NULL),
(83, 'Disponible', NULL),
(84, 'Disponible', NULL),
(85, 'Disponible', NULL),
(86, 'Disponible', NULL),
(87, 'Disponible', NULL),
(88, 'Disponible', NULL),
(89, 'Disponible', NULL),
(90, 'Disponible', NULL),
(91, 'Disponible', NULL),
(92, 'Disponible', NULL),
(93, 'Disponible', NULL),
(94, 'Disponible', NULL),
(95, 'Disponible', NULL),
(96, 'Disponible', NULL),
(97, 'Disponible', NULL),
(98, 'Disponible', NULL),
(99, 'Disponible', NULL),
(100, 'Disponible', NULL);
