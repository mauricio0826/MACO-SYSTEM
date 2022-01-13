<?php  
	class articulos{
		public function insertaArticulo($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into articulos (id_usuario,
										id_producto,
										nombre,
										cantidad,
										precio,
										origen,
										fechaCaptura) 
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]',
									'$fecha')";
										
			return mysqli_query($conexion,$sql);
		}

		public function obtenDatosArticulo($idarticulo){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_producto, nombre, cantidad, precio, origen 
				from articulos 
				where id_producto='$idarticulo'";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
			$datos=array(
				"id_producto" => $ver[0],
				"nombre" => $ver[1],
				"cantidad" => $ver[2],
				"precio" => $ver[3],
				"origen" => $ver[4]
			);

			return $datos;
		}

		public function actualizaArticulo($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="UPDATE articulos set nombre='$datos[1]', 
										cantidad='$datos[2]',
										precio='$datos[3]',
										origen='$datos[4]'
						where id_producto='$datos[0]'";

			return mysqli_query($conexion,$sql);
		}

		public function eliminaArticulo($idarticulo,$claveGer){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);			

			if( $ver == null){
				return '0';
			}else{				
				$sql="DELETE from articulos where id_producto='$idarticulo'";
				$result=mysqli_query($conexion,$sql);
				if($result == false){
					return '0';
				}else{
					return '1';
				}
			}				

			return mysqli_query($conexion,$sql);
		}
	}

 ?>