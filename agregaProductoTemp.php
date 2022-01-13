<?php 
	session_start();
	require_once "../../clases/Conexion.php";

	$c= new conectar();
	$conexion=$c->conexion();
	$idtipo=$_POST['tipoVenta'];
	$idcliente=$_POST['clienteVenta'];
	$idproducto=$_POST['productoVenta'];
	$cantidad=$_POST['cantidadV'];
	$precio=$_POST['precioV'];
	$precioC=$_POST['precioC'];

	if($idcliente != 'A' && $idcliente != '0'){
		$sql="SELECT nombre,apellido 
				from clientes 
				where id_codigo='$idcliente'";
		$result=mysqli_query($conexion,$sql);

		$c=mysqli_fetch_row($result);

		$ncliente=$c[1]." ".$c[0];
	}else{
		if( $idcliente == 'A' ){
			$ncliente='Contado';
		}else{
			$ncliente='Credito';
		}
	}

	$sql="SELECT nombre 
			from articulos 
			where id_producto='$idproducto'";
	$result=mysqli_query($conexion,$sql);

	$nombreproducto=mysqli_fetch_row($result)[0];
	
	$sql="SELECT cantidad,precio 
			from articulos 
			where id_producto='$idproducto'";
	$result=mysqli_query($conexion,$sql);	
	$prod=mysqli_fetch_row($result);
		
	if( $cantidad > $prod[0] ){
		echo 'Cantidad';
	}else{
		$articulo=$idproducto."||".
				$nombreproducto."||".
				$cantidad."||".
				$precio."||".
				$ncliente."||".
				$idtipo."||".
				$idcliente. "||".
				$precioC;
		$_SESSION['tablaComprasTemp'][]=$articulo;	
	}

 ?>