<?php 

	require_once "../../clases/Conexion.php";
	require_once "../../clases/Usuarios.php";

	$obj= new usuarios;

	$datos=array(
		$_POST['usuarioU'],  
		$_POST['nombreU'] , 
		$_POST['apellidoU'],
		$_POST['passwordU']
	);  
	echo $obj->actualizaUsuario($datos);
	
 ?>