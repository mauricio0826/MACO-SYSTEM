<?php 

	class recaudo{

		public function agregaRecaudo($datos){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql="INSERT into Recaudo( id_cliente,
									   id_usuario,
									   tipoR,
									   origenSelect,
									   valor)
							values ('$datos[0]',
									'$datos[1]',
									'$datos[2]',
									'$datos[3]',
									'$datos[4]')";
			return mysqli_query($conexion,$sql);	
		}

		public function obtenDatosRecaudo($idrecaudo){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 	r.id_codigoR,
			COALESCE(
					(CASE WHEN IFNULL(cli.id_codigo,0) > 0 THEN 'cliente' ELSE NULL END),
					(CASE WHEN IFNULL(pro.id_codigo,0) > 0 THEN 'proveedor' ELSE NULL END)
				) tipo_cliente,
				r.id_cliente,
				r.tipoR,
				r.origenSelect,
				r.valor
			FROM recaudo r
			LEFT JOIN clientes cli on cli.id_codigo = r.id_cliente
			LEFT JOIN proveedores pro on pro.id_codigo = r.id_cliente
			WHERE r.id_codigoR = $idrecaudo";
			
			
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);

			$datos=array(
					'id_codigoR' => $ver[0],
					'tipo_cliente' =>$ver[1],
					'id_cliente' => $ver[2],
					'tipoR' => $ver[3],
					'origenSelect' => $ver[4],
					'valor' => $ver[5],
						);
			return $datos;
		}

		public function actualizaRecaudo($datos){
			$c= new conectar();
			$conexion=$c->conexion();
			$sql="UPDATE recaudo SET 
						id_cliente='$datos[1]',
						tipoR = '$datos[2]',
						origenSelect = '$datos[3]',
						valor = '$datos[4]'
					WHERE id_codigoR = $datos[0]";
			return mysqli_query($conexion,$sql);
		}

		public function eliminaRecaudo($idrecaudo,$claveGer){
			$c= new conectar();
			$conexion=$c->conexion();

			$sql = "SELECT 'S' FROM usuarios WHERE rol = '99' and password = sha1('$claveGer')";
			$result=mysqli_query($conexion,$sql);
			$ver=mysqli_fetch_row($result);
		
			if( $ver == null){
				return '0';
			}else{
				$sql="DELETE from recaudo where id_codigoR='$idrecaudo'";
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