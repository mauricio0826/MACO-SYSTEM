<?php 

require_once "../../clases/Conexion.php";
require_once "../../clases/Articulos.php";

$obj= new articulos();

$datos=array(
	$_POST['codigoU'],
	$_POST['nombreU'],
	$_POST['cantidadU'],
	$_POST['precioU'],
	$_POST['origenSelectU']		
);
	echo $obj->actualizaArticulo($datos);

 ?>