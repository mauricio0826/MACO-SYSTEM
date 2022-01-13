<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Credito.php";

	$obj= new credito();

	echo json_encode($obj->obtenDatosCredito($_POST['idcredito']));

 ?>