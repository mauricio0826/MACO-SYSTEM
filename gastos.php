<?php 
session_start();
	if(isset($_SESSION['usuario'])){
?>
	<!DOCTYPE html>
	<html>
	<head> 
		<meta charset="utf-8">
		<title>GASTOS</title>

		<?php require_once "menu.php"; ?>
		<?php require_once "../clases/Conexion.php"; 
		$c= new conectar();
		$conexion=$c->conexion();
		?>
	
<style>
	.container{
	margin: 0% 23%;
	}
</style>

</head>
<body>
<div class="container">
	<center>
		<h1 style="font-family: Arial Black;">GASTOS</h1>
	</center>

	<footer style="padding: 3%;"></footer>
		<div class="row">
			<div class="col-sm-4">
<form id="frmGastos">
			<label>EMPLEADO</label>
				<select class="form-control input-sm" id="usuarioG" name="usuarioG">
					<option value="" onkeyup="javascript:this.value=this.value.toUpperCase();">SELECCIONAR...</option>
						<?php
						$sql="SELECT id_usuario 
						from usuarios";
						$result=mysqli_query($conexion,$sql);
						while ($usuario=mysqli_fetch_row($result)):
						?>
					<option value="<?php echo $usuario[0]; ?>"><?php echo $usuario[0]; ?></option>
						<?php endwhile; ?>
				</select>
	<br>
			<label>TIPO GASTO </label>
				<input type="text" class="form-control input-sm" id="tipoG" name="tipoG" onkeyup="javascript:this.value=this.value.toUpperCase();">
	<br>
			<label>ORIGEN</label>
				<select class="form-control input-sm" id="origenSelect" name="origenSelect">
					<option value="A">SELECCIONAR...</option>
					<option value="B">NACIONAL</option>
					<option value="C">IMPORTADO</option>
				</select>
	<br>
			<label>VALOR</label>
				<input type="number" class="form-control input-sm" id="valorG" name="valorG">
	<br>
			<center>
				<span id="btnAgregarGastos" class="btn btn-primary">AGREGAR</span>
			</center>
</form>
	</div>
		<div class="col-sm-8">
			<div id="tablaGastosLoad"></div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="abremodalGastosUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
					</button>
		<h4 class="modal-title" id="myModalLabel">ACTUALIZAR GASTOS</h4>
				</div>
					<div class="modal-body">
						<form id="frmGastosU">
							<label>CÓDIGO GASTO</label>
								<input type="text" class="form-control input-sm" id="codigoGU" name="codigoGU" readonly="readonly" disabled="">
	<br>
							<label>TIPO GASTO</label>
								<input type="text" class="form-control input-sm" id="tipoGU" name="tipoGU" disabled="">
	<br>
							<label>ORIGEN</label>
								<select class="form-control input-sm" id="origenSelectU" name="origenSelectU" disabled="">
									<option value="A">SELECCIONAR...</option>
									<option value="B">NACIONAL</option>
									<option value="C">IMPORTADO</option>
								</select>
	<br>
							<label>VALOR</label>
								<input type="text" class="form-control input-sm" id="valorU" name="valorU">
</form>
	</div>
		<div class="modal-footer">
			<center>
				<button id="btnActualizarGastos" type="button" class="btn btn-primary" data-dismiss="modal">ACTUALIZAR
				</button>
			</center>
					</div>
				</div>
			</div>
		</div>
		
	<div class="modal fade" id="modalAutoGer" tabindex="-1" role="dialog" aria-labelledby="modalAutoGer">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
						<h4 class="modal-title">AUTORIZACIÓN GERENTE</h4>
				</div>
					<div class="modal-body">
						<form id="frmAutorizaGer">
							<label>Clave Gerente</label>
								<input type="password" class="form-control input-sm" id="claveGer" name="claveGer">
								<input type="text" style="display:none;" id="id_gasto" name="id_gasto">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAutoriza" type="button" class="btn btn-danger" data-dismiss="modal">ELIMINAR
						</button>
					</div>
				</div>
			</div>
		</div>		

</body>

<footer style="padding: 10%;">
</footer>

</html>

	<script type="text/javascript">
		function agregaDatosGastos(idgastos){
			$.ajax({
				type:"POST",
				data:"idgastos=" + idgastos,
				url:"../procesos/gastos/obtenDatosGastos.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#codigoGU').val(dato['id_codigoG']);
					$("#clienteU").val(dato['id_cliente']).trigger('change');
					$('#tipoGU').val(dato['tipoG']);
					$('#origenSelectU').val(dato['origenSelect']);
					$('#valorU').val(dato['valor']);
				}
			});
		}

		function eliminarGastos(idgastos){
			alertify.confirm('¿DESEAS ELIMINAR ESTE GASTO?', function(){
				$('#id_gasto').val(idgastos);
				$('#modalAutoGer').modal('show');
			}, function(){ 
				alertify.error('CANCELADO..!')
			});
		}
		
		$('#btnAutoriza').click(function(){
			var id_gasto = $('#id_gasto').val();
			var claveGer = $('#claveGer').val();

			$.ajax({
				type:"POST",
				data:"idgastos=" + id_gasto + "&claveGer=" + claveGer,
				url:"../procesos/gastos/eliminarGastos.php",
				success:function(r){
					if(r==1){
						$('#tablaGastosLoad').load("gastos/tablaGastos.php");
						alertify.success("ELIMINADO CON EXITO..!");
					}else{
						$('#claveGer').val('');
						alertify.error("FALLO..! ERROR DE AUTORIZACIÓN INCORRECTA");
					}
				}
			});
		});		
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tablaGastosLoad').load("gastos/tablaGastos.php");

			$('#btnAgregarGastos').click(function(){
				vacios=validarFormVacio('frmGastos');

				if(vacios > 0){
					alertify.alert("DEBES DE LLENAR TODOS LOS CAMPOS..!");
					return false;
				}

				datos=$('#frmGastos').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/gastos/agregarGastos.php",
					success:function(r){

						if(r==1){
							$('#frmGastos')[0].reset();
							$("#clienteG").val('').trigger('change');
							$('#tablaGastosLoad').load("gastos/tablaGastos.php");
							alertify.success("GASTO AGREGADO CON EXITO..!");
						}else{
							alertify.error("NO SE PUDO AGREGAR EL GASTO..!");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnActualizarGastos').click(function(){
				datos=$('#frmGastosU').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/gastos/actualizaGastos.php",
					success:function(r){

						if(r==1){
							$('#frmGastosU')[0].reset();
							$("#clienteU").val('').trigger('change');
							$('#tablaGastosLoad').load("gastos/tablaGastos.php");
							alertify.success("Gasto actualizado con exito");
						}else{
							alertify.error("NO SE PUDO ACTUALIZAR EL GASTO..!");
						}
					}
				});
			})
		})
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#clienteG').select2();
			$('#clienteU').select2();
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>