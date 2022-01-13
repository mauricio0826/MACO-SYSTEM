<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ESTADO DE CUENTA GENERAL</title>
	<!-- <?php require_once "menu.php"; ?> -->

<style>
	.container{
	margin: 0% 23%;
	}
</style>

</head>
<body>

<center><img src="https://infografiadelcad.files.wordpress.com/2013/06/fuera-de-servicio.png">
	</center>

<!-- 	<div class="container">
		 <h1>ESTADO DE CUENTA GENERAL</h1>
		 <br>
		 <br>
		 <br>
		 <br>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<label>DESDE...</label>	
				<input type="date" id="start" name="trip-start"
       			value="actual"
       			min="2021-01-01" max="2021-12-31">

       			<br>	
       			<br>
       			<p></p>

       			<label>HASTA...</label>	
				<input type="date" id="start" name="trip-start"
       			value="actual"
       			min="2021-01-01" max="2021-12-31">
       			<br>
       			<br>
       			<p></p>
		 		<span class="btn btn-default" id="cuentaGeneralBtn">CONSULTAR</span>
		 		<span class="btn btn-default" id="cuentaGeneralBtn">REPORTE PDF</span>
		 	</div>
		 </div>
		 <div class="row">
		 	<div class="col-sm-12"> -->
<!-- 		 		<div id="ventaProductos"></div>
		 		<div id="ventasHechas"></div> -->
<!-- 		 	</div>
		 </div>
	</div> -->
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#salidaArticuloBtn').click(function(){
				esconderSeccionVenta();
				$('#salidaArticulo').load('ventas/salidaArticulo.php');
				$('#salidaArticulo').show();
			});
			$('#salidaArticuloBtn').click(function(){
				esconderSeccionVenta();
				$('#salidaArticulo').load('ventas/infoExistsalidaArticulo.php');
				$('#salidaArticulo').show();
			});
		});

		function esconderSeccionsalidaArticulo(){
			$('#salidaArticulo').hide();
			$('#salidaArticulo').hide();
		}

	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>