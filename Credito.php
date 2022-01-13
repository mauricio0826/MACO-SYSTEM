<?php 

	class credito{

		public function agregaCredito($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="INSERT into credito (	id_cliente,
									    id_usuario,
										tipoC,
										origenSelect,
										valor,
										tipo_cliente)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]',
									'$datos[5]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosCredito($idcredito){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_CodigoC,
						 id_cliente,
						 tipoC,
						 origenSelect,
						 valor,
						 tipo_cliente
				FROM credito
				WHERE id_CodigoC = $idcredito";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_CodigoC' => $ver[0], 
					'id_cliente' => $ver[1],
					'tipoC' => $ver[2],
					'origenSelect' => $ver[3],
					'valor' => $ver[4],
					'tipo_cliente' => $ver[5],
						);
			return $datos;
		}

		public function actualizaCredito($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE credito set id_cliente='$datos[1]',
									 tipoC = '$datos[2]',
									 origenSelect = '$datos[3]',
									 valor = '$datos[4]',
									 tipo_cliente = '$datos[5]'
				  WHERE id_CodigoC='$datos[0]'";

			return mysqli_query($conexion,$sql);
		}

		public function eliminaCredito($idcredito,$claveGer){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
		
			if( $ver == null){
				return '0';
			}else{
				$sql="DELETE from credito where id_CodigoC='$idcredito'";
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