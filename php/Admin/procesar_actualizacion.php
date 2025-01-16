<?php
session_start();
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar conexión
if (!$conexion) {
    $_SESSION['message'] = 'Error de conexión a la base de datos: ' . mysqli_connect_error();
    header('Location: actualizacion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Recuperar datos del formulario
        $Boleta = trim($_POST['boletaActualizar'] ?? '');
        $Nombre_Estudiante = trim($_POST['NombreActualizar'] ?? '');
        $Primer_Apellido = trim($_POST['PrimerApellidoActualizar'] ?? '');
        $Segundo_Apellido = trim($_POST['SegundoApellidoActualizar'] ?? '');
        $Estatura = trim($_POST['EstaturaActualizar'] ?? '');
        $Telefono = trim($_POST['TelefonoActualizar'] ?? '');
        $Correo = trim($_POST['correoActualizar'] ?? '');
        $Usuario = trim($_POST['usuarioActualizar'] ?? '');
        $Curp = trim($_POST['curpActualizar'] ?? '');
        $AsignarCasillero = trim($_POST['casilleroActualizar'] ?? '');

        // Verificar si hay registros duplicados (excepto el del usuario actual)
        $consultaVerificacion = "SELECT * FROM estudiantes WHERE (usuario = ? OR telefono = ? OR correo = ?) AND boleta != ?";
        $estadoVerificacion = mysqli_prepare($conexion, $consultaVerificacion);
        mysqli_stmt_bind_param($estadoVerificacion, 'ssss', $Usuario, $Telefono, $Correo, $Boleta);

        if (!mysqli_stmt_execute($estadoVerificacion)) {
            throw new Exception('Error al verificar duplicados: ' . mysqli_error($conexion));
        }

        $resultadoVerificacion = mysqli_stmt_get_result($estadoVerificacion);

        if (mysqli_num_rows($resultadoVerificacion) > 0) {
            $duplicados = [];
            while ($row = mysqli_fetch_assoc($resultadoVerificacion)) {
                $duplicados[] = "Usuario: " . $row['usuario'] . ", Teléfono: " . $row['telefono'] . ", Correo: " . $row['correo'];
            }
            throw new Exception('El usuario, teléfono o correo ya están registrados. Duplicados encontrados: ' . implode(' | ', $duplicados));
        }

        // Iniciar transacción
        mysqli_begin_transaction($conexion);

        // 1. Actualizar datos del estudiante
        $consulta = "UPDATE estudiantes 
                    SET nombre = ?, 
                        primer_apellido = ?, 
                        segundo_apellido = ?, 
                        estatura = ?, 
                        telefono = ?, 
                        correo = ?, 
                        usuario = ?, 
                        curp = ? 
                    WHERE boleta = ?";
        
        $stmt = mysqli_prepare($conexion, $consulta);
        mysqli_stmt_bind_param($stmt, 'sssssssss', 
            $Nombre_Estudiante, 
            $Primer_Apellido, 
            $Segundo_Apellido, 
            $Estatura, 
            $Telefono, 
            $Correo, 
            $Usuario, 
            $Curp, 
            $Boleta
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al actualizar datos del estudiante: ' . mysqli_error($conexion));
        }

        // 2. Actualizar el casillero si se proporcionó uno nuevo
        if (!empty($AsignarCasillero)) {
            // Obtener el ID del estudiante actual
            $consultaId = "SELECT id_estudiante FROM estudiantes WHERE boleta = ?";
            $stmtId = mysqli_prepare($conexion, $consultaId);
            mysqli_stmt_bind_param($stmtId, 's', $Boleta);
            mysqli_stmt_execute($stmtId);
            $resultadoId = mysqli_stmt_get_result($stmtId);
            $estudiante = mysqli_fetch_assoc($resultadoId);

            if ($estudiante) {
                // Verificar si el casillero está ocupado por otro estudiante
                $consultaOcupado = "SELECT s.id_estudiante, e.boleta 
                                  FROM solicitudes s 
                                  JOIN estudiantes e ON s.id_estudiante = e.id_estudiante 
                                  WHERE s.numero_casillero = ? 
                                  AND s.estatus IN ('Pendiente', 'Asignado') 
                                  AND s.id_estudiante != ?";
                $stmtOcupado = mysqli_prepare($conexion, $consultaOcupado);
                mysqli_stmt_bind_param($stmtOcupado, 'ii', $AsignarCasillero, $estudiante['id_estudiante']);
                mysqli_stmt_execute($stmtOcupado);
                $resultadoOcupado = mysqli_stmt_get_result($stmtOcupado);

                if (mysqli_num_rows($resultadoOcupado) > 0) {
                    $ocupante = mysqli_fetch_assoc($resultadoOcupado);
                    throw new Exception("El casillero {$AsignarCasillero} ya está ocupado por otro estudiante.");
                }

                // Obtener el casillero actual del estudiante
                $consultaSolicitudActual = "SELECT id_solicitud, numero_casillero 
                                          FROM solicitudes 
                                          WHERE id_estudiante = ? 
                                          AND estatus IN ('Pendiente', 'Asignado')
                                          ORDER BY fecha_registro DESC 
                                          LIMIT 1";
                $stmtSolicitudActual = mysqli_prepare($conexion, $consultaSolicitudActual);
                mysqli_stmt_bind_param($stmtSolicitudActual, 'i', $estudiante['id_estudiante']);
                mysqli_stmt_execute($stmtSolicitudActual);
                $resultadoSolicitudActual = mysqli_stmt_get_result($stmtSolicitudActual);
                $solicitudActual = mysqli_fetch_assoc($resultadoSolicitudActual);

                if ($solicitudActual && $solicitudActual['numero_casillero'] != $AsignarCasillero) {
                    // Marcar el casillero anterior como disponible
                    $updateCasilleroAnterior = "UPDATE casilleros 
                                              SET estatus = 'Disponible' 
                                              WHERE numero_casillero = ?";
                    $stmtCasilleroAnterior = mysqli_prepare($conexion, $updateCasilleroAnterior);
                    mysqli_stmt_bind_param($stmtCasilleroAnterior, 'i', $solicitudActual['numero_casillero']);
                    mysqli_stmt_execute($stmtCasilleroAnterior);

                    // Actualizar el número de casillero y el estado en la solicitud existente
                    $consultaUpdateSolicitud = "UPDATE solicitudes 
                                              SET numero_casillero = ?,
                                                  estatus = 'Asignado'
                                              WHERE id_solicitud = ?";
                    $stmtUpdateSolicitud = mysqli_prepare($conexion, $consultaUpdateSolicitud);
                    mysqli_stmt_bind_param($stmtUpdateSolicitud, 'ii', $AsignarCasillero, $solicitudActual['id_solicitud']);
                    
                    if (!mysqli_stmt_execute($stmtUpdateSolicitud)) {
                        throw new Exception('Error al actualizar la asignación del casillero');
                    }

                    // Actualizar el estado del nuevo casillero
                    $consultaUpdateCasillero = "UPDATE casilleros 
                                              SET estatus = 'No disponible' 
                                              WHERE numero_casillero = ?";
                    $stmtUpdateCasillero = mysqli_prepare($conexion, $consultaUpdateCasillero);
                    mysqli_stmt_bind_param($stmtUpdateCasillero, 'i', $AsignarCasillero);
                    
                    if (!mysqli_stmt_execute($stmtUpdateCasillero)) {
                        throw new Exception('Error al actualizar el estado del casillero');
                    }
                }
            }
        }

        // Confirmar la transacción
        mysqli_commit($conexion);
        
        $_SESSION['message'] = 'Registro actualizado correctamente.';
        header("Location: actualizar.php?boleta=$Boleta");
        exit;

    } catch (Exception $e) {
        mysqli_rollback($conexion);
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
        header("Location: actualizar.php?boleta=$Boleta");
        exit;
    }
} else {
    header('Location: actualizar.php');
    exit;
}
?>