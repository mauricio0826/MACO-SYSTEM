<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Categorias.php";
	$id=$_POST['id_categoria'];

	$obj= new categorias();
	echo $obj->eliminaCategoria($id);

 ?>