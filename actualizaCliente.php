<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Clientes.php";

	$obj= new clientes();


	$datos=array(
		$_POST['codigoU'],
		$_POST['nombreU'],
		$_POST['apellidoU'],
		$_POST['direccionU'],
		$_POST['departamentoU'],
		$_POST['ciudadU'],
		$_POST['telefonoU'],
		$_POST['razonsocialU']
	);

	echo $obj->actualizaCliente($datos);

 ?>