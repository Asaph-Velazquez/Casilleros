<?php
header('Content-Type: application/json');  // Indica que la respuesta será en formato JSON

$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar conexión
if (!$conexion) {
    die('Error al conectar con la base de datos: ' . mysqli_connect_error());
}

// Consulta para obtener los casilleros ocupados (estatus "No Disponible")
$sql = "SELECT numero_casillero FROM casilleros WHERE estatus = 'No Disponible'";
$resultado = mysqli_query($conexion, $sql);

// Crear un array de los casilleros ocupados
$casillerosOcupados = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $casillerosOcupados[] = $row['numero_casillero'];
}

// Convertir el array a formato JSON para pasarlo a JavaScript
echo json_encode($casillerosOcupados);

// Cerrar la conexión
mysqli_close($conexion);
?>
