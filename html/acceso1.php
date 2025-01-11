<?php
// Iniciar la sesión
session_start();

// Recuperar los datos de la sesión
$nombreUsuario = $_SESSION['nombreUsuario'] ?? null;

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

            <div class="mb-2">
                <p>Por favor lea el acuerdo de responsabilidades en el uso del casillero</p>
            </div>

            <div class="mb-2">
                <h3 class="pt-3">ACUERDO DE RESPONSABILIDADES EN EL USO DEL CASILLERO 2024</h3>

                <p class="pt-2"><b>Se autoriza</b> que utilices el casillero señalado durante el ciclo escolar <b><u>agosto 2024- febrero 2025</u></b>,
                    dentro de la Campaña de Procuración de Fondos.
                </p>

                <p>
                    La utilización de este servicio deberá realizarse de forma adecuada y manteniendo la imagen de
                    orden y limpieza del plantel, <b>por lo que por ningún motivo podrás:</b>

                </p>

                <ul>
                    <li><b>Compartir o traspasar</b> el uso del casillero de manera directa.</li>
                    <li><b>Almacenar</b> cualquier tipo de productos para comercialización.</li>
                    <li><b>Pintar o señalar</b> el casillero.</li>
                    <li><b>Colocar</b> calcomanías o distintivos.</li>
                    <li><b>Abrir</b> el casillero por extravío de llaves sin antes reportarlo a la Subdirección
                        Administrativa.</li>
                    <li><b>Tener alimentos o bebidas</b> que generen algún tipo de derramamiento o plaga.</li>
                    <li><b>Guardar</b> bebidas alcohólicas o sustancias prohibidas.</li>
                </ul>

                <p>
                    Cualquier incumplimiento de los puntos señalados será motivo de la suspensión inmediata del
                    servicio y en caso de gravedad de la falta podrá ser turnado a la Comisión de Honor del Consejo
                    Técnico Consultivo Escolar.
                </p>

                <p>
                    El uso del casillero será para resguardar material bibliográfico, académico, de laboratorio, deportivo,
                    cultural y lo relacionado con tu actividad como estudiante dentro de la escuela.

                </p>

                <p class="pt-3">
                    No debes guardar en el interior objetos consideradas de alto valor:
                </p>

                <ul>
                    <li>Laptops</li>
                    <li>Tablet´s</li>
                    <li>Alhajas</li>
                    <li>Dinero en efectivo</li>
                    <li>Cámaras fotográficas, etc.</li>
                </ul>

                <p class="pb-3">
                    Lo anterior debido a que no se puede garantizar totalmente seguridad de estos.
                </p>
            </div>

            <div class="mb-5">

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        <b>Acepto el acuerdo de responsabilidades</b>
                    </label>
                    <div class="invalid-feedback">
                        Deberás aceptar el acuerdo de responsabilidades antes de continuar
                    </div>
                </div>

            </div>

            <div class="mb-5">

                <div id="EleccionCredencial" class="mb-3">
                    <label for="Credencial" class="form-label">Comprobante de pago</label>
                    <input type="file" class="form-control" id="Credencial" name="Credencial" accept=".PDF">
                    <div class="mensaje-invalido"></div>
                </div>

            </div>

            <div class="mt-4">
                <div class="col d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="Enviar" onclick="">Enviar</button>
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
</body>

</html>