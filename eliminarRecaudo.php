<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Recaudo.php";

	$obj= new recaudo();

	
	echo $obj->eliminaRecaudo($_POST['idrecaudo'],$_POST['claveGer']);
 ?>