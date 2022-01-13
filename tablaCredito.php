<?php   
	require_once "../../clases/Conexion.php";

	$obj= new conectar();
	$conexion= $obj->conexion();

	$sql="SELECT cre.id_CodigoC, 
				 COALESCE((select CONCAT(cli.nombre,' ',cli.apellido) from clientes cli where cli.id_codigo = cre.id_cliente),cre.id_cliente) cliente,
				 COALESCE((select CONCAT(pro.nombre,' ',pro.apellido) from proveedores pro where pro.id_codigo = cre.id_cliente),cre.id_cliente) proveedor,
				 cre.tipoC,
				 cre.origenSelect,
				 cre.valor,
				 cre.tipo_cliente
		from credito cre";
		
	$result=mysqli_query($conexion,$sql);
 ?>

<div class="table-responsive">
	 <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	 	<center><h3>CRÉDITOS</h3></center>
	 	<br>
	 	<br>
	 	<tr>
	 		<td>CLIENTE / PROVEEDOR</td>
	 		<td>TIPO CRÉDITO</td>
	 		<td>ORIGEN</td>
	 		<td>VALOR</td>
			<td>Editar</td>
			<td>Eliminar</td>			
	 	</tr>

	 	<?php while($ver=mysqli_fetch_row($result)): ?>

	 	<tr>
	 		<td><?php if($ver[6] == 'cliente'){ echo $ver[1]; }else if($ver[6] == 'proveedor'){ echo $ver[2]; }; ?></td>
	 		<td><?php echo $ver[3]; ?></td>
	 		<td><?php if($ver[4] == 'B'){ echo 'Nacional'; }else if($ver[4] == 'C'){ echo 'Importado'; }; ?></td>
	 		<td><?php echo $ver[5]; ?></td>
	 		
	 		<td>
				<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalCreditoUpdate" onclick="agregaDatosCredito('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-pencil"></span>
				</span>
			</td>
			<td>
				<span class="btn btn-danger btn-xs" onclick="eliminarCredito('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
	 	</tr>
	 <?php endwhile; ?>
	 </table>
</div>