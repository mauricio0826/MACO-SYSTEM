<?php 
session_start();
if(isset($_SESSION['usuario'])){

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>CLIENTES</title>
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
		
		<?php require_once "menu.php"; ?>

<style>
	 .container{
	 	margin: 0% 23%;
	 }
</style>

	</head>
	<body>

<div class="container">
			<center><h1 style="font-family: Arial Black;">CLIENTES</h1></center>

<footer style="padding: 3%;"></footer>	

			<div class="row">
				<div class="col-sm-4">
					<form id="frmClientes">
						<label>Cedula</label>
						<input type="number" class="form-control input-sm" id="codigo" name="codigo">
						<label>Nombre</label>
						<input type="text" class="form-control input-sm" id="nombre" name="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<label>Apellido</label>
						<input type="text" class="form-control input-sm" id="apellido" name="apellido" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<label>Direccion</label>
						<input type="text" class="form-control input-sm" id="direccion" name="direccion" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<label>Departamento</label>
						<input type="text" class="form-control input-sm" id="departamento" name="departamento" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<label>Ciudad</label>
						<input type="text" class="form-control input-sm" id="ciudad" name="ciudad" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<label>Telefono</label>
						<input type="number" class="form-control input-sm" id="telefono" name="telefono">
						<label>Razon Social (local)</label>
						<input type="text" class="form-control input-sm" id="razonsocial" name="razonsocial" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<p></p>
						<span class="btn btn-primary" id="btnAgregarCliente">AGREGAR</span>
					</form>
				</div>
				<div class="col-sm-8">
					<div id="tablaClientesLoad"></div>
				</div>
			</div>
		</div>

		<!-- Button trigger modal -->


		<!-- Modal -->
		<div class="modal fade" id="abremodalClientesUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">ACTUALIZAR CLIENTES</h4>
					</div>
					<div class="modal-body">
						<form id="frmClientesUPD">
							<label>Codigo (cedula)</label>
							<input type="text" class="form-control input-sm" id="codigoU" name="codigoU" readonly="readonly">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
							<label>Apellido</label>
							<input type="text" class="form-control input-sm" id="apellidoU" name="apellidoU">
							<label>Direccion</label>
							<input type="text" class="form-control input-sm" id="direccionU" name="direccionU">
							<label>Departamento</label>
							<input type="text" class="form-control input-sm" id="departamentoU" name="departamentoU">
							<label>Ciudad</label>
							<input type="text" class="form-control input-sm" id="ciudadU" name="ciudadU">
							<label>Telefono</label>
							<input type="text" class="form-control input-sm" id="telefonoU" name="telefonoU">
							<label>Razon Social (local)</label>
							<input type="text" class="form-control input-sm" id="razonsocialU" name="razonsocialU">
						</form>
					</div>
					<div class="modal-footer">
						<button id="btnAgregarClienteU" type="button" class="btn btn-primary" data-dismiss="modal">ACTUALIZAR</button>
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
							<input type="text" style="display:none;" id="id_cliente" name="id_cliente">
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
		function obtenDatosCliente(idcliente){

			$.ajax({
				type:"POST",
				data:"idcliente=" + idcliente,
				url:"../procesos/clientes/obtenDatosCliente.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#codigoU').val(dato['id_codigo']);
					$('#nombreU').val(dato['nombre']);
					$('#apellidoU').val(dato['apellido']);
					$('#direccionU').val(dato['direccion']);
					$('#departamentoU').val(dato['departamento']);
					$('#ciudadU').val(dato['ciudad']);
					$('#telefonoU').val(dato['telefono']);
					$('#razonsocialU').val(dato['razonsocial']);

				}
			});
		}

		function eliminarCliente(idcliente){
			alertify.confirm('¿DESEAS ELIMINAR ESTE CLIENTE?', function(){
				$('#id_cliente').val(idcliente);
				$('#modalAutoGer').modal('show');
			}, function(){ 
				alertify.error('CANCELADO!')
			});
		}

		$('#btnAutoriza').click(function(){
			var id_cliente = $('#id_cliente').val();
			var claveGer = $('#claveGer').val();

			$.ajax({
				type:"POST",
				data:"idcliente=" + id_cliente + "&claveGer=" + claveGer,
				url:"../procesos/clientes/eliminarCliente.php",
				success:function(r){
					if(r==1){
						$('#tablaClientesLoad').load("clientes/tablaClientes.php");
						alertify.success("ELIMINADO CON EXITO!!");
						$('#claveGer').val('');
						$('#id_cliente').val('');						
					}else{
						alertify.error("NO SE PUDO ELIMINAR");
						$('#claveGer').val('');
						$('#id_cliente').val('');
					}
				}
			});
		});		
	</script>

	<script type="text/javascript">
		$(document).ready(function(){

			$('#tablaClientesLoad').load("clientes/tablaClientes.php");

			$('#btnAgregarCliente').click(function(){

				vacios=validarFormVacio('frmClientes');

				if(vacios > 0){
					alertify.alert("DEBES DE LLENAR TODOS LOS CAMPOS!!");
					return false;
				}

				datos=$('#frmClientes').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/clientes/agregaCliente.php",
					success:function(r){

						if(r==1){
							$('#frmClientes')[0].reset();
							$('#tablaClientesLoad').load("clientes/tablaClientes.php");
							alertify.success("CLIENTE AGREGADO CON EXITO!");
						}else{
							alertify.error("NO SE PUDO AGREGAR AL CLIENTE");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnAgregarClienteU').click(function(e){
				e.preventDefault();
				var datos=$('#frmClientesUPD').serialize();

				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/clientes/actualizaCliente.php",
					success:function(r){

						if(r==1){
							$('#frmClientes')[0].reset();
							$('#tablaClientesLoad').load("clientes/tablaClientes.php");
							alertify.success("Cliente actualizado con exito");
						}else{
							alertify.error("NO SE PUDO ACTUALIZAR EL CLIENTE");
						}
					}
				});
			})
		})
	</script>


	<?php 
}else{
	header("location:../index.php");
}
?>