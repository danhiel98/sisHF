<?php
	class Conexion extends mysqli
	{

		public function __construct()
		{
			parent::__construct('localhost','root','','sistemaHierroForjado');
			$this->query("SET NAMES 'utf-8';");
			$this->connect_errno ? die("Error con la conexión") : $x = 'Conectado';
			//echo $x;
			unset($x);
		}

		//Para cerrar la sesión
		public function cerrar(){
			$this->Conexion->close();
		}

		//recorre las filas que retorna una consulta
		public function recorrer($y){

			return mysqli_fetch_array($y);

		}

		//numero de filas de la consulta
		public function rows($y){

			return mysqli_num_rows($y);

		}

		public function mostrarValor($valorMostrar, $tabla, $campoCondicion, $valorCondicion){
			//generarText
			try {
				$sql = $this->query("SELECT $valorMostrar FROM $tabla WHERE $campoCondicion = $valorCondicion;");

				if ($this->rows($sql) > 0) {
					while ($consulta = $this->recorrer($sql)) {
								echo $consulta[$valorMostrar];
					}
				} else {
					echo '<script>
							alert("Lo sentimos,\nExiste un problema con la función mostrarValor");
							 </script>';
				}
			} catch (Exception $e) {
				echo '<script>
							alert("Lo sentimos,\nExiste un problema con la función mostrarValor,\nPor: " + '.$e->getMessage().');
							 </script>';
			}
		}

	}
?>
