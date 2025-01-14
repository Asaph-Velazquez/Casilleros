<?php
    // Conexión a la base de datos
    session_start();
    $conexion = mysqli_connect('localhost', 'root', '', 'casilleros');

    // Verificar conexión
    if (!$conexion) {
        die('Error al conectar con la base de datos: ' . mysqli_connect_error());
    }

    // Recuperar valores del formulario
    $usuario = $_POST['UsuarioLogin'] ?? '';
    $numTrabajador = $_POST['NumTrabajador'] ?? '';
    $contrasena = $_POST['ContraseniaLogin'] ?? '';

    // Consulta para validar los datos
    $consulta = "SELECT * FROM administradores WHERE usuario = '$usuario' AND num_trabajador = '$numTrabajador' AND contraseña = '$contrasena'";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si la consulta tuvo éxito
    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Validar si el administrador existe
    if (mysqli_num_rows($resultado) > 0) {
        // Redireccionar a la página principal del administrador
        $_SESSION['usuario'] = $usuario;
        header('location: ../html/admon.php'); //Pagina del administrador
        exit();
    } else {
        echo 'El administrador no existe o los datos son incorrectos.';
    }

    // Cerrar conexión
    mysqli_close($conexion);
?>
