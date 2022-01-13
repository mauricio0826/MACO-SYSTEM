<?php
	require_once "../../clases/Conexion.php";

	$start = $_GET['start'];
	$end = $_GET['end'];
	$articulo = isset($_GET['articulo']) ? $_GET['articulo'] : null;

	$c= new conectar();
	$conexion=$c->conexion();

	$sql="SELECT art.nombre, ven.fechaCompra, ven.cantidad, ven.precio, ven.total
          FROM VENTAS ven
		  INNER JOIN articulos art on art.id_producto = ven.id_producto WHERE ven.fechaCompra BETWEEN '".$start."' AND '".$end."'";
	if($articulo != null){
		$sql = $sql." and ven.id_producto = ".$articulo;
	}	

	$result=mysqli_query($conexion,$sql); 
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				
				<tr>
					<td>Articulo</td>
					<td>Fecha</td>
					<td>Cantidad</td>
					<td>Precio</td>
					<td>Total</td>
				</tr>

				<?php while($ver=mysqli_fetch_row($result)): ?>
				<tr>
					<td><?php echo $ver[0] ?></td>
					<td><?php echo $ver[1] ?></td>
					<td><?php echo $ver[2] ?></td>
					<td><?php echo $ver[3] ?></td>
					<td><?php echo $ver[4] ?></td>
				</tr>
				<?php endwhile; ?>

			</table>
		</div>
	</div>
</div>