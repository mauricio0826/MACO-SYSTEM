<?php 

	class gastos{

		public function agregarGastos($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="INSERT into gastos (	id_cliente,
										id_usuario,
										tipoG,
										origenSelect,
										valor)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosGastos($idgastos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_codigoG,
						 id_cliente,
						 tipoG,
						 origenSelect,
						 valor 
				  FROM gastos
				  WHERE id_codigoG = $idgastos";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_codigoG' => $ver[0], 
					'id_cliente' => $ver[1],
					'tipoG' => $ver[2],
					'origenSelect' => $ver[3],
					'valor' => $ver[4],
						);
			return $datos;
		}

		public function actualizaGastos($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE gastos set id_cliente='$datos[1]',
										tipoG = '$datos[2]',
										origenSelect = '$datos[3]',
										valor = '$datos[4]' WHERE id_codigoG = $datos[0]";
			return mysqli_query($conexion,$sql);
		}

		public function eliminaGastos($idgastos,$claveGer){
			$c= new conectar();
			$conexion=$c->conexion();
			
			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
		
			if( $ver == null){
				return '0';
			}else{
				$sql="DELETE from gastos where id_codigoG=$idgastos";
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