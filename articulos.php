<?php  
session_start();
	isset($_SESSION['rol']) ? $id_rol = $_SESSION['rol'] : $id_rol = null;
	if(isset($_SESSION['usuario'])){
?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="utf-8">
		<title>INVENTRARIO</title>
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
		<center><h1 style="font-family: Arial Black;">INVENTARIO</h1></center>

<footer style="padding: 3%;"></footer>	

			<div class="row">
				<div class="col-sm-4">
					<form id="frmArticulos" enctype="multipart/form-data">

						<label>CÓDIGO</label>
							<input type="text" class="form-control input-sm" id="codigo" name="codigo" onkeyup="javascript:this.value=this.value.toUpperCase();">
<br>
						<label>NOMBRE</label>
							<input type="text" class="form-control input-sm" id="nombre" name="nombre" onkeyup="javascript:this.value=this.value.toUpperCase();">
<br>
						<label>CANTIDAD</label>
							<input type="number" class="form-control input-sm" id="cantidad" name="cantidad" onkeyup="javascript:this.value=this.value.toUpperCase();">
						<?php if($id_rol == 99){ ?>
<br>
						<label>PRECIO</label>
						<?php } ?>
							<input type="<?php echo $id_rol == 99 ? "number":"hidden"?>" class="form-control input-sm" id="precio" name="precio" value=0 onkeyup="javascript:this.value=this.value.toUpperCase();">
<br>
						<label>ORIGEN</label>
							<select class="form-control input-sm" id="origenSelect" name="origenSelect" onkeyup="javascript:this.value=this.value.toUpperCase();">
								<option value="A">SELECCIONE ORIGEN...</option>
								<option value="B">NACIONAL</option>
								<option value="C">IMPORTADO</option>
							</select>
<br>
<br>
						<center>
							<span id="btnAgregaArticulo" class="btn btn-primary">AGREGAR</span>
						</center>
					</form>
				</div>
					<div class="col-sm-8">
						<div id="tablaArticulosLoad">
							</div>
					</div>
				</div>
			</div>

		<div class="modal fade" id="abremodalUpdateArticulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel">ACTUALIZAR ARTICULOS</h4>
					</div>
					<div class="modal-body">
						<form id="frmArticulosU" enctype="multipart/form-data">
							<label>CÓDIGO</label>
							<input type="text" class="form-control input-sm" id="codigoU" name="codigoU" readonly="readonly">
<br>
							<label>NOMBRE</label>
							<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
<br>
							<label>CANTIDAD</label>
							<input type="text" class="form-control input-sm" id="cantidadU" name="cantidadU">
							<?php if($id_rol == 99){ ?>
<br>
							<label>PRECIO</label>
							<?php } ?>
							<input type="<?php echo $id_rol == 99 ? "text":"hidden"?>" class="form-control input-sm" id="precioU" name="precioU">
<br>
							<label>ORIGEN</label>
							<select class="form-control input-sm" id="origenSelectU" name="origenSelectU">
								<option value="A">SELECCIONE ORIGEN...</option>
								<option value="B">NACIONAL</option>
								<option value="C">IMPORTADO</option>
							</select>							
						</form>
					</div>
					<div class="modal-footer">
						<center><button id="btnActualizaarticulo" type="button" class="btn btn-warning" data-dismiss="modal">ACTUALIZAR</button></center>

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
							<input type="text" style="display:none;" id="id_articulo" name="id_articulo">
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
		function agregaDatosArticulo(idarticulo){
			$.ajax({
				type:"POST",
				data:"idart=" + idarticulo,
				url:"../procesos/articulos/obtenDatosArticulo.php",
				success:function(r){
					
					dato=jQuery.parseJSON(r);
					$('#codigoU').val(dato['id_producto']);
					$('#nombreU').val(dato['nombre']);
					$('#cantidadU').val(dato['cantidad']);
					$('#precioU').val(dato['precio']);
					$('#origenSelectU').val(dato['origen']);

				}
			});
		}

		function eliminaArticulo(idArticulo){
			alertify.confirm('¿DESEAS ELIMINAR ESTE ARTICULO?', function(){ 
				$('#id_articulo').val(idArticulo);
				$('#modalAutoGer').modal('show');
			}, function(){ 
				alertify.error('CANCELADO !')
			});
		}

		$('#btnAutoriza').click(function(){
			var id_articulo = $('#id_articulo').val();
			var claveGer = $('#claveGer').val();

			$.ajax({
				type:"POST",
				data:"idarticulo=" + id_articulo + "&claveGer=" + claveGer,
				url:"../procesos/articulos/eliminarArticulo.php",
				success:function(r){
					if(r==1){
						$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
						alertify.success("Eliminado con exito!!");
						$('#claveGer').val('');
						$('#id_articulo').val('');
					}else{
						alertify.error("FALLO AL ELIMINAR");
						$('#claveGer').val('');
						$('#id_articulo').val('');
					}
				}
			});
		});			
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnActualizaarticulo').click(function(){

				datos=$('#frmArticulosU').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url:"../procesos/articulos/actualizarArticulos.php",
					success:function(r){
						if(r==1){
							$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
							alertify.success("ACTUALIZADO CON EXITO");
						}else{
							alertify.error("ERROR AL ACTUALIZAR");
						}
					}
				});
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");

			$('#btnAgregaArticulo').click(function(){

				vacios=validarFormVacio('frmArticulos');

				if(vacios > 0){
					alertify.alert("DEBES DE LLENAR TODOS LOS CAMPOS!!");
					return false;
				}

				datos=$('#frmArticulos').serialize();
				$.ajax({
					type:"POST",
					data:datos,
					url: "../procesos/articulos/insertaArticulos.php",
					success:function(r){
						if(r == 1){
							$('#frmArticulos')[0].reset();
							$('#tablaArticulosLoad').load("articulos/tablaArticulos.php");
							alertify.success("AGREGADO CON EXITO!");
						}else{
							alertify.error("FALLO AL REGISTRAR");
						}
					}
				});
			});
		});
	</script>

	<?php 
}else{
	header("location:../index.php");
}
?>