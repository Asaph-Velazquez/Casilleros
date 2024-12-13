-- Tabla estudiantes
CREATE TABLE estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    curp VARCHAR(18) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    telefono VARCHAR(10) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    boleta VARCHAR(10) NOT NULL UNIQUE,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL
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
