<?php
header('Content-Type: application/json');

// Configuración para conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()
    ]);
    exit;
}

// Verifica si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
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
        $lockerAnterior = $_POST['CasilleroAnterior'] ?? null;

        // Validar datos obligatorios
        if (empty($tipoSolicitud) || empty($curp) || empty($nombre) || empty($correo) || empty($boleta) || empty($usuario) || empty($contrasena)) {
            throw new Exception('Todos los campos obligatorios deben ser completados.');
        }

        // Si es una renovación, verificar que el casillero anterior esté proporcionado
        if ($tipoSolicitud === 'Renovacion' && empty($lockerAnterior)) {
            throw new Exception('El número del casillero anterior es obligatorio para renovaciones.');
        }

        // Comprobar si el correo, boleta o usuario ya existen
        $consultaVerificacion = "SELECT * FROM estudiantes WHERE correo = ? OR boleta = ? OR usuario = ?";
        $stmtVerificacion = mysqli_prepare($conexion, $consultaVerificacion);
        mysqli_stmt_bind_param($stmtVerificacion, 'sss', $correo, $boleta, $usuario);
        
        if (!mysqli_stmt_execute($stmtVerificacion)) {
            throw new Exception('Error al verificar duplicados: ' . mysqli_error($conexion));
        }
        
        $resultadoVerificacion = mysqli_stmt_get_result($stmtVerificacion);

        if (mysqli_num_rows($resultadoVerificacion) > 0) {
            throw new Exception('El correo, boleta o usuario ya están registrados.');
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
                throw new Exception('Error al guardar el archivo de credencial.');
            }
        }

        // Manejo del archivo Horario
        if (isset($_FILES['Horario']) && $_FILES['Horario']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['Horario']['name'], PATHINFO_EXTENSION);
            $nombreUnico = uniqid('horario_', true) . '.' . $extension;
            $rutaHorario = $uploadDir . $nombreUnico;

            if (!move_uploaded_file($_FILES['Horario']['tmp_name'], $rutaHorario)) {
                throw new Exception('Error al guardar el archivo de horario.');
            }
        }

        // Comenzar transacción
        mysqli_begin_transaction($conexion);

        // Cifrar la contraseña
        $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar datos en la tabla estudiantes
        $stmt = mysqli_prepare($conexion, "INSERT INTO estudiantes (curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña, credencial, horario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmt, 'ssssssssssss', 
            $curp, $nombre, $apellidoPaterno, $apellidoMaterno, 
            $telefono, $correo, $boleta, $estatura, 
            $usuario, $hashedPassword, $rutaCredencial, $rutaHorario
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al insertar datos del estudiante: ' . mysqli_stmt_error($stmt));
        }

        $idEstudiante = mysqli_insert_id($conexion);

        // Insertar en la tabla de solicitudes
        $stmtSolicitud = mysqli_prepare($conexion, "INSERT INTO solicitudes (id_estudiante, tipo_solicitud, casillero_anterior) VALUES (?, ?, ?)");
        
        if (!$stmtSolicitud) {
            throw new Exception('Error al preparar la consulta de solicitud: ' . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmtSolicitud, 'isi', $idEstudiante, $tipoSolicitud, $lockerAnterior);
        
        if (!mysqli_stmt_execute($stmtSolicitud)) {
            throw new Exception('Error al insertar la solicitud: ' . mysqli_stmt_error($stmtSolicitud));
        }

        // Confirmar transacción
        mysqli_commit($conexion);

        echo json_encode([
            'success' => true,
            'message' => 'Registro completado exitosamente.'
        ]);

    } catch (Exception $e) {
        // Revertir transacción en caso de error
        if (isset($conexion)) {
            mysqli_rollback($conexion);
        }
        
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    } finally {
        // Cerrar todas las declaraciones y la conexión
        if (isset($stmtVerificacion)) mysqli_stmt_close($stmtVerificacion);
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($stmtSolicitud)) mysqli_stmt_close($stmtSolicitud);
        if (isset($conexion)) mysqli_close($conexion);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>