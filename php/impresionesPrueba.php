<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');
$select = "SELECT * FROM estudiantes";
$resultado = mysqli_query($conexion, $select);
$valida = mysqli_num_rows($resultado);
echo "En tu base de datos casilleros tienes $valida registros";

?>