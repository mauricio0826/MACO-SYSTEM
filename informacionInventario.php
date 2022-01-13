<?php 
	session_start();
	if(isset($_SESSION['usuario'])){
		
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>INFORMACION INVENTARIO</title>
	<?php require_once "menu.php"; ?>
</head>
<body>

	<div class="container">
		 <h1>INFORMACI&OacuteN INVENTARIO</h1>
		 <br>
		 <br>
		 <br>
		 <br>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<label>DESDE...</label>	
				<input type="date" id="start" name="trip-start"
       			value="2018-07-22"
       			min="2021-01-01" max="2021-12-31">

       			<br>	
       			<br>
       			<p></p>

       			<label>HASTA...</label>	
				<input type="date" id="start" name="trip-start"
       			value="2018-07-22"
       			min="2021-01-01" max="2021-12-31">

       			<br>	
       			<br>
				<p></p>

		 		<span class="btn btn-default" id="ventaProductosBtn">CONSULTAR</span>
		 		<span class="btn btn-default" id="ventasHechasBtn">REPORTE PDF</span>
		 	</div>
		 </div>
		 <div class="row">
		 	<div class="col-sm-12">
		 		<div id="ventaProductos"></div>
		 		<div id="ventasHechas"></div>
		 	</div>
		 </div>
	</div>
</body>
</html>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#infoInventarioBtn').click(function(){
				esconderSeccionVenta();
				$('#infoInventario').load('ventas/infoInventario.php');
				$('#infoInventario').show();
			});
			$('#infoInventarioBtn').click(function(){
				esconderSeccionVenta();
				$('#infoInventario').load('ventas/infoInventario.php');
				$('#infoInventario').show();
			});
		});

		function esconderSeccioninventario(){
			$('#infoInventario').hide();
			$('#infoInventario').hide();
		}

	</script>

<?php 
	}else{
		header("location:../index.php");
	}
 ?>