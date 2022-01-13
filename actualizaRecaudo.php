 <?php 
 
session_start();
	require_once "../../clases/Conexion.php";
	require_once "../../clases/Recaudo.php";

	$obj= new Recaudo();
	$id_codigo = $_POST['codigoCU'];
	$tipoCred = $_POST['tipoCredU'];
	if($tipoCred == 'cliente'){
		$id_cliente = $_POST['clienteU'];
	}else if($tipoCred == 'proveedor'){
		$id_cliente = $_POST['proveedorU'];
	}
	$tipo_recaudo = $_POST['tipoRU'];
	$cliente = $_POST['clienteU'];
	$select = $_POST['origenSelectU'];
	$valor = $_POST['valorU'];

	$datos=array(
		$id_codigo,
		$id_cliente,
		$tipo_recaudo,
		$select,
		$valor
	);

	echo $obj->actualizaRecaudo($datos);

 ?>