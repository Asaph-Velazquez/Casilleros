<?php
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar conexión
if (!$conexion) {
    die('Error al conectar con la base de datos: ' . mysqli_connect_error());
}

// Recuperar valores del formulario
$Boleta = $_POST['boletaBuscar'] ?? '';

// Inicializar variables para mostrar datos en la tabla
$Nombre_Estudiante = $Primer_Apellido = $Segundo_Apellido = $Estatura = $Telefono = $Correo = $Usuario = $Curp = $tipoSolicitud = $fechaSolicitud = '';
$registroEncontrado = false;

// Consulta para verificar si la boleta existe
$consulta = "SELECT * FROM estudiantes WHERE boleta = '$Boleta'";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si la consulta tuvo éxito
if (!$resultado) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Verificar si la boleta está registrada
if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del estudiante
    $fila = mysqli_fetch_assoc($resultado);

    // Obtener los datos relacionados de la solicitud
    $idEstudiante = $fila['id_estudiante'];
    $consulta_Solicitud = "SELECT * FROM solicitudes WHERE id_estudiante = '$idEstudiante'";
    $resultado_Solicitud = mysqli_query($conexion, $consulta_Solicitud);

    // Verificar si la consulta de solicitudes tuvo éxito
    if (!$resultado_Solicitud) {
        die('Error en la consulta de solicitudes: ' . mysqli_error($conexion));
    }

    // Si hay solicitudes registradas, obtener los datos
    if (mysqli_num_rows($resultado_Solicitud) > 0) {
        $fila_Solicitud = mysqli_fetch_assoc($resultado_Solicitud);

        // Asignar los datos a variables
        $Nombre_Estudiante = $fila['nombre'];
        $Primer_Apellido = $fila['primer_apellido'];
        $Segundo_Apellido = $fila['segundo_apellido'];
        $Estatura = $fila['estatura'];
        $Telefono = $fila['telefono'];
        $Correo = $fila['correo'];
        $Usuario = $fila['usuario'];
        $Curp = $fila['curp'];
        $tipoSolicitud = $fila_Solicitud['tipo_solicitud'];
        $fechaSolicitud = $fila_Solicitud['fecha_registro'] ?? 'No disponible';
        $numeroCasillero = $fila_Solicitud['numero_casillero'] ?? 'No disponible';
        $registroEncontrado = true;
    }
}

// Cerrar conexión
mysqli_close($conexion);
?>