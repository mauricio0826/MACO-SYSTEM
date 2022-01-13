<?php  
	require_once "../../clases/Conexion.php";

	$obj= new conectar();
	$conexion= $obj->conexion();

	$sql="SELECT id_codigo, 
				nombre,
				apellido,
				direccion,
				telefono,
				razonsocial
		from proveedores";
	$result=mysqli_query($conexion,$sql);
 ?>

<div class="table-responsive">
	 <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	 	<center><h3>Proveedor</h3></center>
	 	<tr>
	 		<td>NOMBRE</td>
	 		<td>APELLIDO</td>
	 		<td>DIRECCIÓN</td>
	 		<td>TELÉFONO</td>
	 		<td>RAZÓN SOCIAL</td>
	 		<td>Editar</td>
	 		<td>Eliminar</td>
	 	</tr>

	 	<?php while($ver=mysqli_fetch_row($result)): ?>

	 	<tr>
	 		<td><?php echo $ver[1]; ?></td>
	 		<td><?php echo $ver[2]; ?></td>
	 		<td><?php echo $ver[3]; ?></td>
	 		<td><?php echo $ver[4]; ?></td>
	 		<td><?php echo $ver[5]; ?></td>
	 		
	 		<td>
				<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalPagoUpdate" onclick="obtenDatosPago('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-pencil"></span>
				</span>
			</td>
			<td>
				<span class="btn btn-danger btn-xs" onclick="eliminarPago('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
	 	</tr>
	 <?php endwhile; ?>
	 </table>
</div>