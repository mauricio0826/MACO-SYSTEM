<?php 
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Articulos.php";

	$obj=new articulos();

	echo $obj->eliminaArticulo($_POST['idarticulo'],$_POST['claveGer']);

?>