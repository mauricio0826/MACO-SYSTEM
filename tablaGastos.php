<?php   
	require_once "../../clases/Conexion.php";
 
	$obj= new conectar();
	$conexion= $obj->conexion();

	$sql="SELECT gas.id_codigoG, 
				 COALESCE((select CONCAT(usu.nombre,' ',usu.apellido) from usuarios usu where usu.id_usuario = gas.id_cliente),gas.id_cliente) usuarios,
				 gas.tipoG,
				 gas.origenSelect,
				 gas.valor 
		  FROM  gastos gas";
	$result=mysqli_query($conexion,$sql);
 ?>

<div class="table-responsive">
	 <table class="table table-hover table-condensed table-bordered" style="text-align: center;">
	 	<center><h3>GASTOS</h3></center>
	 	<br>
	 	<br>
	 	<tr>
	 		<!--<td>FECHA</td>-->
	 		<td>EMPLEADO</td>
	 		<td>TIPO GASTO</td>
	 		<td>ORIGEN</td>
	 		<td>VALOR</td>
			<td>EDITAR</td>
			<td>ELIMINAR</td>
	 	</tr>

 	 	<?php while($ver=mysqli_fetch_row($result)): ?>

	 	<tr>
	 		<!--<td><?php echo $ver[0]; ?></td>-->
	 		<td><?php echo $ver[1]; ?></td>
	 		<td><?php echo $ver[2]; ?></td>
	 		<td><?php if($ver[3] == 'B'){ echo 'Nacional'; }else if($ver[3] == 'C'){ echo 'Importado'; }; ?></td>
			<td><?php echo $ver[4]; ?></td>	 		
	 		<td>
				<span class="btn btn-warning btn-xs" data-toggle="modal" data-target="#abremodalGastosUpdate" onclick="agregaDatosGastos('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-pencil"></span>
				</span>
			</td>
			<td>
				<span class="btn btn-danger btn-xs" onclick="eliminarGastos('<?php echo $ver[0]; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
	 	</tr>
	 <?php endwhile; ?>
	 </table>
</div>