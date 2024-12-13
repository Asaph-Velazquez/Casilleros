<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

//recuperacion de datos
$tipoSolicitud = $_POST['tipoSolicitud'] ?? '';
$curp = $_POST['CURP'] ?? '';
$nombre = $_POST['Nombre'] ?? '';
$apellidoPaterno = $_POST['ApellidoPaterno'] ?? '';
$apellidoMaterno = $_POST['ApellidoMaterno'] ?? '';
$telefono = $_POST['Telefono'] ?? '';
$correo = $_POST['Correo'] ?? '';
$boleta = $_POST['Boleta'] ?? '';
$estatura = $_POST['Estatura'] ?? '';
$usuario = $_POST['Usuario'] ?? '';
$contrasena = $_POST['Contraseña'] ?? '';

//insertar datos
$insertar = "INSERT INTO  estudiantes(curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña) 
VALUES ('$curp', '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$telefono', '$correo', '$boleta', '$estatura', '$usuario', '$contrasena')";
$resultado = mysqli_query($conexion, $insertar);


/*
$insertar = "INSERT INTO estudiantes (curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña)
VALUES ('CURP123456', 'Juan', 'Pérez', 'García', '5555555555', 'juan@correo.com', '2023001234', '1.75', 'juanp', 'password123')";
$resultado = mysqli_query($conexion, $insertar);
*/
?>
