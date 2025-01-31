<?php
// Iniciar la sesión
session_start();

// Recuperar los datos de la sesión
$nombreUsuario = $_SESSION['nombreUsuario'] ?? null;
$datosUsuario = $_SESSION['datosUsuario'] ?? null;
$noCasillero = $_SESSION['noCasillero'] ?? '-';
$_SESSION['descargar'] = 'N';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>.::Acuse::.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Navbar_y_slider.css">
    <link rel="stylesheet" href="/css/Solicitud_html/general.css">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="icon" type="image/png" href="../imgs/logoEquipo.png">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../js/Solicitud_html/limpiar_form.js"></script>
    <script src="../js/Solicitud_html/MostarOcultarCamposFormulario.js"></script>
    <script src="../js/Solicitud_html/Validaciones_Modal.js"></script>
</head>

<body>
    <section class="imagen">
        <div class="contenido-imagen">
            <a class="pag1" href="https://www.escom.ipn.mx/" target="_blank">
                <img src="../imgs/logoEscom.png" height="150px" alt="ESCOM" title="ESCOM">
            </a>

            <div class="encabezado">
                <h2>Escuela Superior de Cómputo</h2>
                <p>Solicitud de casillero</p>
            </div>
            <a class="pag2" href="https://www.ipn.mx/" target="_blank">
                <img src="../imgs/logoIPN.png" height="150px" alt="ESCOM" title="Instituto Politécnico Nacional">
            </a>

        </div>
    </section>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="PagPrincipal.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Solicitud.html">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Acuse.html">Acceso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Colocar contenido de acceso para solicitud por primera vex -->

  <!--FORMULARIO-->
    <div class="container mt-4" id="Formulario">
        <form id="solicitudForm" action="../php/ProcesarForm.php" method="post" enctype="multipart/form-data">
            <h2 class="mb-3">Bienvenido <?php echo htmlspecialchars($nombreUsuario); ?></h2>

            <!-- Mostrar datos del usuario -->

            <div class="pb-4 pt-4">

                <p><b>Nombre:</b> <?php echo htmlspecialchars($datosUsuario['nombre']) . " " . htmlspecialchars($datosUsuario['primer_apellido']) . " " . htmlspecialchars($datosUsuario['segundo_apellido']); ?></p>
                <p><b>Correo:</b> <?php echo htmlspecialchars($datosUsuario['correo']); ?></p>
                <p><b>Número de casillero:</b> <?php echo htmlspecialchars($noCasillero) ?></p>

            </div>


            <div class="mt-4">
                <div class="col d-flex justify-content-between">
                    <button type="button" class="btn btn-primary" id="generarAcuse">Ver Acuse</button>
                    <button type="reset" class="btn btn-warning" id="cerrarSesion">Cerrar sesión</button>
                </div>
            </div>

        </form>
    </div>



    <footer class="container-fluid mt-4">
        <div class="row p-5 pb-2 bg-dark text-white">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h3">Equipo 7</p>
                <img class="img-fluid" src="../imgs/logoEquipo.png" alt="logoEquipo" width="150px">
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
                    <a class="text-white text-decoration-none" href="mailto:saulvelpa120@gmail.com">saulvelpa120@gmail.com</a>
                </div>
                <div class="mb-3">
                    <a class="text-white text-decoration-none" href="mailto:miguelarenas315@gmail.com">miguelarenas315@gmail.com</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <p class="h5 mb-3">ESCOM - IPN</p>
                <div class="mb-3">
                    <a class="text-white text-decoration-none" href="https://www.escom.ipn.mx/" target="_blank">escom</a>
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
    <script>
        const btnGenerarAcuse = document.getElementById("generarAcuse");
        const btnCerrarSesion = document.getElementById("cerrarSesion");

        btnGenerarAcuse.addEventListener('click', () => {
            const nuevaP = window.open('../php/genPDF.php', '_blank');
            const boleta = "<?php echo $datosUsuario['boleta']; ?>";
            const nombreArchivo = boleta + ".pdf";
            nuevaP.document.title = nombreArchivo; // Establecer el nombre como título de la pestaña
        });

        btnCerrarSesion.addEventListener('click', () => {
            fetch('../php/cerrarSesionUser.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'logout=1'
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = 'PagPrincipal.html';
                    } else {
                        console.error('Error al cerrar sesión');
                    }
                })
                .catch(error => console.error('Error de red:', error));
        });
    </script>
</body>

</html>
