<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Pago.php";

	$obj= new pago();

	
	echo $obj->eliminaPago($_POST['idpago'],$_POST['claveGer']);
 ?>