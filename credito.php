<?php  
session_start();
	if(isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>CREDITO</title>
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

<footer style="padding: 1%;"></footer>
	<div class="container">
		<center>
			<h1 style="font-family: Arial Black;">CRÉDITO</h1>
		</center>

<footer style="padding: 3%;"></footer>
	<div class="row">
		<div class="col-sm-4">
			<form id="frmCredito">
				<input type="radio" id="Tcliente" name="tipoCred" value="cliente" onchange="validarTipo()">
					<label for="Tcliente">CLIENTE</label>
						<input type="radio" id="Tproveedor" name="tipoCred" value="proveedor" onchange="validarTipo()">
					<label for="Tproveedor">PROVEEDOR</label><br>
						<div id="tipoC" style="display:none;">
	<br>
					<label>CLIENTE</label>
						<select class="form-control input-sm" id="clienteC" name="clienteC" style="width: 100%;">
							<option value="-99">SELECCIONAR...</option>
								<?php
								$sql="SELECT id_codigo,nombre,apellido 
								from clientes";
								$result=mysqli_query($conexion,$sql);
								while ($cliente=mysqli_fetch_row($result)):
									?>
							<option value="<?php echo $cliente[0]; ?>"><?php echo $cliente[1]." ".$cliente[2]; ?></option>
								<?php endwhile; ?>
						</select>
					</div>
	<br>
					<div id="tipoP" style="display:none;">
						<label>PROVEEDOR</label>
							<select class="form-control input-sm" id="proveedorC" name="proveedorC" style="width: 100%;">
								<option value="-99">SELECCIONAR...</option>
								<?php
								$sql="SELECT id_codigo,nombre,apellido 
								from proveedores";
								$result=mysqli_query($conexion,$sql);
								while ($prove=mysqli_fetch_row($result)):
									?>
								<option value="<?php echo $prove[0]; ?>"><?php echo $prove[1]." ".$prove[2]; ?></option>
								<?php endwhile; ?>
							</select>
					</div>

	<br>
						<label>TIPO CRÉDITO</label>
							<input type="text" class="form-control input-sm" id="tipoC" name="tipoC" onkeyup="javascript:this.value=this.value.toUpperCase();">
	<br>
						<label>ORIGEN</label>
							<select class="form-control input-sm" id="origenSelect" name="origenSelect">
								<option value="A">SELECCIONAR...</option>
								<option value="B">NACIONAL</option>
								<option value="C">IMPORTAR</option>
							</select>	
	<br>
						<label>VALOR</label>
							<input type="number" class="form-control input-sm" id="valorC" name="valorC">
	<p></p>
							<span id="btnAgregarCredito" class="btn btn-primary">AGREGAR</span>	
			</form>
				</div>
					<div class="col-sm-8">
						<div id="tablaCreditoLoad"></div>
					</div>
				</div>
			</div>

	<div class="modal fade" id="abremodalCreditoUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
						<h4 class="modal-title" id="myModalLabel">ACTUALIZAR CREDITO</h4>
				</div>
					<div class="modal-body">
						<form id="frmCreditoU">
							<label>Codigo Credito</label>
								<input type="text" class="form-control input-sm" id="codigoCU" name="codigoCU" readonly="readonly">
	<p></p>
								<input type="radio" id="TclienteU" name="tipoCredU" value="cliente" onchange="validarTipoU()">
									<label for="TclienteU">Cliente</label>
								<input type="radio" id="TproveedorU" name="tipoCredU" value="proveedor" onchange="validarTipoU()">
									<label for="TproveedorU">Proveedor</label><br>							
								<div id="tipoClU" style="display:none;">
									<label>Cliente</label>
										<select class="form-control input-sm" id="clienteU" name="clienteU" style="width: 100%;">
											<option value="-99">Selecciona...</option>
											<?php
											$sql="SELECT id_codigo,nombre,apellido 
											from clientes";
											$result=mysqli_query($conexion,$sql);
											while ($cliente=mysqli_fetch_row($result)):
												?>
											<option value="<?php echo $cliente[0]; ?>"><?php echo $cliente[2]." ".$cliente[1]; ?></option>
											<?php endwhile; ?>
										</select>
									</div>

	<div id="tipoPU" style="display:none;">
		<label>Proveedor</label>
			<select class="form-control input-sm" id="proveedorU" name="proveedorU" style="width: 100%;">
				<option value="-99">Selecciona...</option>
					<?php
					$sql="SELECT id_codigo,nombre,apellido 
					from proveedores";
					$result=mysqli_query($conexion,$sql);
					while ($prove=mysqli_fetch_row($result)):
					?>
				<option value="<?php echo $prove[0]; ?>"><?php echo $prove[2]." ".$prove[1]; ?>
				</option>
					<?php endwhile; ?>
			</select>
		</div>
	<p></p>
		<label>Tipo de Credito</label>
			<input type="text" class="form-control input-sm" id="tipoCU" name="tipoCU">
	<p></p>
		<label>Origen</label>
			<select class="form-control input-sm" id="origenSelectU" name="origenSelectU">
				<option value="A">Seleccione</option>
				<option value="B">Nacional</option>
				<option value="C">Importado</option>
			</select>	
	<p></p>
		<label>Valor</label>
			<input type="text" class="form-control input-sm" id="valorU" name="valorU">
</form>
	</div>
		<div class="modal-footer">
			<button id="btnAgregarCreditoU" type="button" class="btn btn-primary" data-dismiss="modal">ACTUALIZAR
			</button>

				</div>
			</div>
		</div>
	</div>
		
		<div class="modal fade" id="modalAutoGer" tabindex="-1" role="dialog" aria-labelledby="modalAutoGer">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">AUTORIZACIÓN GERENTE</h4>
					</div>
					<div class="modal-body">
						<form id="frmAutorizaGer">
							<label>Clave Gerente</label>
							<input type="password" class="form-control input-sm" id="claveGer" name="claveGer">
							<input type="text" style="display:none;" id="id_credito" name="id_credito">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAutoriza" type="button" class="btn btn-danger" data-dismiss="modal">ELIMINAR</button>
					</div>
				</div>
			</div>
		</div>		

	</body>

<footer style="padding: 10%;">
</footer>

	</html>

	<script type="text/javascript">
		function validarTipo(){
			let radio = $('input[name="tipoCred"]:checked').val();
			if(radio == 'cliente'){
				var tipoC = $('#tipoC');
				var tipoP = $('#tipoP');

				tipoC[0].style.display = 'block';
				tipoP[0].style.display = 'none';
			}else if(radio == 'proveedor'){
				var tipoC = $('#tipoC');
				var tipoP = $('#tipoP');

				tipoC[0].style.display = 'none';
				tipoP[0].style.display = 'block';
			}
		}

		function validarTipoU(){
			let radio = $('input[name="tipoCredU"]:checked').val();
			if(radio == 'cliente'){
				var tipoC = $('#tipoClU');
				var tipoP = $('#tipoPU');

				tipoC[0].style.display = 'block';
				tipoP[0].style.display = 'none';
			}else if(radio == 'proveedor'){
				var tipoC = $('#tipoClU');
				var tipoP = $('#tipoPU');

				tipoC[0].style.display = 'none';
				tipoP[0].style.display = 'block';
			}
		}		

		function agregaDatosCredito(idcredito){

			$.ajax({
				type:"POST",
				data:"idcredito=" + idcredito,
				url:"../procesos/credito/obtenDatosCredito.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#codigoCU').val(dato['id_CodigoC']);					
					$('#tipoCU').val(dato['tipoC']);
					$('#origenSelectU').val(dato['origenSelect']);
					$('#valorU').val(dato['valor']);

					if(dato['tipo_cliente'] == 'cliente'){
						document.querySelector('#TclienteU').checked = true;
						$("#clienteU").val(dato['id_cliente']).trigger('change');
					}else if(dato['tipo_cliente'] == 'proveedor'){
						$("#proveedorU").val(dato['id_cliente']).trigger('change');
						document.querySelector('#TproveedorU').checked = true;
					}
					validarTipoU();
				}
			});
		}

		function eliminarCredito(idcredito){
			alertify.confirm('¿DESEAS ELIMINAR ESTE CREDITO?', function(){ 
				$('#id_credito').val(idcredito);
				$('#modalAutoGer').modal('show');
			}, function(){ 
				alertify.error('CANCELADO!')
			});
		}
		
		$('#btnAutoriza').click(function(){
			var id_credito = $('#id_credito').val();
			var claveGer = $('#claveGer').val();

			$.ajax({
				type:"POST",
				data:"idcredito=" + id_credito + "&claveGer=" + claveGer,
				url:"../procesos/credito/eliminarCredito.php",
				success:function(r){
					if(r==1){
						$('#tablaCreditoLoad').load("credito/tablaCredito.php");
						alertify.success("ELIMINADO CON EXITO!!");
					}else{
						$('#claveGer').val('');
						alertify.error("NO SE PUDO ELIMINAR, AUTORIZACIÓN INCORRECTA");
					}
				}
			});
		});		
	</script>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#tablaCreditoLoad').load("credito/tablaCredito.php");

			$('#btnAgregarCredito').click(function(){

				vacios=validarFormVacio('frmCredito');

				if(vacios > 0){
					alertify.alert("DEBES DE LLENAR TODOS LOS CAMPOS!!");
					return false;
				}

				datos=$('#frmCredito').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/credito/agregaCredito.php",
					success:function(r){

						if(r==1){
							$('#frmCredito')[0].reset();							
							$("#clienteC").val('').trigger('change');
							$("#proveedorC").val('').trigger('change');
							var tipoC = $('#tipoC');
							var tipoP = $('#tipoP');
							tipoC[0].style.display = 'none';
							tipoP[0].style.display = 'none';
							$('#tablaCreditoLoad').load("credito/tablaCredito.php");
							alertify.success("CREDITO AGREGADO CON EXITO!");
						}else{
							alertify.error("NO SE PUDO AGREGAR EL CREDITO");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAgregarCreditoU').click(function(){
				datos=$('#frmCreditoU').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/credito/actualizaCredito.php",
					success:function(r){

						if(r==1){
							$('#frmCreditoU')[0].reset();
							$("#clienteU").val('').trigger('change');
							$("#proveedorU").val('').trigger('change');
							var tipoC = $('#tipoClU');
							var tipoP = $('#tipoPU');
							tipoC[0].style.display = 'none';
							tipoP[0].style.display = 'none';							
							$('#tablaCreditoLoad').load("credito/tablaCredito.php");
							alertify.success("Credito actualizado con exito");
						}else{
							alertify.error("NO SE PUDO ACTUALIZAR EL CREDITO");
						}
					}
				});
			})
		})
	</script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#clienteC').select2();
			$('#clienteU').select2();
			$('#proveedorC').select2();
			$('#proveedorU').select2();			
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>