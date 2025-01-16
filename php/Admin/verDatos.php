<?php
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar conexión
if (!$conexion) {
    die('Error al conectar con la base de datos: ' . mysqli_connect_error());
}

// Recuperar valores del formulario
$Boleta = $_POST['boletaBuscar'] ?? '';

// Inicializar variables para mostrar datos en la tabla
$Nombre_Estudiante = $Primer_Apellido = $Segundo_Apellido = $Estatura = $Telefono = $Correo = $Usuario = $Curp = $tipoSolicitud = $fechaSolicitud = $numeroCasillero = '';
$registroEncontrado = false;

// Consulta para verificar si la boleta existe
$consulta = "SELECT e.*, s.tipo_solicitud, s.fecha_registro, c.numero_casillero 
             FROM estudiantes e 
             LEFT JOIN solicitudes s ON e.id_estudiante = s.id_estudiante 
             LEFT JOIN casilleros c ON s.numero_casillero = c.numero_casillero
             WHERE e.boleta = '$Boleta'";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si la consulta tuvo éxito
if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Verificar si la boleta está registrada
if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del estudiante y la solicitud
    $fila = mysqli_fetch_assoc($resultado);

    // Asignar los datos a variables
    $Nombre_Estudiante = $fila['nombre'];
    $Primer_Apellido = $fila['primer_apellido'];
    $Segundo_Apellido = $fila['segundo_apellido'];
    $Estatura = $fila['estatura'];
    $Telefono = $fila['telefono'];
    $Correo = $fila['correo'];
    $Usuario = $fila['usuario'];
    $Curp = $fila['curp'];
    $tipoSolicitud = $fila['tipo_solicitud'];
    $fechaSolicitud = $fila['fecha_registro'] ?? 'No disponible';
    $numeroCasillero = $fila['numero_casillero'] ?? 'No disponible';
    $registroEncontrado = true;
}

// Consulta para obtener todos los registros
$consultaTodos = "SELECT e.*, s.tipo_solicitud, s.fecha_registro, c.numero_casillero 
                  FROM estudiantes e 
                  LEFT JOIN solicitudes s ON e.id_estudiante = s.id_estudiante 
                  LEFT JOIN casilleros c ON s.numero_casillero = c.numero_casillero";
$resultadoTodos = mysqli_query($conexion, $consultaTodos);

// Verificar si la consulta tuvo éxito
if (!$resultadoTodos) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Cerrar conexión
mysqli_close($conexion);
?>