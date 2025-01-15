<?php
session_start();
header('Content-Type: application/json');
$conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

// Verificar conexión
if (!$conexion) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()
    ]);
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

        // Asignar los valores a la consulta
        mysqli_stmt_bind_param($estadoVerificacion, 'ssss', $Usuario, $Telefono, $Correo, $Boleta);

        // Ejecutar la consulta
        if (!mysqli_stmt_execute($estadoVerificacion)) {
            throw new Exception('Error al verificar duplicados: ' . mysqli_error($conexion));
        }

        $resultadoVerificacion = mysqli_stmt_get_result($estadoVerificacion);

        // Verificar si se encontraron duplicados
        if (mysqli_num_rows($resultadoVerificacion) > 0) {
            // Mostrar los registros duplicados encontrados
            $duplicados = [];
            while ($row = mysqli_fetch_assoc($resultadoVerificacion)) {
                $duplicados[] = "Usuario: " . $row['usuario'] . ", Teléfono: " . $row['telefono'] . ", Correo: " . $row['correo'];
            }
            throw new Exception('El usuario, teléfono o correo ya están registrados. Duplicados encontrados: ' . implode(' | ', $duplicados));
        }

        // Iniciar transacción
        mysqli_begin_transaction($conexion);

        // Consulta para actualizar los datos del usuario
        $consulta = "UPDATE estudiantes 
                     SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, estatura = ?, telefono = ?, correo = ?, usuario = ?, curp = ? WHERE boleta = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        // Asignar los parámetros de la consulta
        mysqli_stmt_bind_param($stmt, 'ssssssssi', $Nombre_Estudiante, $Primer_Apellido, $Segundo_Apellido, $Estatura, $Telefono, $Correo, $Usuario, $Curp, $Boleta);

        // Ejecutar la actualización
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Error al ejecutar la actualización: ' . mysqli_error($conexion));
        } else {
            // Confirmar la transacción
            if (!mysqli_commit($conexion)) {
                throw new Exception('Error al confirmar la transacción.');
            }

            // Responder éxito
            echo json_encode([
                'success' => true,
                'message' => 'Registro actualizado correctamente.',
                'datos_actualizados' => [
                    'boleta' => $Boleta,
                    'nombre' => $Nombre_Estudiante,
                    'primer_apellido' => $Primer_Apellido,
                    'segundo_apellido' => $Segundo_Apellido,
                    'telefono' => $Telefono,
                    'correo' => $Correo,
                    'usuario' => $Usuario,
                    'curp' => $Curp
                ]
            ]);
        }

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        mysqli_rollback($conexion);

        // Responder con error
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    } finally {
        // Cerrar conexiones
        if (isset($estadoVerificacion)) {
            mysqli_stmt_close($estadoVerificacion);
        }
        if (isset($stmt)) {
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conexion);
    }
}
?>
