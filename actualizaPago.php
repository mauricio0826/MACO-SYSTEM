<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Pago.php";

	$obj= new pago();


	$datos=array(
		$_POST['codigoU'],
		$_POST['nombreU'],
		$_POST['apellidoU'],
		$_POST['direccionU'],
		$_POST['telefonoU'],
		$_POST['razonsocialU']
	);

	echo $obj->actualizaPago($datos);

 ?>