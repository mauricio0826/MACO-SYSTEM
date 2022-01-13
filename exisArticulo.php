<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>EXISTENCIA POR ARTICULO</title>
	<?php require_once "menu.php"; ?>

<style>
	.container{
	margin: 0% 23%;
	}
</style>

</head>
<body>

	<div class="container">
		 <h1>EXISTENCIA POR ARTICULO</h1>
	<footer style="padding: 10px;"></footer>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<label>DESDE...</label>	
					<input type="date" id="start" name="trip-start" value="actual" min="2021-01-01" max="2021-12-31">
	<footer style="padding: 10px;"></footer>

       			<label>HASTA...</label>	
					<input type="date" id="end" name="trip-end" value="actual" min="2021-01-01" max="2021-12-31">
	<footer style="padding: 10px;"></footer>

		 		<span class="btn btn-default" id="infoexistenciaBtn">CONSULTAR</span>
		 		<span class="btn btn-default" id="infoExistenciapdfBtn">REPORTE PDF</span>
		 	</div>
		</div>
		<div class="row">
		 	<div class="col-sm-12" style="padding:50px 0px;">
		 		<div id="ventaProductos"></div>
		 			<div id="ventasHechas"></div>
		 			</div>
				</div>
			</div>
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#infoexistenciaBtn').click(function(){
				esconderSeccionExistencia();
				var start = $('#start').val();
				var end = $('#end').val();
				if(start && end ){
					$('#ventaProductos').load('ventas/infoArticuloInventario.php?start='+start+'&end='+end);
					$('#ventaProductos').show();
				}else{
					alertify.error("FAVOR DE INGRESAR PARAMETROS DE FECHA");
				}
			});
			$('#infoExistenciapdfBtn').click(function(){
				var start = $('#start').val();
				var end = $('#end').val();	
				window.open('../procesos/articulos/reporteInfoArticuloPdf.php?start='+start+'&end='+end,'_blank');
			});
		});

		function esconderSeccionExistencia(){
			$('#ventaProductos').hide();
			$('#ventaProductos').hide();
		}

	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>