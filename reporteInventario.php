<?php 

require_once "../../clases/Conexion.php";
$c= new conectar();
$conexion=$c->conexion();
?>


<h4>VENDER PRODUCTO</h4>
<div class="row">
	<div class="col-sm-4">
		<form id="frmVentasProductos">
			<label>TIPO DE VENTA</label>
			<select class="form-control input-sm" id="clienteVenta" name="clienteVenta">
				<option value="">Selecciona...</option>
				<option value="A">Contado</option>
				<option value="0">Credito</option>
				<?php
				$sql="SELECT id_codigo,nombre,apellido 
				from clientes";
				$result=mysqli_query($conexion,$sql);
				while ($cliente=mysqli_fetch_row($result)):
					?>
					<option value="<?php echo $cliente[0] ?>"><?php echo $cliente[2]." ".$cliente[1] ?></option>
				<?php endwhile; ?>
			</select>
			<p></p>
			
				<label>Articulo</label>
			<input type="text" class="form-control input-sm" id="cantidadV" name="cantidadV">
			<label>Cantidad</label>
			<input type="text" class="form-control input-sm" id="cantidadV" name="cantidadV">
			<label>Sub Total</label>
			<input type="text" class="form-control input-sm" id="StotalV" name="StotalV">
			<p></p>
			<span class="btn btn-primary" id="btnAgregaVenta">Agregar</span>
		</form>
	</div>
	<div class="col-sm-3">
	</div>
	<div class="col-sm-4">
		<div id="tablaVentasTempLoad"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");

		$('#productoVenta').change(function(){
			$.ajax({
				type:"POST",
				data:"idproducto=" + $('#productoVenta').val(),
				url:"../procesos/ventas/llenarFormProducto.php",
				success:function(r){
					dato=jQuery.parseJSON(r);

					$('#cantidadV').val(dato['cantidad']);
					$('#precioV').val(dato['precio']);
				}
			});
		});

		$('#btnAgregaVenta').click(function(){

			datos=$('#frmVentasProductos').serialize();

			$.ajax({
				type:"POST",
				data:datos,
				url:"../procesos/ventas/agregaProductoTemp.php",
				success:function(r){
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				}
			});
		});

		$('#btnVaciarVentas').click(function(){

		$.ajax({
			url:"../procesos/ventas/vaciarTemp.php",
			success:function(r){
				$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
			}
		});
	});

	});
</script>

<script type="text/javascript">
	function quitarP(index){
		$.ajax({
			type:"POST",
			data:"ind=" + index,
			url:"../procesos/ventas/quitarproducto.php",
			success:function(r){
				$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
				alertify.success("ARTICULO ELIMINADO!");
			}
		});
	}

	function crearVenta(){
		$.ajax({
			url:"../procesos/ventas/crearVenta.php",
			success:function(r){
				if(r > 0){
					$('#tablaVentasTempLoad').load("ventas/tablaVentasTemp.php");
					$('#frmVentasProductos')[0].reset();
					$('#productoVenta').val('');
					$('#clienteVenta').val('');
					alertify.alert("VENTA EXITOSA!!!");
				}else if(r==0){
					alertify.alert("NO HAY LISTA DE VENTAS!!");
				}else{
					alertify.error("NO SE PUDO GENERAR LA VENTA");
				}
			}
		});
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#clienteVenta').select2();
		$('#productoVenta').select2();

	});
</script>