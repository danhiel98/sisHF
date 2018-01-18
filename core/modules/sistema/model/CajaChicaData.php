<?php
class CajaChicaData {
	public static $tablename = "cajaChica";

	public function CajaChicaData(){
		$this->cantidad = "";
		$this->entradas = "";
		$this->salidas = "";
		#Para ingresos y salidas:
		$this->idusuario = "";
		$this->cantidad = "";
		$this->fecha = "";
		$this->idempleado = "";
		$this->descripcion = "";
	}

	public function getUsuario(){ return UserData::getById($this->idusuario);}
	public function getEmpleado(){ return EmpleadoData::getById($this->idempleado);}
	
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

	public function updateIngreso(){
		$sql = "update ingresoCajachica set cantidad = $this->cantidad where idIngresoCajaChica = $this->id";
		Executor::doit($sql);
	}

	public function updateSalida(){
		$sql = "update salidaCajachica set idEmpleado = $this->idempleado, cantidad = $this->cantidad, descripcion = \"$this->descripcion\" where idSalidaCajaChica = $this->id";
		Executor::doit($sql);
	}

	public function delIngreso(){
		$sql = "update ingresoCajachica set estado = 0 where idIngresoCajaChica = $this->id";
		Executor::doit($sql);
	}

	public function delSalida(){
		$sql = "update salidaCajachica set estado = 0 where idSalidaCajaChica = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set cantidad=$this->cantidad, entradas=$this->entradas, salidas=$this->salidas where idCajaChica = $this->id";
		Executor::doit($sql);
	}

	public static function getIngresos(){
		$sql = "select * from ingresoCajaChica where estado = 1";
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

	public static function getIngresoById($id){
		$sql = "select * from ingresoCajaChica where idIngresoCajaChica = $id";
		$query = Executor::doit($sql);
		$cnt = 0;
		$data = new CajaChicaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idIngresoCajaChica'];
			$data->idusuario = $r['idUsuario'];
			$data->cantidad = $r['cantidad'];
			$data->fecha = $r['fecha'];
			$cnt++;
			break;
		}
		return $data;
	}

	public static function getSalidas(){
		$sql = "select * from salidaCajaChica where estado = 1";
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

	public static function getSalidaById($id){
		$sql = "select * from salidaCajaChica where idSalidaCajaChica = $id";
		$query = Executor::doit($sql);
		$cnt = 0;
		$data = new CajaChicaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idSalidaCajaChica'];
			$data->idusuario = $r['idUsuario'];
			$data->idempleado = $r['idEmpleado'];
			$data->cantidad = $r['cantidad'];
			$data->descripcion = $r['descripcion'];
			$data->fecha = $r['fecha'];
			$cnt++;
			break;
		}
		return $data;
	}

	public static function getIngresosByPage($start,$limit){
		$start--;
		$sql = "select * from ingresoCajaChica where estado = 1 order by fecha desc limit $start,$limit";
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

	public static function getSalidasByPage($start,$limit){
		$start--;
		$sql = "select * from salidaCajaChica where estado = 1 order by fecha desc limit $start,$limit";
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


}

?>
