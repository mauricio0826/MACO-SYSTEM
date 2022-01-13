<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;

//Obteniendo datos
$start = $_REQUEST['start'];
$end = $_REQUEST['end'];
$fecha = date("Y-m-d");

$c= new conectar();
$conexion=$c->conexion();
if(!empty($start) && !empty($end)){
    $sql_where= " WHERE art.fechaCaptura BETWEEN '".$start."' AND '".$end."'";
}else{
    $sql_where=null;
}
$sql="SELECT 
			art.id_producto,
			art.id_usuario,
			art.nombre,
			art.cantidad cantidad_actual,
			art.precio,
			COALESCE(
				(CASE WHEN art.origen = 'B' THEN 'NACIONAL' END),
				(CASE WHEN art.origen = 'C' THEN 'IMPORTADO' END)
			)	descripcion,
			art.fechaCaptura fecha_ingreso
		FROM
		inventarios art
        ".$sql_where."
	GROUP BY art.id_producto,art.fechaCaptura";

$result=mysqli_query($conexion,$sql);
$total =0;

$sql_sumatoria = "SELECT sum(art.precio) total FROM inventarios art ".$sql_where."";
$resultado = mysqli_query($conexion,$sql_sumatoria);
$renglones = mysqli_fetch_assoc($resultado);
$total = $renglones['total'];

$html="<html>
<head>
    <title>REPORTE EXISTENCIA INVENTARIO</title>
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
    <br/>
    <table class='table table-striped table-bordered table-hover'>
        <thead class='thead-dark'>
            <tr>
                <td scope='col'>Inventario</td>
                <td scope='col'>Cantidad</td>
                <td scope='col'>Precio</td>
                <td scope='col'>Fecha Ingreso</td>
                <td scope='col'>Tipo</td>
            </tr>
        </thead>
        <tbody>";
        while($datos=mysqli_fetch_row($result)):
        $html = $html.= "<tr>
            <td>".$datos[2]."</td>
            <td>".$datos[3]."</td>
            <td>$".$datos[4]."</td>
            <td>".$datos[5]."</td>
            <td>".$datos[6]."</td>
            </tr>";
        endwhile;
        $html = $html.="<tr>
        <td colspan='5'>Total general:".$total."</td>
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