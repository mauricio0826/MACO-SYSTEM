<?php
session_start();
isset($_SESSION['rol']) ? $id_rol = $_SESSION['rol'] : $id_rol = null;

// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;
$tabla_temporal_ventas = @$_SESSION['tablaComprasTemp'];
$fecha=date('Y-m-d');
$total=0;
if(isset($_SESSION['tablaComprasTemp']) && count($_SESSION['tablaComprasTemp']) > 0){
    $arr_vars = explode("||",$_SESSION['tablaComprasTemp'][0]);
}
$cliente = $arr_vars[4];
$html="<html>
<head>
    <title>REPORTE DE VENTA</title>
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
            <tr>
                <th>Nombre Cliente: ".$cliente."</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class='table table-striped table-bordered table-hover'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col'>ARTICULO</th>";
                if($id_rol == 99){
                    $html.="<th scope='col'>PRECIO</th>";
                }
                $html.="
                <th scope='col'>PRECIO VENTA</th>
                <th scope='col'>CANTIDAD</th>
                <th scope='col'>TIPO</th>
            </tr>
        </thead>
        <tbody>";
            foreach($tabla_temporal_ventas as $row){
                $item=explode("||", @$row);
                $tipoVenta = $item[5]=='1' ? 'CONTADO' : 'CREDITO';
            $html.="<tr>
                <td>".$item[1]."</td>";
                if($id_rol == 99){
                    $html.="<td>".$item[3]."</td>";
                }
                $html.="
                <td>".$item[7]."</td>
                <td>".$item[2]."</td>
                <td>".$tipoVenta."</td>
            </tr>";
                $total=$total + ( $item[2] * $item[7]);
            }
            $html.="<tfoot>
                <td colspan='4'>Total Venta: $ ".$total."</td>
            </tfoot>
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
$pdf->stream('reporteVentas_'.$fecha.'.pdf', array("Attachment" => false));