<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Gastos.php";

	$obj= new gastos();

	echo json_encode($obj->obtenDatosGastos($_POST['idgastos']));

 ?>