<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Categorias.php";


	$datos=array(
		$_POST['idcodigo'],
		$_POST['codigoU']
			);

	$obj= new categorias();

	echo $obj->actualizaCategoria($datos);

 ?>