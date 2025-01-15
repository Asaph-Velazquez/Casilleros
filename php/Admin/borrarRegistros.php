<?php
session_start();
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

if (!$conexion) {
    $_SESSION['error'] = 'Error de conexión a la base de datos: ' . mysqli_connect_error();
    header('Location: /ruta/a/tu/formulario.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombreBorrar = $_POST['NombreBorrar'] ?? '';
        $primerApellidoBorrar = $_POST['primerApellidoBorrar'] ?? '';
        $segundoApellidoBorrar = $_POST['segundoApellidoBorrar'] ?? '';
        $usuarioBorrar = $_POST['validarUsuario'] ?? '';
        $boletaBorrar = $_POST['boletaBorrar'] ?? '';

        // Verificar si el estudiante existe
        $verificar = "SELECT id_estudiante FROM estudiantes 
                      WHERE nombre = ? AND primer_apellido = ? AND segundo_apellido = ? 
                      AND usuario = ? AND boleta = ?";
        $stmt = mysqli_prepare($conexion, $verificar);
        mysqli_stmt_bind_param($stmt, 'sssss', $nombreBorrar, $primerApellidoBorrar, $segundoApellidoBorrar, $usuarioBorrar, $boletaBorrar);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al verificar los datos: ' . mysqli_error($conexion));
        }

        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) === 0) {
            throw new Exception('El estudiante no existe o los datos son incorrectos.');
        }

        $fila = mysqli_fetch_assoc($resultado);
        $idEstudiante = $fila['id_estudiante'];

        // Eliminar los registros relacionados en la tabla solicitudes
        $eliminarSolicitudes = "DELETE FROM solicitudes WHERE id_estudiante = ?";
        $stmtSolicitudes = mysqli_prepare($conexion, $eliminarSolicitudes);
        mysqli_stmt_bind_param($stmtSolicitudes, 'i', $idEstudiante);

        if (!mysqli_stmt_execute($stmtSolicitudes)) {
            throw new Exception('Error al eliminar los registros de solicitudes: ' . mysqli_error($conexion));
        }

        // Eliminar el registro de la tabla estudiantes
        $eliminarEstudiante = "DELETE FROM estudiantes WHERE id_estudiante = ?";
        $stmtEstudiantes = mysqli_prepare($conexion, $eliminarEstudiante);
        mysqli_stmt_bind_param($stmtEstudiantes, 'i', $idEstudiante);

        if (!mysqli_stmt_execute($stmtEstudiantes)) {
            throw new Exception('Error al eliminar el estudiante: ' . mysqli_error($conexion));
        }

        $_SESSION['success'] = 'El estudiante y sus registros relacionados han sido eliminados correctamente.';
        header('location: ../../html/admon.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('location: ../../html/admon.php');
        exit;
    } finally {
        mysqli_close($conexion);
    }
} else {
    $_SESSION['error'] = 'Método HTTP no permitido.';
    header('location: ../../html/admon.php');
    exit;
}
?>
