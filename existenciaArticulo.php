<?php 

	require_once "../../clases/Conexion.php";

	$c= new conectar();
	$conexion=$c->conexion();

	$sql="SELECT ven.id_infoInventario,COALESCE((select cli.nombre from clientes cli where cli.id_codigo = ven.id_cliente),ven.id_cliente) cliente, 
  		  art.nombre, ven.total
          FROM infoInventario ven
		  INNER JOIN articulos art on art.id_producto = ven.id_producto";
	$result=mysqli_query($conexion,$sql); 
	?>

<h4>EXISTENCIA POR ARTICULO</h4>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered" style="text-align: center;">
				
				<tr>
					<td>REFERENCIA</td>
					<td>ARTICULO</td>
					<td>ENTRADA</td>
					<td>SALIDA</td>
					<td>EXISTENCIA</td>	
				</tr>
		<!-- <?php while($ver=mysqli_fetch_row($result)): ?>
				
		<?php endwhile; ?> -->
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modalEliVenta" tabindex="-1" role="dialog" aria-labelledby="modalEliVenta">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modalEliVenta">AUTORIZACIÓN GERENTE</h4>
			</div>
			<div class="modal-body">
				<form id="frmAutorizaGer">
					<label>Clave Gerente</label>
					<input type="password" class="form-control input-sm" id="claveGer" name="claveGer" autofocus="autofocus">
					<input type="text" style="display:none;" id="id_venta" name="id_venta">
				</form>
			</div>
			<div class="modal-footer">
				<button id="btnAutoriza" type="button" class="btn btn-danger" data-dismiss="modal">ELIMINAR</button>
			</div>
		</div>
	</div>
</div>

<!-- <script>
	function quitarVenta(id_infoInventario){
		alertify.confirm('¿DESEAS ELIMINAR ESTA VENTA?', function(){ 
			$('#id_venta').val(id_venta);
			$('#modalEliVenta').modal('show'); // abrir
		}, function(){ 
			alertify.error('CANCELADO !')
		});
		
		$('#btnAutoriza').click(function(){
			var id_venta = $('#id_venta').val();
			var claveGer = $('#claveGer').val();

			$.ajax({
				type:"POST",
				data:"id_venta=" + id_venta + "&claveGer=" + claveGer,
				url:"../procesos/ventas/eliminarVenta.php",
				success:function(r){
					if(r==1){
						location.reload();
					}else{
						alertify.error("FALO AL ELIMINAR");
					}
					$('#claveGer').val('');
				}
			});
		});		
	}
</script> -->