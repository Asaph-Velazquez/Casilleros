<?php
// Iniciar la sesión
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['nombreUsuario'])) {
    // Si no hay sesión activa, redirigir al formulario de login
    header('location: ../html/PagPrincipal.html');
    exit();
}

// Incluir el archivo actualizar.php para procesar datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../php/Admin/verDatos.php');
}
if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}

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
        <link rel="preload" href="">
    <link rel="stylesheet" href="../css/Navbar_y_slider.css">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="icon" type="image/png" href="../imgs/logoEquipo.png">
    <link rel="stylesheet" href="../css/admon.css">
    
 
    <script src="../js/Solicitud_html/Validaciones_Modal.js" ></script> 
    <script src="../js/vistaAdmin/Formularios/MostrarOcultarCamposFormularioAdmin.js" ></script>
    <script src="../js/Solicitud_html/Validaciones_Modal.js" ></script> 
    
    <script src="../js/Solicitud_html/limpiar_form.js" defer></script>
    
    <style>
        main{
            margin: 20px 40px;
        }
        #Botonesformulario{
            display: flex;
            justify-content: center;
            margin-left: 2%
        }
        
    </style>

</head>

<body>

    <header class="imagen">
        <div class="contenido-imagen">
            <a class="pag1" href="https://www.escom.ipn.mx/" target="_blank">
                <img src="../imgs/logoEscom.png" height="150px" alt="ESCOM" title="ESCOM">
            </a>
            <div class="encabezado">
                <h2>Escuela Superior de Cómputo</h2>
                <p>Sistema de Casilleros</p>
            </div>
            <a class="pag2" href="https://www.ipn.mx/" target="_blank">
                <img src="../imgs/logoIPN.png" height="150px" alt="ESCOM" title="Instituto Politécnico Nacional">
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
                        <a class="nav-link active" aria-current="page" href="PagPrincipal.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/Admin/cerrarSesion.php">Cerrar Sesión</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <main>
        <h1 style="margin: 10px 20px;">Bienvenido, <?php echo $_SESSION['nombreUsuario']; ?>!</h1>

        <div class="mb-3" style="margin: 5px 20px;">
            <label class="form-label">Disponibilidad de Casilleros </label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="celdaCasilleros" id="MostrarCasilleros"
                    value="MostrarCasilleros">
                <label class="form-check-label" for="MostrarCasilleros">
                    Mostrar Casilleros
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="celdaCasilleros" id="OcultarCasilleros"
                    value="OcultarCasilleros">
                <label class="form-check-label" for="OcultarCasilleros">
                    Ocultar Casilleros
                </label>
            </div>
        </div>
        <div class="contenedorPrincipal-Casilleros" >
            <div class="contenedor-casilleros" id="celda-casilleros" style="display: none;"></div>
        </div>


        <div class="entradas-radio" id="Botonesformulario">
            <label class="radio">
                <input type="radio" name="radio" checked="" id="Agregar">
                <span class="texto">Agregar</span>
            </label>
            <label class="radio">
                <input type="hidden" name="radio" id="Eliminar">
            </label>
            <label class="radio">
                <input type="radio" name="radio" id="Actualizar">
                <span class="texto">Buscar Registro </span>
            </label>

        </div>
        

        <!--FORMULARIO-->
        <div id="formularioIngreso" style="display: none;">
            <div class="container mt-4" id="Formulario">
                <form id="solicitudForm" action="../php/Admin/ProcesarFormAdmin.php" method="post" enctype="multipart/form-data">
                    <h2>Solicitud de Casillero</h2>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Solicitud</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipoSolicitud" id="Registro"
                                value="Registro">
                            <label class="form-check-label" for="Registro">
                                Solicitud de Registro
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipoSolicitud" id="Renovacion"
                                value="Renovacion">
                            <label class="form-check-label" for="Renovacion">
                                Solicitud de Renovación
                            </label>
                        </div>
                    </div>

                    <div id="lockerAnterior" class="mb-3" style="display: none;">
                        <label for="CasilleroAnterior" class="form-check-label">Número de Casillero Anterior</label>
                        <input type="number" class="form-control" id="CasilleroAnterior"
                            placeholder="Ingrese el número de su Casillero Anterior" name="CasilleroAnterior">
                    </div>

                    <div id="EleccionCURP" class="mb-3" style="display: none;">
                        <label for="CURP" class="form-check-label">CURP</label>
                        <input type="text" class="form-control" id="CURP" placeholder="Ingrese su CURP" name="CURP">
                        <div class="mensaje-invalido"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div id="EleccionNombre" class="mb-3" style="display: none;">
                                <label for="Nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="Nombre" placeholder="Ingresa tu nombre"
                                    name="Nombre">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div id="PrimerApellido" class="mb-3" style="display: none;">
                                <label for="ApellidoPaterno" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="ApellidoPaterno"
                                    placeholder="Ingresa tu Primer Apellido" name="ApellidoPaterno">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div id="SegundoApellido" class="mb-3" style="display: none;">
                                <label for="ApellidoMaterno" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="ApellidoMaterno"
                                    placeholder="Ingresa tu Segundo Apellido" name="ApellidoMaterno">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div id="EleccionTelefono" class="mb-3" style="display: none;">
                                <label for="Telefono" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" id="Telefono" placeholder="55..."
                                    name="Telefono">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div id="EleccionCorreo" class="mb-3" style="display: none;">
                                <label for="Correo" class="form-label">Correo Institucional</label>
                                <input type="email" class="form-control" id="Correo" placeholder="abc@alumno.ipn.mx"
                                    name="Correo">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div id="EleccionBoleta" class="mb-3" style="display: none;">
                                <label for="Boleta" class="form-label">Boleta</label>
                                <input type="number" class="form-control" id="Boleta" placeholder="2018..."
                                    name="Boleta">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div id="EleccionEstatura" class="mb-3" style="display: none;">
                                <label for="Estatura" class="form-label">Estatura</label>
                                <input type="text" class="form-control" id="Estatura" placeholder="1.70"
                                    name="Estatura">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div id="EleccionCredencial" class="mb-3" style="display: none;">
                                <label for="Credencial" class="form-label">Credencial Vigente del IPN (PDF)</label>
                                <input type="file" class="form-control" id="Credencial" placeholder="Sube tu Credencial"
                                    name="Credencial" accept=".PDF">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div id="EleccionHorario" class="mb-3" style="display: none;">
                                <label for="Horario" class="form-label">Horario (PDF)</label>
                                <input type="file" class="form-control" id="Horario"
                                    placeholder="Sube tu horario del SAES" name="Horario" accept=".PDF">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div id="EleccionUsuario" class="mb-3" style="display: none;">
                                <label for="Usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="Usuario" placeholder="Ingresa tu Usuario"
                                    name="Usuario">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div id="EleccionContraseña" class="mb-3" style="display: none;">
                                <label for="Contraseña" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="Contraseña"
                                    placeholder="Ingresa tu Contraseña" name="Contraseña">
                                <div class="mensaje-invalido"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" id="Registrar" style="display: none;" >Registrar Solicitud</button>
                            <button type="reset" class="btn btn-warning" id="Limpiar" style="display: none;"
                                onclick="LimpiarFormulario();">Limpiar</button>
                        </div>
                    </div>

                    <!--MODAL-->
                    <div class="modal fade" id="DatosModal" tabindex="-1" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Verificación de datos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Enviar Datos</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Modificar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Modal2-->
                   

                </form>
            </div>
        </div> <!--Fin de formulario para agregar nuevos registros-->

        <!--Inicio del formulario para eliminar Registro-->
        <div id="formularioEliminar" style="display: none; margin: 30px 50px;">
            <h2>Eliminar Registro</h2>
            <form class="row g-3" autocomplete="off" action="../php/Admin/borrarRegistros.php
            " method="post" id="formDelete">
                <!-- Campos del formulario -->
                <div class="col-md-4">
                    <label for="NombreBorrar" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="NombreBorrar" required placeholder="Ingresa el nombre"
                        name="NombreBorrar">
                </div>
                <div class="col-md-4">
                    <label for="primerApellidoBorrar" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="primerApellidoBorrar" name="primerApellidoBorrar"
                        required placeholder="Ingresa el primer apellido">
                </div>
                <div class="col-md-4">
                    <label for="segundoApellidoBorrar" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="segundoApellidoBorrar" name="segundoApellidoBorrar"
                        required placeholder="Ingresa el segundo apellido">
                </div>
                <div class="col-md-4">
                    <label for="validarUsuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="validarUsuario" placeholder="Ingresa tu usuario"
                        name="validarUsuario">
                </div>
                <div class="col-md-4">
                    <label for="casilleroBorrar" class="form-label">Número de Casillero</label>
                    <input type="number" class="form-control" id="casilleroBorrar"
                        placeholder="Número de casillero asignado" name="casilleroBorrar" min="1" max="100" required>
                </div>
                <div class="col-md-4">
                    <label for="boletaBorrar" class="form-label">No. Boleta</label>
                    <input type="text" class="form-control" id="boletaBorrar" placeholder="Boleta" name="boletaBorrar"
                        required>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-primary" id="borrarRegistro"
                        onclick="validarFormulario(event)">
                        Eliminar Registro
                    </button>
                </div>
            </form>
            <!--Inicio del modal-->

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">¿Continuar con la eliminación del
                                registro?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalMensaje">
                            <!-- Aquí aparecerá el mensaje -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="confirmarEliminar" style="display: none;"
                                onclick="eliminarRegistro()">Confirmar Eliminación</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Fin del modal-->
        </div> <!--Fin de formulario para eliminar registros-->



        <!--Inicio del formulario para actualizar Registro y ver registros-->
        <div id="formularioUpdate" style="display: none; margin: 30px 40px;">
            <h2>Busca un Registro mediante la boleta</h2>
            <nav class=" bg-body-tertiary">
                <div class="container-fluid">
                    <form class="d-flex" role="search" action="" method="post">
                        <input class="form-control me-2" type="search" placeholder="Boleta" aria-label="Search" id="boletaBuscar" name="boletaBuscar" required>
                        <button class="btn btn-outline-success" type="submit"
                            style="background-color: aliceblue; color: black;">Buscar</button>
                    </form>
                </div>
            </nav>

            <!-- Mostrar resultados en tabla -->
            <?php if (isset($registroEncontrado) && $registroEncontrado): ?>
                <div class="table-responsive" >
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Boleta</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Primer Apellido</th>
                            <th scope="col">Segundo Apellido</th>
                            <th scope="col">Estatura</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">CURP</th>
                            <th scope="col"> Casillero </th>
                            <th scope="col">Tipo de Solicitud</th>
                            <th scope="col">Fecha de Solicitud</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($Boleta) ?></td>
                            <td><?= htmlspecialchars($Nombre_Estudiante) ?></td>
                            <td><?= htmlspecialchars($Primer_Apellido) ?></td>
                            <td><?= htmlspecialchars($Segundo_Apellido) ?></td>
                            <td><?= htmlspecialchars($Estatura) ?></td>
                            <td><?= htmlspecialchars($Telefono) ?></td>
                            <td><?= htmlspecialchars($Correo) ?></td>
                            <td><?= htmlspecialchars($Usuario) ?></td>
                            <td><?= htmlspecialchars($Curp) ?></td>
                            <td><?= htmlspecialchars($numeroCasillero) ?></td>
                            <td><?= htmlspecialchars($tipoSolicitud) ?></td>
                            <td><?= htmlspecialchars($fechaSolicitud) ?></td>
                            <td>
                            <a href="../php/Admin/actualizar.php?boleta=<?= urlencode($Boleta) ?>" class="btn btn-outline-primary">Editar</a>
                            <a href="../php/Admin/borrarRegistros.php?boleta=<?= urlencode($Boleta) ?>" class="btn btn-outline-primary">Eliminar</a>
                            </td>


                        </tr>

                    </tbody>
                </table>
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <p>No se encontraron registros con la boleta proporcionada.</p>
            <?php endif; ?>
        </div> <!--Fin de formulario para actualizar registros-->



    </main>
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
    

    
    
    <script src="../js/vistaAdmin/admon.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>