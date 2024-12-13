<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    die(json_encode(['success' => false, 'message' => "Error de conexión: " . mysqli_connect_error()]));
}

// Configurar el manejo de errores
mysqli_set_charset($conexion, 'utf8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar datos del formulario
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

    // Validaciones adicionales
    $errores = [];

    // Validar campos obligatorios
    if (empty($tipoSolicitud)) {
        $errores[] = 'Tipo de solicitud es obligatorio';
    }
    if (empty($curp)) {
        $errores[] = 'CURP es obligatorio';
    }
    if (empty($nombre)) {
        $errores[] = 'Nombre es obligatorio';
    }
    if (empty($correo)) {
        $errores[] = 'Correo es obligatorio';
    }
    if (empty($boleta)) {
        $errores[] = 'Boleta es obligatoria';
    }

    // Validar CURP (formato básico)
    if (!preg_match('/^[A-Z]{4}[0-9]{6}[H,M][A-Z]{5}[A-Z,0-9]{2}$/', $curp)) {
        $errores[] = 'CURP no tiene un formato válido';
    }

    // Validar correo institucional
    if (!preg_match('/@alumno\.ipn\.mx$/', $correo)) {
        $errores[] = 'El correo debe ser institucional (@alumno.ipn.mx)';
    }

    // Validar boleta (10 dígitos)
    if (!preg_match('/^[0-9]{10}$/', $boleta)) {
        $errores[] = 'Boleta debe tener 10 dígitos';
    }

    // Validar contraseña (longitud mínima)
    if (strlen($contrasena) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres';
    }

    // Si hay errores, devolver respuesta de error
    if (!empty($errores)) {
        echo json_encode(['success' => false, 'message' => implode(', ', $errores)]);
        exit;
    }

    // Sanitizar datos
    $tipoSolicitud = mysqli_real_escape_string($conexion, $tipoSolicitud);
    $curp = mysqli_real_escape_string($conexion, $curp);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellidoPaterno = mysqli_real_escape_string($conexion, $apellidoPaterno);
    $apellidoMaterno = mysqli_real_escape_string($conexion, $apellidoMaterno);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    $correo = mysqli_real_escape_string($conexion, $correo);
    $boleta = mysqli_real_escape_string($conexion, $boleta);
    $estatura = mysqli_real_escape_string($conexion, $estatura);
    $usuario = mysqli_real_escape_string($conexion, $usuario);

    // Manejo de archivos
    $rutaCredencial = null;
    $rutaHorario = null;
    $uploadDir = 'uploads/' . $curp . '/';

    // Crear directorio de usuario si no existe
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Procesar credencial
    if (isset($_FILES['Credencial']) && $_FILES['Credencial']['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES['Credencial']['tmp_name']);
        if ($fileType === 'application/pdf') {
            $rutaCredencial = $uploadDir . uniqid() . '_credencial_' . basename($_FILES['Credencial']['name']);
            if (!move_uploaded_file($_FILES['Credencial']['tmp_name'], $rutaCredencial)) {
                echo json_encode(['success' => false, 'message' => 'Error al subir la credencial']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Credencial no es un archivo PDF válido']);
            exit;
        }
    }

    // Procesar horario
    if (isset($_FILES['Horario']) && $_FILES['Horario']['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($_FILES['Horario']['tmp_name']);
        if ($fileType === 'application/pdf') {
            $rutaHorario = $uploadDir . uniqid() . '_horario_' . basename($_FILES['Horario']['name']);
            if (!move_uploaded_file($_FILES['Horario']['tmp_name'], $rutaHorario)) {
                echo json_encode(['success' => false, 'message' => 'Error al subir el horario']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Horario no es un archivo PDF válido']);
            exit;
        }
    }

    // Verificar correo único
    $checkEmail = mysqli_prepare($conexion, "SELECT correo FROM estudiantes WHERE correo = ?");
    mysqli_stmt_bind_param($checkEmail, 's', $correo);
    mysqli_stmt_execute($checkEmail);
    mysqli_stmt_store_result($checkEmail);

    if (mysqli_stmt_num_rows($checkEmail) > 0) {
        echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
        exit;
    }
    mysqli_stmt_close($checkEmail);

    // Verificar usuario único
    $checkUser = mysqli_prepare($conexion, "SELECT usuario FROM estudiantes WHERE usuario = ?");
    mysqli_stmt_bind_param($checkUser, 's', $usuario);
    mysqli_stmt_execute($checkUser);
    mysqli_stmt_store_result($checkUser);

    if (mysqli_stmt_num_rows($checkUser) > 0) {
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya existe']);
        exit;
    }
    mysqli_stmt_close($checkUser);

    // Cifrar contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

    // Preparar consulta de inserción
    $stmt = mysqli_prepare($conexion, "INSERT INTO estudiantes (
        tipo_solicitud, curp, nombre, primer_apellido, segundo_apellido, 
        telefono, correo, boleta, estatura, credencial, horario, 
        usuario, contraseña
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, 'sssssssssssss', 
        $tipoSolicitud, $curp, $nombre, $apellidoPaterno, $apellidoMaterno, 
        $telefono, $correo, $boleta, $estatura, $rutaCredencial, $rutaHorario, 
        $usuario, $hashedPassword
    );

    // Ejecutar inserción
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'success' => true, 
            'message' => 'Solicitud de casillero registrada correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error al registrar la solicitud: ' . mysqli_error($conexion)
        ]);
    }

    // Cerrar statement
    mysqli_stmt_close($stmt);
} else {
    // Método no permitido
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Cerrar conexión
mysqli_close($conexion);
?>