<?php
session_start();
// Verificar que se reciba la boleta
if (!isset($_GET['boleta']) || empty($_GET['boleta'])) {
    die("No se proporcionó una boleta.");
}
$boleta = trim($_GET['boleta']); // Limpiamos posibles espacios en blanco

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "casilleros";

$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del estudiante a partir de la boleta
$sqlGetId = "SELECT id_estudiante FROM estudiantes WHERE boleta = ?";
$stmtGetId = $conn->prepare($sqlGetId);
if (!$stmtGetId) {
    die("Error en la preparación de la consulta SQL: " . $conn->error);
}
$stmtGetId->bind_param("s", $boleta);
$stmtGetId->execute();
$result = $stmtGetId->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idEstudiante = $row['id_estudiante'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar la solicitud asociada al estudiante
        $sqlSolicitud = "DELETE FROM solicitudes WHERE id_estudiante = ?";
        $stmtSolicitud = $conn->prepare($sqlSolicitud);
        if (!$stmtSolicitud) {
            throw new Exception("Error en la preparación de la consulta SQL: " . $conn->error);
        }
        $stmtSolicitud->bind_param("i", $idEstudiante);
        $stmtSolicitud->execute();

        // Eliminar el registro del estudiante
        $sqlRegistro = "DELETE FROM estudiantes WHERE boleta = ?";
        $stmtRegistro = $conn->prepare($sqlRegistro);
        if (!$stmtRegistro) {
            throw new Exception("Error en la preparación de la consulta SQL: " . $conn->error);
        }
        $stmtRegistro->bind_param("s", $boleta);
        $stmtRegistro->execute();

        // Confirmar la transacción
        $conn->commit();
        $_SESSION['message'] = "El registro y la solicitud del estudiante con la boleta $boleta se han eliminado correctamente.";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        $_SESSION['message'] = "Error al eliminar los registros: " . $e->getMessage();
    }

    // Cerrar las declaraciones
    if (isset($stmtSolicitud)) {
        $stmtSolicitud->close();
    }
    if (isset($stmtRegistro)) {
        $stmtRegistro->close();
    }
} else {
    $_SESSION['message'] = "No se encontró un estudiante con la boleta $boleta.";
}

$stmtGetId->close();
$conn->close();

// Redirigir a la página de administración con el mensaje de la sesión
header("Location: ../../html/admon.php");
exit();
?>
