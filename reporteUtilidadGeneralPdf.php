<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;

$fecha=date('Y-m-d');
$start = $_GET['start'];
$end = $_GET['end'];

$c= new conectar();
$conexion=$c->conexion();

$sql="SELECT DISTINCT
        v.id_venta,
        COALESCE(CONCAT(c.nombre,c.apellido))cliente,
        COALESCE(a.nombre)articulo,
        a.id_producto,
        v.tipo_venta,
        v.id_usuario,
        v.cantidad,
        a.precio as costoUnitario,
        v.precio as precioUnitario,
        v.total as ventaTotal,
        (v.cantidad * a.precio) as costoVenta,
        COALESCE((v.total - (v.cantidad * a.precio)),'') utilidadBruta,
        v.fechaCompra
    FROM ventas v
    INNER JOIN clientes AS c on c.id_codigo = v.id_cliente
    INNER JOIN recaudo AS r on r.id_cliente = v.id_cliente
    INNER JOIN articulos AS a ON a.id_producto = v.id_producto
    WHERE v.fechaCompra
    BETWEEN '".$start."' AND '".$end."' ORDER BY v.fechaCompra DESC";
	
$result=mysqli_query($conexion,$sql);

$total = 0;

$tabla = null;
while($datos=mysqli_fetch_row($result)){
    $cliente = '';
    $total=$total + $datos[11];
    $tabla.="<tr>
    <td>".$datos[1]."</td>
    <td>".$datos[2]."</td>
    <td>".$datos[3]."</td>
    <td>".$datos[12]."</td>
    <td>".$datos[6]."</td>
    <td>".$datos[7]."</td>
    <td>".$datos[8]."</td>
    <td>".$datos[9]."</td>
    <td>".$datos[10]."</td>
    <td>".$datos[11]."</td>
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
                <td scope='col'>Cliente</td>
                <td scope='col'>Articulo</td>
                <td scope='col'>Código</td>
                <td scope='col'>Fecha Compra</td>
                <td scope='col'>Cantidad</td>
                <td scope='col'>Costo Unitario</td>
                <td scope='col'>Precio Unitario</td>
                <td scope='col'>Venta Total</td>
                <td scope='col'>Costo Venta</td>
                <td scope='col'>Utilidad Bruta</td>
            </tr>
        </thead>
        <tbody>
        ".$tabla."
        <tfoot>
            <tr>
                <th colspan='9'>
                    Total Utilidad
                </th>
                <td>".$total."</td>
            </tr>
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
$pdf->set_paper("letter", "landscape");
 
// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('reporteUtilidad_'.$fecha.'.pdf', array("Attachment" => false));