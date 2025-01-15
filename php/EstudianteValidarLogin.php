<?php
    session_start();

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

    $_SESSION["nombreUsuario"] = $usuario;

    // Verificar si la consulta tuvo éxito
    if (!$resultado) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Validar si el usuario existe
    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);

        //Datos del usuario
        $_SESSION['datosUsuario'] = [
            'nombre' => htmlspecialchars($row['nombre'] ?? 'pruebaNombre'),
            'primer_apellido' => htmlspecialchars($row['primer_apellido'] ?? 'pruebaAp1'),
            'segundo_apellido' => htmlspecialchars($row['segundo_apellido'] ?? 'pruebaAp2'),
            'correo' => htmlspecialchars($row['correo'] ?? 'prueba@gmail.com'),
            'boleta' => htmlspecialchars($row['boleta'] ?? ''),
        ];


        // Verificar la contraseña ingresada con la encriptada en la base de datos
        if (password_verify($contrasena, $row['contraseña'])) {
            // Redireccionar a la página principal 
            //header('Location: ../html/PagPrincipal.html');  //PROVISIONAL EN TEORIA DEBERIA REDIRECCIONAR A LA PAGINA DEL PDF

            $consultaSolicitud = "SELECT S.* FROM solicitudes as S INNER JOIN estudiantes as E ON S.id_estudiante = E.id_estudiante WHERE E.usuario = '$usuario'";
            $resultadoSolicitud = mysqli_query($conexion, $consultaSolicitud);
            if (!$resultadoSolicitud) { // Verificar si la consulta tuvo éxito
                die('Error en la consulta resultado de Solicitud: ' . mysqli_error($conexion));
            }
            $filaSolicitud = mysqli_fetch_assoc($resultadoSolicitud);
            $estatusS = $filaSolicitud['estatus'];
            $_SESSION["noCasillero"] = $filaSolicitud['numero_casillero'];

            if($estatusS == 'Asignado'){ //Mostrar solo la opcion de imprimir acuse y cerrar sesión
                header("Location: ../html/acceso3.php");
                exit;
            }
            else if($estatusS == 'Pendiente'){ //Casos para recibir comprobante de pago
                 
                //Comprobar si hay menos de 100 en la BD
                $numSolicitudes = "SELECT COUNT(*) AS tot FROM solicitudes";
                $resultadoNumS = mysqli_query($conexion, $numSolicitudes);
                if(!$resultadoNumS){
                    die('Error en la consulta numero de Solicitudes: ' . mysqli_error($conexion));
                }
                $filaNum = mysqli_fetch_assoc($resultadoNumS);

                if($filaNum['tot'] < 100){ //Si hay menos de 100 solicitudes guardadas continuar permitiendo el acceso
                

                    $tipoSolicitud = $filaSolicitud['tipo_solicitud'];

                    $fechaSolicitud = $filaSolicitud['fecha_registro'];
                    $fechaS = new DateTime($fechaSolicitud);
                    $fechaAct = new DateTime(); // Obtiene la fecha y hora actual
                    $diferencia = $fechaAct->diff($fechaS);
                    $horas = ($diferencia->days * 24) + $diferencia->h;

                    if($tipoSolicitud == "Registro"){ //Pagina para registro por primera vez

                        if($horas >= 48){ //Tiempo mayor que 48 hrs dejar acceder
                            header("Location: ../html/acceso1.php");
                            exit;
                        }
                        else{ //Esperar a que pasen 48 hrs // (Solo mensaje)
                            $_SESSION["msj"] = "Por favor espere a que transcurran 48 horas desde su registro";
                            header("Location: ../html/mensaje.php");
                            exit;
                        }
                    }
                    else{ //Solicitud de renovación
    
                        // Verificar si han pasado menos de 24 horas
                        if ($horas < 24) { 
                            header("Location: ../html/acceso2.php");
                            exit;
                        } 
                        else { // (Solo mensaje)
                            $_SESSION["msj"] = "Su tiempo para enviar el comprobante de pago ha finalizado, por favor espera por la reasignación de otro casillero";
                            header("Location: ../html/mensaje.php");
                            exit; 
                        }
                    }
                }
                else{ //Mostrar mensaje de en espera (Solo mensaje)
                    $_SESSION["msj"] = "Sin casilleros disponibles. En lista de espera";
                    header("Location: ../html/mensaje.php");
                    
                    exit;
                }
            }
            else if($estatusS == 'Lista de espera'){ //En lista de espera (Solo mensaje)
                $_SESSION["msj"] = "Sin casilleros disponibles. En lista de espera";
                exit;
            }
            else{ //Agregar estado de solicitud rechazada (Solo mensaje)
                $_SESSION["msj"] = "Sin casilleros disponibles. En lista de espera";
                header("Location: ../html/mensaje.php");
                exit;
            }
            
            //exit();
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
