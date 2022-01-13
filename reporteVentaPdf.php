<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";

	$objv= new ventas();


	$c=new conectar();
	$conexion= $c->conexion();	
	$idventa=$_GET['idventa'];

 $sql="SELECT ven.id_venta,COALESCE((select cli.nombre from clientes cli where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, ven.fechaCompra
          FROM VENTAS ven
		  WHERE ven.id_venta='$idventa'";

$result=mysqli_query($conexion,$sql);

	$ver=mysqli_fetch_row($result);

	$codigo=$ver[0];
	$fecha=$ver[2];
	$idcliente=$ver[1];
	
	if($idcliente == 'A'){ 
		$cliente = 'Contado';
	}else if($idcliente == '0'){ 
		$cliente = $idcliente;
	}else{ 
		$cliente = $idcliente;
	}	

 ?>	

 <!DOCTYPE html>
 <html>
 <head>
 	<title>REPORTE DE VENTA</title>
 	<link rel="stylesheet" type="text/css" href="../../librerias/bootstrap/css/bootstrap.css">
 </head>
 <body>
 		<img src="../img/maco.png" width="200" height="200">
 		<br>
 		<table class="table">
 			<tr>
 				<td>Fechac: <?php echo $fecha; ?></td>
 			</tr>
 			<tr>
 				<td>Folio: <?php echo $codigo ?></td>
 			</tr>
 			<tr>
 				<td>cliente: <?php echo $cliente; ?></td>
 			</tr>
 		</table>


 		<table class="table">
 			<tr>
 				<td>ARTICULO</td>
 				<td>CANTIDAD</td>
 				<td>VALOR</td>
 				<td>TOTAL</td>
 			</tr>

 			<?php 
 			$sql="	SELECT art.nombre, ven.cantidad, ven.precio, ven.total
					FROM VENTAS ven
					INNER JOIN articulos art on art.id_producto = ven.id_producto
					WHERE ven.id_venta='$idventa'";

			$result=mysqli_query($conexion,$sql);
			$total=0;
			while($ver=mysqli_fetch_row($result)):
 			 ?>

 			<tr>
 				<td><?php echo $ver[0]; ?></td>
 				<td><?php echo $ver[1]; ?></td>
 				<td><?php echo $ver[2]; ?></td>
 				<td><?php echo $ver[3]; ?></td>
 			</tr>
 			<?php 
 				$total=$total + $ver[3];
 			endwhile;
 			 ?>
 			 <tr>
 			 	<td colspan="4">Total Venta: <?php echo "$".$total; ?></td>
 			 </tr>
 		</table>
 </body>
 </html>