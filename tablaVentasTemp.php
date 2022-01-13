<?php 
	session_start();
	isset($_SESSION['rol']) ? $id_rol = $_SESSION['rol'] : $id_rol = null;
 ?>
 
 <center><h4>REMISIONAR VENTAS</h4></center>
 <br>
 <h4><strong><div id="nombreclienteVenta"></div></strong></h4>
 <table class="table table-bordered table-hover table-condensed" style="text-align: center;" id="table-ventas">
 	<caption>
 		<span class="btn btn-success" onclick="crearVenta()"> GENERAR VENTAS
 			<span class="glyphicon glyphicon-usd"></span>
 		</span>
 		
		<span class="btn btn-danger btn-sm" id="generarPdf">GENERAR PDF VENTAS
				<span class="glyphicon glyphicon-file"></span>
		</span>
 	</caption>
	 <thead>
		<tr>
			<td>TIPO VENTA</td>
			<td>ARTICULO</td>
			<td>CANTIDAD</td>
			<?php if($id_rol == 99){ ?>
			<!-- <td>PRECIO</td>
			<?php } ?> -->
			<td>PRECIO VENTA</td>
			
			<td>ACCIONES</td>
		</tr>
	</thead>
	 <tbody>
 	<?php 
 	$total=0;//esta variable tendra el total de la compra en dinero
 	$cliente=""; //en esta se guarda el nombre del cliente
 		if(isset($_SESSION['tablaComprasTemp'])):
 			$i=0;
	foreach (@$_SESSION['tablaComprasTemp'] as $key) {
 		$d=explode("||", @$key);
 	?>
	
		<tr id="<?php echo $d[0] ?>">
			<td>
				<?php 
						$tipoVenta = $d[5]=='1' ? 'CONTADO' : 'CREDITO';
						echo $tipoVenta; 
				?>
			</td>
			<td><?php echo $d[1] ?></td>
			<td><?php echo $d[2] ?></td>
			<?php if($id_rol == 99){ ?>
			<!-- <td><?php echo $d[3] ?></td>
			<?php } ?> -->
			<td><?php echo $d[7] ?></td>
			
			<td>
				<span class="btn btn-danger btn-xs" onclick="quitarP('<?php echo $i; ?>')">
					<span class="glyphicon glyphicon-remove"></span>
				</span>
			</td>
		</tr>
			<?php 
					$total=$total + ( $d[2] * $d[7]);
					$i++;
					$cliente=$d[4];
				}
				endif; 
			?>
			<tfoot>
				<tr>
					<th scope="row" colspan="2">
						Total de venta
					</th>
					<td colspan="3"><?php echo "$".$total; ?></td>
				</tr>
			</tfoot>
	</tbody>
 </table>

 <script type="text/javascript">
 	$(document).ready(function(){
 		nombre="<?php echo @$cliente ?>";
 		$('#nombreclienteVenta').text("Nombre de cliente: " + nombre);
		$('#generarPdf').click(function(){
			window.open('../procesos/ventas/reporteVentastotalesPDF.php','_blank');
		});
 	});
 </script>