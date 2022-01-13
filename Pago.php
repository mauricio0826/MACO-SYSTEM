<?php 

	class pago{

		public function agregaPago($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="INSERT into proveedores (id_codigo,
										nombre,
										apellido,
										direccion,
										telefono,
										razonsocial)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosPago($idpago){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_codigo, 
							nombre,
							apellido,
							direccion,
							telefono,
							razonsocial 
				from proveedores WHERE id_codigo = $idpago";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_codigo' => $ver[0], 
					'nombre' => $ver[1],
					'apellido' => $ver[2],
					'direccion' => $ver[3],
					'telefono' => $ver[4],
					'razonsocial' => $ver[5]
						);
			return $datos;
		}

		public function actualizaPago($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE proveedores set nombre='$datos[1]',
										apellido='$datos[2]',
										direccion = '$datos[3]',
										telefono = '$datos[4]',
										razonsocial = '$datos[5]' WHERE id_codigo = $datos[0]";
			return mysqli_query($conexion,$sql);
		}

		public function eliminaPago($idopago,$claveGer){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);			

			if( $ver == null){
				return '0';
			}else{			
				$sql="DELETE from proveedores where id_codigo='$idopago'";
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