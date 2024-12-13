<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

//recuperacion de datos
$curp = mysqli_real_escape_string($conexion, $_POST['CURP'] ?? '');
$nombre = mysqli_real_escape_string($conexion, $_POST['Nombre'] ?? '');
$apellidoPaterno = mysqli_real_escape_string($conexion, $_POST['ApellidoPaterno'] ?? '');
$apellidoMaterno = mysqli_real_escape_string($conexion, $_POST['ApellidoMaterno'] ?? '');
$telefono = mysqli_real_escape_string($conexion, $_POST['Telefono'] ?? '');
$correo = mysqli_real_escape_string($conexion, $_POST['Correo'] ?? '');
$boleta = mysqli_real_escape_string($conexion, $_POST['Boleta'] ?? '');
$estatura = mysqli_real_escape_string($conexion, $_POST['Estatura'] ?? '');
$usuario = mysqli_real_escape_string($conexion, $_POST['Usuario'] ?? '');
$contrasena = mysqli_real_escape_string($conexion, $_POST['Contraseña'] ?? '');


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
