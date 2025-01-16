<?php

session_start();
// Configuración para conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Recuperar los datos de la sesión
$usuario = $_SESSION['nombreUsuario'] ?? null;


if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]);
    exit;
}

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    // Manejo de archivos
    $rutaCredencial = null;
    $rutaHorario = null;
    $rutaComprobante = null;
    $uploadDir = 'uploads/';

    // Crear directorio si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Manejo del archivo comprobante
    if (isset($_FILES['comprobanteFile']) && $_FILES['comprobanteFile']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['comprobanteFile']['name'], PATHINFO_EXTENSION);
        $nombreUnico = uniqid('comprobante_', true) . '.' . $extension;
        $rutaComprobante = $uploadDir . $nombreUnico;

        if (!move_uploaded_file($_FILES['comprobanteFile']['tmp_name'], $rutaComprobante)) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo de comprobante.']);
            exit;
        }
    }

    //Actualizar tabla de solicitudes con ruta de comprobante de pago

    //Consultar id de la solicitud del usuario
    $consultaSolicitud = "SELECT S.* FROM solicitudes as S INNER JOIN estudiantes as E ON S.id_estudiante = E.id_estudiante WHERE E.usuario = '$usuario'";
    $resultadoSolicitud = mysqli_query($conexion, $consultaSolicitud);
    if (!$resultadoSolicitud) { // Verificar si la consulta tuvo éxito
        die('Error en la consulta resultado de Solicitud: ' . mysqli_error($conexion));
    }
    $filaSolicitud = mysqli_fetch_assoc($resultadoSolicitud);
    $idSolicitud = $filaSolicitud['id_solicitud'];

    //Actualizar comprobante de pago
    $consultaActComprobante = "UPDATE solicitudes SET comprobante = '$rutaComprobante', estatus = 'Asignado' WHERE id_solicitud = '$idSolicitud'";
    $resultadoUpdate = mysqli_query($conexion, $consultaActComprobante);
    if (!$resultadoUpdate) { // Verificar si la consulta tuvo éxito
        die('Error en la consulta resultado de Solicitud: ' . mysqli_error($conexion));
    }


} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

mysqli_close($conexion);
?>
