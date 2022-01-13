<?php 
 
	class usuarios{
		public function registroUsuario($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$fecha=date('Y-m-d');

			$sql="INSERT into usuarios (nombre,
								apellido,
								id_usuario,
								password,
								rol,
								fechaCaptura)
						values ('$datos[0]',
								'$datos[1]',
								'$datos[2]',
								'$datos[3]',
								'1',
								'$fecha')";
			return mysqli_query($conexion,$sql);
		}
		public function loginUser($datos){
			$c=new conectar();
			$conexion=$c->conexion();
			$password=sha1($datos[1]);

			$_SESSION['usuario']=$datos[0];
			$_SESSION['iduser']=self::traeID($datos);
			$_SESSION['rol']=self::traeRol($datos);

			$sql="SELECT * 
					from usuarios 
				where id_usuario='$datos[0]'
				and password='$password'";
			$result=mysqli_query($conexion,$sql);

			if(mysqli_num_rows($result) > 0){
				return 1;
			}else{
				return 0;
			}
		}
		public function traeID($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$password=sha1($datos[1]);

			$sql="SELECT id_usuario
					from usuarios 
					where id_usuario='$datos[0]'
					and password='$password'"; 
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}
		
		public function traeRol($datos){
			$c=new conectar();
			$conexion=$c->conexion();

			$password=sha1($datos[1]);

			$sql="SELECT rol 
					from usuarios 
					where id_usuario='$datos[0]'
					and password='$password'"; 
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}		
		
		public function traePass($usuario){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="SELECT password from usuarios where id_usuario='$usuario'"; 
			$result=mysqli_query($conexion,$sql);

			return mysqli_fetch_row($result)[0];
		}		

		public function obtenDatosUsuario($idusuario){

			$c=new conectar();
			$conexion=$c->conexion();

			$sql="SELECT id_usuario,
							nombre,
							apellido,password
					from usuarios 
					where id_usuario='$idusuario'";
			$result=mysqli_query($conexion,$sql);

			$ver=mysqli_fetch_row($result);

			$datos=array(
						'id_usuario' => $ver[0],
							'nombre' => $ver[1],
							'apellido' => $ver[2],
							'password' => $ver[3],
						);
			return $datos;
		}

		public function actualizaUsuario($datos){
			$c=new conectar();
			$conexion=$c->conexion();
			
			$pass = self::traePass($datos[0]);
			
			$pass2 = sha1($datos[3]);
			
			if( $pass == $datos[3] ){
				$sql="UPDATE usuarios set nombre='$datos[1]', apellido='$datos[2]' where id_usuario='$datos[0]'";
			}else if( $pass == $pass2 ){
				$sql="UPDATE usuarios set nombre='$datos[1]', apellido='$datos[2]' where id_usuario='$datos[0]'";
			}else if( $pass != $pass2 ){
				$sql="UPDATE usuarios set nombre='$datos[1]', apellido='$datos[2]', password='$pass2' where id_usuario='$datos[0]'";				
			}

			return mysqli_query($conexion,$sql);	
		}

		public function eliminaUsuario($idusuario){
			$c=new conectar();
			$conexion=$c->conexion();

			$sql="DELETE from usuarios where id_usuario='$idusuario'";
			return mysqli_query($conexion,$sql);
		}
	}

 ?>