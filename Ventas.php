<?php 
 
class ventas{ 
	public function obtenDatosProducto($idproducto){
		$c=new conectar();
		$conexion=$c->conexion();
		
		if(!empty($idproducto)){
			$sql = "SELECT 
				    art.id_producto,
				    art.nombre,
				    art.cantidad,
				    art.precio
				FROM articulos art WHERE art.id_producto = '".$idproducto."'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
			$data=array(
				'codigo' => isset($ver[0]) ? $ver[0] : null,
				'nombre' => isset($ver[1]) ? $ver[1]: null,
				'cantidad' => isset($ver[2]) ? $ver[2] : null,
				'precio' => isset($ver[3]) ? $ver[3] : null
			);
		}else{
			$data = '0';
		}
		return $data;
	}

	public function crearVenta(){
		$c= new conectar();
		$conexion=$c->conexion();

		$fecha=date('Y-m-d');
		$datos=$_SESSION['tablaComprasTemp'];
		$idusuario=$_SESSION['iduser'];
		$r=0;
		//var_dump($datos);exit();
		// "00010||GASAS||10||5||VILLALPANDO JESUS||1||0005" 
		for ($i=0; $i < count($datos) ; $i++) {
			$d=explode("||", $datos[$i]);
			$tipo_venta = $d[5] == '1' ? 'contado':'credito';
			$sql="INSERT into ventas (	id_cliente,
										id_producto,
										tipo_venta,
										id_usuario,
										cantidad,
										precio,
										total,
										fechaCompra)
							values ('$d[6]',
									'$d[0]',
									'$tipo_venta',
									'$idusuario',
									'$d[2]',
									'$d[7]',
									($d[2] * $d[7]),
									'$fecha')";
									
			$sqlUPD="UPDATE articulos set cantidad = ( cantidad - $d[2]) WHERE id_producto = '$d[0]' ";
			$resUPD=mysqli_query($conexion,$sqlUPD);
			
			$r=$r + $result=mysqli_query($conexion,$sql);
		}

		return $r;
	}
	
	public function eliminarVenta($id_venta,$claveGer){
		$c= new conectar();
		$conexion=$c->conexion();	

		$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
		$result=mysqli_query($conexion,$sql);
		$ver=mysqli_fetch_row($result);
	
		if( $ver == null){
			return '0';
		}else{
			$sql = "DELETE FROM ventas WHERE id_Venta = $id_venta";
			$result=mysqli_query($conexion,$sql);
			if($result == false){
				return '0';
			}else{
				return '1';
			}
		}		
	}
}

?>