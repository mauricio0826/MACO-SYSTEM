<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Credito.php";

	$obj= new credito();

	
	echo $obj->eliminaCredito($_POST['idcredito'],$_POST['claveGer']);
 ?>