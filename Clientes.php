<?php 

	class clientes{

		public function agregaCliente($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="INSERT into clientes (id_codigo,
										nombre,
										apellido, 
										direccion,
										departamento,
										ciudad,
										telefono,
										razonsocial)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]',
									'$datos[6]',
									'$datos[7]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosCliente($idcliente){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_codigo, 
							nombre,
							apellido,
							direccion,
							departamento,
							ciudad,
							telefono,
							razonsocial 
				from clientes WHERE id_codigo = $idcliente";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_codigo' => $ver[0], 
					'nombre' => $ver[1],
					'apellido' => $ver[2],
					'direccion' => $ver[3],
					'departamento' => $ver[4],
					'ciudad' => $ver[5],
					'telefono' => $ver[6],
					'razonsocial' => $ver[7]
						);
			return $datos;
		}

		public function actualizaCliente($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE clientes set nombre='$datos[1]',
										apellido='$datos[2]',
										direccion = '$datos[3]',
										departamento = '$datos[4]',
										ciudad = '$datos[5]',
										telefono = '$datos[6]',
										razonsocial = '$datos[7]' WHERE id_codigo = $datos[0]";
			return mysqli_query($conexion,$sql);
		}

		public function eliminaCliente($idcliente,$claveGer){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);			

			if( $ver == null){
				return '0';
			}else{			
				$sql="DELETE from clientes where id_codigo='$idcliente'";
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