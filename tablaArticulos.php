<?php
	session_start();
	isset($_SESSION['rol']) ? $id_rol = $_SESSION['rol'] : $id_rol = null;
	require_once "../../clases/Conexion.php";
	$c= new conectar();
	$conexion=$c->conexion();
	$sql="SELECT art.fechaCaptura, art.id_producto, art.nombre, art.cantidad, art.precio, art.origen from articulos as art ";
	$result=mysqli_query($conexion,$sql);

 ?>

<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	<caption><label>Articulos</label></caption>
	<tr>
		<td>FECHA</td>
		<td>CÓDIGO</td>
		<td>NOMBRE PRODUCTO</td>
		<td>CANTIDAD</td>
		<?php if($id_rol == 99){ ?>
		<td>PRECIO</td>
		<?php } ?>
		<td>ORIGEN</td>
		<td>Editar</td>
		<td>Eliminar</td>
	</tr>

	<?php while($ver=mysqli_fetch_row($result)): ?>

		<td><?php echo $ver[0]; ?></td>
		<td><?php echo $ver[1]; ?></td>
		<td><?php echo $ver[2]; ?></td>
		<td><?php echo $ver[3]; ?></td>
		<?php if($id_rol == 99){ ?>
		<td><?php echo $ver[4]; ?></td>
		<?php } ?>
		<td><?php if($ver[5] == 'B'){ echo 'Nacional'; }else if($ver[5] == 'C'){ echo 'Importado'; };?></td>
		
		<td>
			<span  data-toggle="modal" data-target="#abremodalUpdateArticulo" class="btn btn-warning btn-xs" onclick="agregaDatosArticulo('<?php echo $ver[1] ?>')">
				<span class="glyphicon glyphicon-pencil"></span>
			</span>
		</td>
		<td>
			<span class="btn btn-danger btn-xs" onclick="eliminaArticulo('<?php echo $ver[1] ?>')">
				<span class="glyphicon glyphicon-remove"></span>
			</span>
		</td> 
	</tr>
<?php endwhile; ?>
</table>