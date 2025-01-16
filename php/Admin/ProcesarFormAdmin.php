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
        $lockerAnterior = $_POST['CasilleroAnterior'] ?? '';
        $numeroCasillero = $_POST['NumeroCasillero'] ?? null;

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

        // Comenzar transacción
        mysqli_begin_transaction($conexion);

        // Cifrar la contraseña
        $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar datos en la tabla estudiantes
        $stmt = mysqli_prepare($conexion, "INSERT INTO estudiantes (curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception('Error al preparar la consulta: ' . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param($stmt, 'ssssssssss', 
            $curp, $nombre, $apellidoPaterno, $apellidoMaterno, 
            $telefono, $correo, $boleta, $estatura, 
            $usuario, $hashedPassword
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al insertar datos del estudiante: ' . mysqli_stmt_error($stmt));
        }

        $idEstudiante = mysqli_insert_id($conexion);

        // Verificar el tipo de solicitud
        if ($tipoSolicitud === 'Registro') {
            // Actualizar el número de casillero directamente
            $stmtCasillero = mysqli_prepare($conexion, "UPDATE solicitudes SET numero_casillero = ? WHERE id_estudiante = ?");
            if (!$stmtCasillero) {
                throw new Exception('Error al preparar la consulta de actualización de casillero: ' . mysqli_error($conexion));
            }
            mysqli_stmt_bind_param($stmtCasillero, 'ii', $numeroCasillero, $idEstudiante);
            if (!mysqli_stmt_execute($stmtCasillero)) {
                throw new Exception('Error al actualizar el número de casillero: ' . mysqli_stmt_error($stmtCasillero));
            }
        } else {
            // Insertar en la tabla de solicitudes
            $stmtSolicitud = mysqli_prepare($conexion, "INSERT INTO solicitudes (id_estudiante, tipo_solicitud, casillero_anterior) VALUES (?, ?, ?)");
            
            if (!$stmtSolicitud) {
                throw new Exception('Error al preparar la consulta de solicitud: ' . mysqli_error($conexion));
            }

            mysqli_stmt_bind_param($stmtSolicitud, 'isi', $idEstudiante, $tipoSolicitud, $lockerAnterior);
            
            if (!mysqli_stmt_execute($stmtSolicitud)) {
                throw new Exception('Error al insertar la solicitud: ' . mysqli_stmt_error($stmtSolicitud));
            }
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
