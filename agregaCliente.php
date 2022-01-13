<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Clientes.php";

	$obj= new clientes();


	$datos=array(
			$_POST['codigo'],
			$_POST['nombre'],
			$_POST['apellido'],
			$_POST['direccion'],
			$_POST['departamento'],
			$_POST['ciudad'],
			$_POST['telefono'],
			$_POST['razonsocial']
				);

	echo $obj->agregaCliente($datos);
	
 ?>