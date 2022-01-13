<?php   
	require_once "../../clases/Conexion.php";

	$obj= new conectar();
	$conexion= $obj->conexion();

	$sql="SELECT rec.id_codigoR, 
	COALESCE(
		(select CONCAT(cli.nombre,' ',cli.apellido) from clientes cli where cli.id_codigo = rec.id_cliente),
		(SELECT CONCAT(pro.nombre,'',pro.apellido) FROM proveedores pro where pro.id_codigo =  rec.id_cliente)
	) cliente,
	rec.tipoR,
	rec.origenSelect,
	rec.valor
		FROM recaudo rec ORDER BY rec.id_codigoR DESC";
		
	$result=mysqli_query($conexion,$sql);
 ?>

<div class="table-responsive">
	 <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	 	<center><h3>RECAUDO</h3></center>
	 	<br>
	 	<tr>
	 		<td>CLIENTE</td>
	 		<td>RECAUDO POR</td>
	 		<td>ORIGEN</td>
	 		<td>VALOR</td>
			<td>Editar</td>
			<td>Eliminar</td>
	 	</tr>

	 	<?php while($ver=mysqli_fetch_row($result)): ?>

	 	<tr>
	 		<td><?php echo $ver[1]; ?></td>
	 		<td><?php echo $ver[2]; ?></td>
	 		<td><?php if($ver[3] == 'B'){ echo 'Nacional'; }else if($ver[3] == 'C'){ echo 'Importado'; }; ?></td>
	 		<td><?php echo $ver[4]; ?></td>
	 		
	 		<td>
				<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalRecaudoUpdate" onclick="agregaDatosCredito('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-pencil"></span>
				</span>
			</td>
			<td>
				<span class="btn btn-danger btn-xs" onclick="eliminarRecaudo('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
	 	</tr>
	 <?php endwhile; ?>
	 </table>
</div>