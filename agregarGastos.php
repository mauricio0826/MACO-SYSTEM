<?php 

	session_start();
	$iduser=$_SESSION['iduser'];
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Gastos.php";

	$obj= new gastos();
	//var_dump($_POST);exit();

	$datos=array(
		$_POST['usuarioG'],
		$iduser,
		$_POST['tipoG'],
		$_POST['origenSelect'],
		$_POST['valorG'],
	);

	echo $obj->agregarGastos($datos);
	
 ?>
