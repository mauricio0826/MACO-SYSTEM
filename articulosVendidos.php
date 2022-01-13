<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ARTICULOS VENDIDOS</title>
	<?php require_once "menu.php"; ?>

<style>
	.container{
	 	margin: 0% 23%;
	}
</style>

</head>
<body>
<div class="container">
	<h1>ARTICULOS VENDIDOS</h1>
		<br>
		 	<div class="row">
		 		<div class="col-sm-12">
		 			<label>DESDE...</label>	
						<input type="date" id="start" name="trip-start" value="actual" min="2021-01-01" max="2021-12-31">
    <br>	
    <p></p>
	       				<label>HASTA...</label>	
					<input type="date" id="end" name="trip-end" value="actual" min="2021-01-01" max="2021-12-31">
	<br>
	<p></p>
	       			<label>CODIGO DEL ARTICULO</label>
						<input type="text" class="form-control input-sm" id="articulo" name="articulo">	
	<br>
	<p></p>

			 		<span class="btn btn-default" id="verInformacion">CONSULTAR</span>
			 		<span class="btn btn-default" id="generarPdf">REPORTE PDF</span>
		 		</div>
		 	</div>
	<div class="row">
		<div class="col-sm-12" style="padding:50px 0px;">
		 	<div id="RverInformacion"></div>
		 	</div>
		</div>
	</div>
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#verInformacion').click(function(){
				esconderSeccionsalidaArticulo();
				var start = $('#start').val();
				var end = $('#end').val();
				var articulo = $('#articulo').val();
				$('#RverInformacion').load('ventas/infoSalidaArticulo.php?start='+start+'&end='+end+'&articulo='+articulo);
				$('#RverInformacion').show();
			});
			$('#generarPdf').click(function(){
				var start = $('#start').val();
				var end = $('#end').val();
				var articulo = $('#articulo').val();
				window.open('../procesos/ventas/rptSalidaArticuloPdf.php?start='+start+'&end='+end+'&articulo='+articulo, '_blank');
			});
		});

		function esconderSeccionsalidaArticulo(){
			$('#RverInformacion').hide();
		}
	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>