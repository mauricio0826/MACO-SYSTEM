<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Gastos.php";

	$obj= new gastos();

	
	echo $obj->eliminaGastos($_POST['idgastos'],$_POST['claveGer']);
 ?>