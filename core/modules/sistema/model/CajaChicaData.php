<?php
class CajaChicaData {
	public static $tablename = "cajaChica";

	public function CajaChicaData(){
		$this->cantidad = "";
		$this->entradas = "";
		$this->salidas = "";
		#$this->idencargado = "";
		#Para ingresos y salidas:
		$this->idusuario = "";
		$this->cantidad = "";
		$this->fecha = "";
		$this->idempleado = "";
		$this->descripcion = "";
	}

	#public function getEncargado(){ return EmpleadoData::getById($this->idencargado);}
	public function getUsuario(){ return UserData::getById($this->idusuario);}
	public function getEmpleado(){ return EmpleadoData::getById($this->idempleado);}

	/*
	public function actualizarEncargado(){
		$sql = "update ".self::$tablename." set encargado = \"$this->idencargado\"";
		Executor::doit($sql);
	}
	*/
	
	public function addIngreso(){
		$sql = "insert into ingresoCajaChica (idUsuario, cantidad, fecha) ";
		$sql .= "values ($this->idusuario,$this->cantidad,$this->fecha)";
		Executor::doit($sql);
	}

	public function addSalida(){
		$sql = "insert into salidaCajaChica (idUsuario, idEmpleado, cantidad, descripcion, fecha) ";
		$sql .= "values ($this->idusuario,$this->idempleado,$this->cantidad,\"$this->descripcion\",$this->fecha)";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set cantidad=$this->cantidad, entradas=$this->entradas, salidas=$this->salidas where idCajaChica = $this->id";
		Executor::doit($sql);
	}

	public static function getIngresos(){
		$sql = "select * from ingresoCajaChica";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CajaChicaData();
			$array[$cnt]->id = $r['idIngresoCajaChica'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getSalidas(){
		$sql = "select * from salidaCajaChica";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CajaChicaData();
			$array[$cnt]->id = $r['idSalidaCajaChica'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllR(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CajaChicaData();
			$array[$cnt]->id = $r['idCajaChica'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->entradas = $r['entradas'];
			$array[$cnt]->salidas = $r['salidas'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$found = null;
		$data = new CajaChicaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCajaChica'];
			$data->cantidad = $r['cantidad'];
			$data->entradas = $r['entradas'];
			$data->salidas = $r['salidas'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


}

?>
