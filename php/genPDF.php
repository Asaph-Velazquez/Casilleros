<?php 
require('fdpf/fpdf.php');
//creacion del pdf
$PDF = new FPDF();
$PDF->AddPage(); //añade una página al documento 
$PDF->SetFont('Arial','B',18); //establece la fuente, el estilo y el tamaño de la fuente
$PDF->Cell(40,10,'ACUSE',1,1,'C'); //añade una celda al documento
//conexión a la base de datos
$conexion = mysqli_connect("localhost","root","","Casilleros");
if(!$conexion){
    die("Error de conexión: ".mysqli_connect_error());
}
$usuario = $_POST['UsuarioLogin'] ?? ''; //obtener el usuario
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
    $PDF->Cell(0,0,'Nombre Completo: $nombre $apellidoP $apellidoM',0,1,'L');
    $PDF->Cell(0,0,'Periodo: SEMESTRE 2024-2025/2',0,1,'L');
    $PDF->Cell(0,0,'Casillero Asignado: $casillero',0,1,'L');
    $PDF->Output('I',"$numBoleta.pdf");
    
}
else{
    echo "El usuario no corresponde al logueado.";
}


?>