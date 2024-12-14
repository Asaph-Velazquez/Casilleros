<?php
// Configuración para conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]);
    exit;
}

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperación de datos enviados desde el formulario
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
    $lockerAnterior = $_POST['CasilleroAnterior'] ?? null; // Locker anterior para renovaciones

    // Validar datos obligatorios
    if (empty($tipoSolicitud) || empty($curp) || empty($nombre) || empty($correo) || empty($boleta) || empty($usuario) || empty($contrasena)) {
        echo json_encode(['success' => false, 'message' => 'Error: Todos los campos obligatorios deben ser completados.']);
        exit;
    }

    // Si es una renovación, verificar que el casillero anterior esté proporcionado
    if ($tipoSolicitud === 'Renovacion' && empty($lockerAnterior)) {
        echo json_encode(['success' => false, 'message' => 'Error: El número del casillero anterior es obligatorio para renovaciones.']);
        exit;
    }

    // Comprobar si el correo, boleta o usuario ya existen
    $consultaVerificacion = "SELECT * FROM estudiantes WHERE correo = ? OR boleta = ? OR usuario = ?";
    $stmtVerificacion = mysqli_prepare($conexion, $consultaVerificacion);
    mysqli_stmt_bind_param($stmtVerificacion, 'sss', $correo, $boleta, $usuario);
    mysqli_stmt_execute($stmtVerificacion);
    $resultadoVerificacion = mysqli_stmt_get_result($stmtVerificacion);

    if (mysqli_num_rows($resultadoVerificacion) > 0) {
        echo json_encode(['success' => false, 'message' => 'Error: El correo, boleta o usuario ya están registrados.']);
        exit;
    }

    // Manejo de archivos
    $rutaCredencial = null;
    $rutaHorario = null;
    $uploadDir = 'uploads/';

    // Crear directorio si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Manejo del archivo Credencial
    if (isset($_FILES['Credencial']) && $_FILES['Credencial']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['Credencial']['name'], PATHINFO_EXTENSION);
        $nombreUnico = uniqid('credencial_', true) . '.' . $extension;
        $rutaCredencial = $uploadDir . $nombreUnico;

        if (!move_uploaded_file($_FILES['Credencial']['tmp_name'], $rutaCredencial)) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo de credencial.']);
            exit;
        }
    }

    // Manejo del archivo Horario
    if (isset($_FILES['Horario']) && $_FILES['Horario']['error'] === UPLOAD_ERR_OK) {
        $extension = pathinfo($_FILES['Horario']['name'], PATHINFO_EXTENSION);
        $nombreUnico = uniqid('horario_', true) . '.' . $extension;
        $rutaHorario = $uploadDir . $nombreUnico;

        if (!move_uploaded_file($_FILES['Horario']['tmp_name'], $rutaHorario)) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el archivo de horario.']);
            exit;
        }
    }

    // Cifrar la contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar datos en la tabla estudiantes
    $stmt = mysqli_prepare($conexion, "INSERT INTO estudiantes (curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña, credencial, horario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $curp, $nombre, $apellidoPaterno, $apellidoMaterno, $telefono, $correo, $boleta, $estatura, $usuario, $hashedPassword, $rutaCredencial, $rutaHorario);

    if (mysqli_stmt_execute($stmt)) {
        $idEstudiante = mysqli_insert_id($conexion);

        // Insertar en la tabla de solicitudes
        $stmtSolicitud = mysqli_prepare($conexion, "INSERT INTO solicitudes (id_estudiante, tipo_solicitud, casillero_anterior) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmtSolicitud, 'isi', $idEstudiante, $tipoSolicitud, $lockerAnterior);
        mysqli_stmt_execute($stmtSolicitud);
        mysqli_stmt_close($stmtSolicitud);

        echo json_encode(['success' => true, 'message' => 'Registro exitoso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar los datos: ' . mysqli_error($conexion)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

mysqli_close($conexion);
?>
