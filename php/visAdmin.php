<?php
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]);
    exit;
}

$usuario = $_POST['UsuarioLogin'] ?? '';
$consulta = "SELECT * FROM administradores WHERE usuario = '$usuario'";
echo '<h1>¡Hola, este es un título dinámico!</h1>'; 


?>