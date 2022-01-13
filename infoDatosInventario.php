<?php 

	require_once "../../clases/Conexion.php";

	$c= new conectar();
	$conexion=$c->conexion();
	$fecha_inicial 	= $_GET['start'];
	$fecha_final 	= $_GET['end'];
	$sql="SELECT ven.id_venta,COALESCE(
		(select cli.nombre from clientes cli 
				where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, 
		art.nombre, 
		ven.total 
		FROM VENTAS ven 
		INNER JOIN articulos art on art.id_producto = ven.id_producto
		WHERE ven.fechaCompra BETWEEN '".$fecha_inicial."' AND '".$fecha_final."'";
	$result=mysqli_query($conexion,$sql);
	
	?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				
				<tr>
					<td>CÓDIGO</td>
					<td>CLIENTE</td>
					<td>ARTICULO</td>
					<td>TOTAL DE VENTA</td>
				</tr>
		<?php while($ver=mysqli_fetch_row($result)): ?>
				<tr>
					<td><?php echo $ver[0] ?></td>
					<td><?php if($ver[1] == 'A'){ echo 'Contado'; }else if($ver[1] == '0'){ echo 'Credito'; }else{ echo $ver[1]; } ?></td>
					<td><?php echo $ver[2] ?></td>
					<td><?php echo $ver[3] ?></td>
				</tr>
				
		<?php endwhile; ?>
			</table>
		</div>
	</div>
</div>
