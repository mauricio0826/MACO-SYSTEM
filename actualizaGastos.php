<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Gastos.php";

	$obj= new gastos();


	$datos=array(
		$_POST['codigoGU'],
		$_POST['clienteU'],
		$_POST['tipoGU'],
		$_POST['origenSelectU'],
		$_POST['valorU'],
	);

	echo $obj->actualizaGastos($datos);

 ?>