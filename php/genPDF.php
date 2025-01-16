<?php 
session_start();

require('fpdf186/fpdf.php');
//creacion del pdf
$PDF = new FPDF();
$PDF->AddPage(); //añade una página al documento 
$PDF->SetFont('Arial','B',18); //establece la fuente, el estilo y el tamaño de la fuente


$PDF->Image('../imgs/logoEscom.png', 10, 10, 30); // x=10, y=10, ancho=30mm

$PDF->SetXY(85, 20);
$PDF->Cell(40, 10, 'ACUSE', 1, 0,'C'); //añade una celda al documento

$PDF->Image('../imgs/logoIPN.png', 170, 10, 30); // x=170, y=10, ancho=30mm

$PDF->Ln(20);

//conexión a la base de datos
$conexion = mysqli_connect("localhost","root","","Casilleros");
if(!$conexion){
    die("Error de conexión: ".mysqli_connect_error());
}

$usuario = $_SESSION['nombreUsuario'];
$descargar = $_SESSION['descargar'];

// Consulta para buscar el casillero del estudiante
$consulta = "
    SELECT 
        e.boleta, 
        e.nombre, 
        e.primer_apellido, 
        e.segundo_apellido, 
        s.numero_casillero 
    FROM estudiantes e
    JOIN solicitudes s ON e.id_estudiante = s.id_estudiante
    WHERE e.usuario = '$usuario'
";
$resultado = mysqli_query($conexion, $consulta);

if(mysqli_num_rows($resultado) > 0){
    $datos = mysqli_fetch_assoc($resultado);
    $numBoleta = $datos['boleta'];
    $nombre = $datos['nombre'];
    $apellidoP = $datos['primer_apellido'];
    $apellidoM = $datos['segundo_apellido'];
    $casillero = $datos['numero_casillero'];

    if(is_null($casillero)){
        $casillero = "Sin asignar";
    }

    $nombreCompleto = "$nombre $apellidoP $apellidoM";
    $PDF->Cell(40,20,'Nombre Completo: ' .  $nombreCompleto,0,1,'L');
    $PDF->Cell(40,20,'Periodo: SEMESTRE 2024-2025/2',0,1,'L');
    $PDF->SetTextColor(255, 0, 0);
    $PDF->Cell(40,20,'Casillero Asignado: ' . $casillero,0,1,'L');

    if($descargar == 'S'){
        $PDF->Output('I', $numBoleta . '.pdf');
    }
    else{
        header("Content-Type: application/pdf");
        $nombreArchivo = $numBoleta . ".pdf";
        header("Content-Disposition: inline; filename=$nombreArchivo"); // Para que tenga el nombre deseado
        $PDF->Output(); // Se enviará directamente al navegador sin el header de 'Content-Disposition'
    }
}
else{
    echo "El usuario no corresponde al logueado.";
}


?>
