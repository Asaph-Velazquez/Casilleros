<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $curp = $_POST['CURP'] ?? '';
    $nombre = $_POST['Nombre'] ?? '';
    $apellidoPaterno = $_POST['ApellidoPaterno'] ?? '';
    $apellidoMaterno = $_POST['ApellidoMaterno'] ?? '';
    $telefono = $_POST['Telefono'] ?? '';
    $correo = $_POST['Correo'] ?? '';
    $boleta = $_POST['Boleta'] ?? '';
    $estatura = $_POST['Estatura'] ?? '';
    $usuario = $_POST['Usuario'] ?? '';
    $contrasena = password_hash($_POST['Contraseña'] ?? '', PASSWORD_BCRYPT);

    // Comprobar duplicados
    $duplicadoQuery = "SELECT * FROM estudiantes WHERE correo = ? OR boleta = ? OR curp = ? OR usuario = ?";
    $stmt = mysqli_prepare($conexion, $duplicadoQuery);
    mysqli_stmt_bind_param($stmt, 'ssss', $correo, $boleta, $curp, $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        $datosDuplicados = mysqli_fetch_assoc($resultado);
        $duplicados = [];

        if ($datosDuplicados['correo'] === $correo) {
            $duplicados[] = 'Correo';
        }
        if ($datosDuplicados['boleta'] === $boleta) {
            $duplicados[] = 'Boleta';
        }
        if ($datosDuplicados['curp'] === $curp) {
            $duplicados[] = 'CURP';
        }
        if ($datosDuplicados['usuario'] === $usuario) {
            $duplicados[] = 'Usuario';
        }

        echo json_encode(['success' => false, 'message' => 'Los siguientes campos ya están registrados: ' . implode(', ', $duplicados)]);
        exit;
    }

    // Insertar nuevo registro
    $insertQuery = "INSERT INTO estudiantes (curp, nombre, primer_apellido, segundo_apellido, telefono, correo, boleta, estatura, usuario, contraseña)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'ssssssssss', $curp, $nombre, $apellidoPaterno, $apellidoMaterno, $telefono, $correo, $boleta, $estatura, $usuario, $contrasena);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Registro completado con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar los datos: ' . mysqli_error($conexion)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

mysqli_close($conexion);
?>
