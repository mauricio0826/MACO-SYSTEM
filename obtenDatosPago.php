<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Pago.php";

	$obj= new pago();

	echo json_encode($obj->obtenDatosPago($_POST['idpago']));

 ?>