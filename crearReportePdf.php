<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once '../../librerias/dompdf/autoload.inc.php';
require_once "../../clases/Conexion.php";
use Dompdf\Dompdf;

$fecha=date('d-m-Y');
$idventa=$_GET['idventa'];
$c=new conectar();
$conexion= $c->conexion();

if($idventa == "*"){
   $sql = "SELECT ven.id_venta,COALESCE((select cli.nombre from clientes cli where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, ven.fechaCompra FROM VENTAS ven ORDER BY ven.id_venta DESC";
}else{
    $sql = "SELECT ven.id_venta,COALESCE((select cli.nombre from clientes cli where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, ven.fechaCompra FROM VENTAS ven WHERE ven.id_venta=$idventa";
}

$result=mysqli_query($conexion,$sql);
$ver=mysqli_fetch_row($result);

$codigo=$ver[0];
$fecha=$ver[2];
$idcliente=$ver[1];
$total = 0;

if($idcliente == 'A'){ 
    $cliente = 'Contado';
}else if($idcliente == '0'){ 
    $cliente = 'Credito';
}else{ 
    $cliente = $idcliente;
}
if($idventa == "*" ){
    $sql2 = "SELECT art.nombre, ven.cantidad, ven.precio, ven.total FROM VENTAS ven INNER JOIN articulos art on art.id_producto = ven.id_producto order by ven.id_venta DESC";
}else{
    $sql2= "SELECT art.nombre, ven.cantidad, ven.precio, ven.total, tipo_venta FROM VENTAS ven INNER JOIN articulos art on art.id_producto = ven.id_producto WHERE ven.id_venta=$idventa";
}
$result2=mysqli_query($conexion,$sql2);

$html="<html>
<head>
    <title>REPORTE DE REMISIÓN</title>
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
                <th>N°: ".$codigo."</th>
            </tr>
            <tr>
                <th>cliente: ".$cliente."</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class='table table-striped table-bordered table-hover'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col'>TIPO</th>
                <th scope='col'>ARTICULO</th>
                <th scope='col'>CANTIDAD</th>
                <th scope='col'>VALOR</th>
                <th scope='col'>TOTAL</th>
            </tr>
        </thead>
        <tbody>";

        while($datos=mysqli_fetch_row($result2)):
            $html = $html."<tr>
                <td>".$datos[4]."</td>
                <td>".$datos[0]."</td>
                <td>".$datos[1]."</td>
                <td>$".$datos[2]."</td>
                <td>$".$datos[3]."</td>
            </tr>";
        $total = $total + $datos[3];
        endwhile;            
        
        $html = $html."<tr>
            <td colspan='4'>Total Venta: $".$total."</td>
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
$pdf->stream('reporteVenta_'.$fecha.'.pdf', array("Attachment" => false));