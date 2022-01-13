<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;

$fecha=date('Y-m-d');
$start = $_GET['start'];
$end = $_GET['end'];
$referencia = $_GET['referencia'];
$articulo = $_GET['articulo'];

$c= new conectar();
$conexion=$c->conexion();

$sql="SELECT ven.id_venta,COALESCE((select cli.nombre from clientes cli where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, 
        art.nombre, ven.total
      FROM VENTAS ven
      INNER JOIN articulos art on art.id_producto = ven.id_producto WHERE ven.fechaCompra BETWEEN '".$start."' AND '".$end."'";

if($referencia != null){
    $sql = $sql." and ven.id_venta = ".$referencia;
}
if($articulo != null){
    $sql = $sql." and art.nombre = '".$articulo."'";
}		

$result=mysqli_query($conexion,$sql);

$total = 0;

$tabla = null;
while($datos=mysqli_fetch_row($result)){
    $cliente = '';
    if($datos[1] == 'A'){ $cliente = 'Contado'; }else if($datos[1] == '0'){ $cliente = 'Credito'; }else{ $cliente = $datos[1]; }
    $tabla.="<tr>
    <td>".$datos[0]."</td>
    <td>".$cliente."</td>
    <td>".$datos[2]."</td>
    <td>$".$datos[3]."</td>
    </tr>";
}


//var_dump($tabla);exit();

$html="<html>
<head>
    <title>INFORMACION DE REMISIONES</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #000;
            color: #fff;
        }
    </style>    
</head>
<body>
    <table class='table' style='borde:0px;'>
        <thead>
            <tr>
                <th style='text-align:center;'><img src='./img/maco.png' width='200' height='200'/></th>
            </tr>        
            <tr>
                <th>Fecha: ".$fecha."</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class='table table-striped table-bordered table-hover'>
        <thead class='thead-dark'>
            <tr>
                <td scope='col'>CODIGO</td>
                <td scope='col'>CLIENTE</td>
                <td scope='col'>ARTICULO</td>
                <td scope='col'>TOTAL COMPRA</td>
            </tr>
        </thead>
        <tbody>
        ".$tabla."
        <tr>
            <td colspan='4'>Total general: $".$total."</td>
        </tr>
        </tbody>
    </table>
</body>
</html>";

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

//cargar el html
$pdf->load_html($html);

// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("letter", "portrait");
 
// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('reporteInformacionRemisiones_'.$fecha.'.pdf', array("Attachment" => false));