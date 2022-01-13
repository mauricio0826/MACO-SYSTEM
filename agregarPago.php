<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Pago.php";

	$obj= new pago();


	$datos=array(
			$_POST['codigo'],
			$_POST['nombre'],
			$_POST['apellido'],
			$_POST['direccion'],
			$_POST['telefono'],
			$_POST['razonsocial']
				);

	echo $obj->agregaPago($datos);
	
 ?>