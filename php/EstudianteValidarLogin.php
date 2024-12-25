<?php
    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

    // Verificar conexión
    if (!$conexion) {
        die('Error al conectar con la base de datos: ' . mysqli_connect_error());
    }

    // Recuperar valores del formulario
    $usuario = $_POST['UsuarioLogin'] ?? '';
    $contrasena = $_POST['ContraseniaLogin'] ?? '';

    // Consulta para obtener la contraseña encriptada del usuario
    $consulta = "SELECT * FROM estudiantes WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta tuvo éxito
    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Validar si el usuario existe
    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        
        // Verificar la contraseña ingresada con la encriptada en la base de datos
        if (password_verify($contrasena, $row['contraseña'])) {
            // Redireccionar a la página principal 
            header('Location: ../html/PagPrincipal.html');  //PROVISIONAL EN TEORIA DEBERIA REDIRECCIONAR A LA PAGINA DEL PDF
            exit();
        } else {
            // Contraseña incorrecta
            echo 'Contraseña incorrecta.';
        }
    } else {
        echo 'El usuario no existe.';
    }

    // Cerrar conexión
    mysqli_close($conexion);
?>
