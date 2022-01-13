<?php  

session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Recaudo.php";
	//var_dump($_POST);exit();
	$iduser=$_SESSION['iduser'];
	$obj= new recaudo();

	$tipoReca = $_POST['tipoR'];
	$cliente = $_POST['clienteR'];
	$proveedor = $_POST['proveedorR'];

	if($_POST['tipoCred'] == 'cliente'){
		$id_cliente = $cliente;
	}else if($_POST['tipoCred'] == 'proveedor'){
		$id_cliente = $proveedor;
	}	

	$datos=array(
		$id_cliente,
		$iduser,
		$_POST['tipoR'],
		$_POST['origenSelect'],
		$_POST['valorR']
	);
	
	echo $obj->agregaRecaudo($datos);
 ?>