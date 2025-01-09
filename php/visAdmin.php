<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar si la conexión fue exitosa
if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()]);
    exit;
}

// Establecer el conjunto de caracteres a UTF-8
mysqli_set_charset($conexion, 'utf8');

// Validar los datos recibidos
$usuario = trim($_POST['UsuarioLogin'] ?? '');

if (empty($usuario)) {
    echo json_encode(['success' => false, 'message' => 'El campo de usuario está vacío.']);
    exit;
}

// Usar sentencias preparadas para evitar inyecciones SQL
$stmt = $conexion->prepare("SELECT * FROM administradores WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si se encontró un usuario
if ($resultado->num_rows > 0) {
    $administrador = $resultado->fetch_assoc();

    // Almacenar datos del administrador en la sesión
    $_SESSION['usuario_id'] = $administrador['id'];
    $_SESSION['usuario_nombre'] = $administrador['nombre'];

    echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado.']);
}

// Cerrar la conexión
$stmt->close();
mysqli_close($conexion);
?>
