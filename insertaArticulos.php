<?php 
	session_start();
	$iduser=$_SESSION['iduser'];
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Articulos.php";

	$obj= new articulos();
	$datos=array();

	if($iduser != ''){
		$datos[0]=$iduser;
		$datos[1]=$_POST['codigo'];
		$datos[2]=$_POST['nombre'];
		$datos[3]=$_POST['cantidad'];
		$datos[4]=$_POST['precio'];
		$datos[5]=$_POST['origenSelect'];
		echo $obj->insertaArticulo($datos);
	}else{
		echo 0;
	}

 ?>