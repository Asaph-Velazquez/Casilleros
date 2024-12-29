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
    numero_casillero INT AUTO_INCREMENT PRIMARY KEY,
    estatus ENUM('Disponible', 'No disponible') NOT NULL DEFAULT 'Disponible',
    altura DECIMAL(3,2) NOT NULL
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
VALUES ('2020030060', 'Saul Asaph', 'admin1', 'admin123', 'admin@ejemplo.com');
VALUES ('2023630227','Brandon Castillo', 'admin2', '241019', 'brandon@admon.com');


