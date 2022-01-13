<?php  

	require_once "../../clases/Conexion.php";

	$start = $_GET['start'];
	$end = $_GET['end'];
	$articulo = isset($_GET['articulo']) ? $_GET['articulo'] : null;

	$c= new conectar();
	$conexion=$c->conexion();

	$sql="
		SELECT 
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
		articulos art
		WHERE art.fechaCaptura
		BETWEEN '".$start."' AND '".$end."'
	GROUP BY art.id_producto,art.fechaCaptura";
	$result=mysqli_query($conexion,$sql);
?>

<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				<tr>
					<td>Articulo</td>
					<td>Cantidad</td>
					<td>Precio</td>
					<td>Fecha Ingreso</td>
					<td>Tipo</td>
				</tr>

				<?php while($ver=mysqli_fetch_row($result)): ?>
				<tr>
					<td><?php echo $ver[2] ?></td>
					<td><?php echo $ver[3] ?></td>
					<td>$<?php echo $ver[4] ?></td>
					<td><?php echo $ver[6] ?></td>
					<td><?php echo $ver[5] ?></td>
				</tr>
				<?php endwhile; ?>

			</table>
		</div>
	</div>
</div>