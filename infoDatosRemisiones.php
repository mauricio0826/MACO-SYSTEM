<?php 

	require_once "../../clases/Conexion.php";

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
	
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				
				<tr>
					<td>Codigo</td>
					<td>Cliente</td>
					<td>Articulo</td>
					<td>Total de compra</td>
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