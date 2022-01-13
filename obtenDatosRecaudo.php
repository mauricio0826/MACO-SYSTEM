<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Recaudo.php";

	$obj= new Recaudo();

	echo json_encode($obj->obtenDatosRecaudo($_POST['idrecaudo']));

 ?>