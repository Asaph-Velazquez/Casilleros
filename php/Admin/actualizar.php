<?php
session_start();
// Verificar que se reciba la boleta
if (!isset($_GET['boleta']) || empty($_GET['boleta'])) {
    die("No se proporcionó una boleta.");
}
$Boleta = $_GET['boleta'];
$conexion = mysqli_connect("localhost", "root", "", "casilleros");
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
//obtenemos los datos que se pueden actualizar
$consulta = "SELECT * FROM estudiantes WHERE boleta = '$Boleta'";
$resultado = mysqli_query($conexion, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $Nombre_Estudiante = $fila['nombre'];
    $Primer_Apellido = $fila['primer_apellido'];
    $Segundo_Apellido = $fila['segundo_apellido'];
    $Estatura = $fila['estatura'];
    $Telefono = $fila['telefono'];
    $Correo = $fila['correo'];
    $Usuario = $fila['usuario'];
    $Curp = $fila['curp'];
    $numeroCasillero = $fila['numero_casillero'];
}
mysqli_close($conexion);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/Navbar_y_slider.css">
    <link rel="icon" type="image/png" href="../../imgs/logoEquipo.png">
    <link rel="stylesheet" href="../../css/app.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</head>

<body>


    <header class="imagen">
        <div class="contenido-imagen">
            <a class="pag1" href="https://www.escom.ipn.mx/" target="_blank">
                <img src="../../imgs/logoEscom.png" height="150px" alt="ESCOM" title="ESCOM">
            </a>
            <div class="encabezado">
                <h2>Escuela Superior de Cómputo</h2>
                <p>Sistema de Casilleros</p>
            </div>
            <a class="pag2" href="https://www.ipn.mx/" target="_blank">
                <img src="../../imgs/logoIPN.png" height="150px" alt="ESCOM" title="Instituto Politécnico Nacional">
            </a>
        </div>
    </header>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../../html/admon.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../php/Admin/cerrarSesion.php">Cerrar Sesión</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    

    <!-- Verificamos si se encontraron los datos del estudiante -->
    <?php if (isset($Nombre_Estudiante)): ?>
        <div style="margin: 10px 50px;">
        <h2>Actualizar Datos del Estudiante</h2>
        <form class="row g-3" action="../../php/Admin/procesar_actualizacion.php" method="POST">
            <input type="hidden" name="boleta" value="<?= htmlspecialchars($Boleta) ?>">
            <div class="col-md-4">
                <label for="NombreActualizar" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="NombreActualizar" required placeholder="Ingresa el nombre"
                    name="NombreActualizar" value="<?= htmlspecialchars($Nombre_Estudiante) ?> " required>
            </div>

            <div class="col-md-4">
                <label for="PrimerApellidoActualizar" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" id="PrimerApellidoActualizar" required placeholder="Ingresa el primer apellido"
                    name="PrimerApellidoActualizar" value="<?= htmlspecialchars($Primer_Apellido) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="SegundoApellidoAct" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" id="SegundoApellidoAct" required placeholder="Ingresa el segundo apellido"
                    name="SegundoApellidoAct" value="<?= htmlspecialchars($Segundo_Apellido) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="EstaturaActualizar" class="form-label">Estatura</label>
                <input type="text" class="form-control" id="EstaturaActualizar" required placeholder="Ingresa la estatura"
                    name="EstaturaActualizar" value="<?= htmlspecialchars($Estatura) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="TelefonoActualizar" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="TelefonoActualizar" required placeholder="Ingresa el teléfono"
                    name="TelefonoActualizar" value="<?= htmlspecialchars($Telefono) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="correoActualizar" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correoActualizar" required placeholder="Ingresa el correo"
                    name="correoActualizar" value="<?= htmlspecialchars($Correo) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="usuarioActulizar" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuarioActulizar" required placeholder="Ingresa el usuario"
                    name="usuarioActulizar" value="<?= htmlspecialchars($Usuario) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="curpActualizar" class="form-label">CURP</label>
                <input type="text" class="form-control" id="curpActualizar" required placeholder="Ingresa la CURP"
                    name="curpActualizar" value="<?= htmlspecialchars($Curp) ?>" required>
            </div>

            <div class="col-md-4">
                <label for="casilleroActualizar" class="form-label">Nuevo Casillero</label>
                <input type="text" name="casilleroActualizar" id="casilleroActualizar" class="form-control" value="<?= htmlspecialchars($numeroCasillero) ?>" required>

            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" id="actualizarDatos"
                    onclick="">
                    Actualizar
                </button>
            </div>
        </form>
        </div>
    <?php else: ?>
        <p>No se encontró el estudiante con esa boleta.</p>
    <?php endif; ?>


    <footer class="container-fluid mt-4">
        <div class="row p-5 pb-2 bg-dark text-white">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h3">Equipo 7</p>
                <img class="img-fluid" src="../../imgs/logoEquipo.png" alt="logoEquipo" width="150px">
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h5 mb-3">Integrantes</p>
                <p class="mb-2 text-white"> Amador Martínez Jocelyn Lucía</p>
                <p class="mb-2 text-white"> Arenas Garita Miguel</p>
                <p class="mb-2 text-white"> Castillo Maya Lorenzo Brandon</p>
                <p class="mb-2 text-white"> Velázquez Parral Saul Asaph</p>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h5 mb-3">Contacto</p>
                <div class="mb-3">
                    <a class="text-white text-decoration-none"
                        href="mailto:saulvelpa120@gmail.com">saulvelpa120@gmail.com</a>
                </div>
                <div class="mb-3">
                    <a class="text-white text-decoration-none"
                        href="mailto:miguelarenas315@gmail.com">miguelarenas315@gmail.com</a>
                </div>
                <div class="mb-3">
                    <a class="text-white text-decoration-none"
                        href="mailto:castillomayabrandon@gmail.com">castillomayabrandon@gmail.com</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h5 mb-3">ESCOM - IPN</p>
                <div class="mb-3">
                    <a class="text-white text-decoration-none" href="https://www.escom.ipn.mx/"
                        target="_blank">escom</a>
                </div>
                <div class="mb-3">
                    <a class="text-white text-decoration-none" href="https://www.ipn.mx/" target="_blank">ipn</a>
                </div>
            </div>

            <div class="col-xs-12- pt-3">
                <p class="text-white text-center">Tecnologías para el Desarrollo de Aplicaciones Web</p>
            </div>
        </div>
    </footer>

</body>

</html>