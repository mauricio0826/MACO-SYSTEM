<?php 

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Credito.php";

	$obj= new Credito();

	$tipoCred = $_POST['tipoCredU'];
	$cliente = $_POST['clienteU'];
	$proveedor = $_POST['proveedorU'];

	if($tipoCred == 'cliente'){
		$id_cliente = $cliente;
	}else if($tipoCred == 'proveedor'){
		$id_cliente = $proveedor;
	}

	$datos=array(
		$_POST['codigoCU'],
		$id_cliente,
		$_POST['tipoCU'],
		$_POST['origenSelectU'],
		$_POST['valorU'],
		$tipoCred,
	);

	echo $obj->actualizaCredito($datos);

 ?>