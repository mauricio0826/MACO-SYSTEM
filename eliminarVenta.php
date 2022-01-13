<?php 
	session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Ventas.php";
	$obj= new ventas();

	$id_venta=$_POST['id_venta'];
	$claveGer=$_POST['claveGer'];	
	
	$result=$obj->eliminarVenta($id_venta,$claveGer);
	echo $result;
 ?>