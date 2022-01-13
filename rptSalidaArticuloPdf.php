<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;

$fecha=date('Y-m-d');
$start = $_GET['start'];
$end = $_GET['end'];
$articulo = $_GET['articulo'];
$c= new conectar();
$conexion=$c->conexion();

$sql="SELECT art.nombre, ven.fechaCompra, ven.cantidad, ven.precio, ven.total
FROM VENTAS ven
INNER JOIN articulos art on art.id_producto = ven.id_producto WHERE ven.fechaCompra BETWEEN '".$start."' AND '".$end."'";

if($articulo != null){
$sql = $sql." and ven.id_producto = ".$articulo;
}	

$result=mysqli_query($conexion,$sql);

$total = 0;

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
                <td scope='col'>Articulo</td>
                <td scope='col'>Fecha</td>
                <td scope='col'>Cantidad</td>
                <td scope='col'>Precio</td>
                <td scope='col'>Total</td>
            </tr>        
        </thead>
        <tbody>";

        while($datos=mysqli_fetch_row($result)):
            $html = $html."<tr>
                <td>".$datos[0]."</td>
                <td>".$datos[1]."</td>
                <td>".$datos[2]."</td>
                <td>$".$datos[3]."</td>
                <td>$".$datos[4]."</td>
            </tr>";
        $total = $total + $datos[4];
        endwhile;            
        
        $html = $html."<tr>
            <td colspan='5'>Total general: $".$total."</td>
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