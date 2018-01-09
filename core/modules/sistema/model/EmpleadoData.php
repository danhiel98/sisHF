<?php
class EmpleadoData {
	public static $tablename = "empleado";

	public function EmpleadoData(){
		$this->dui = "";
		$this->nit = "";
		$this->nombre = "";
		$this->apellido = "";
		$this->sexo = "";
		$this->estadocivil = "";
		$this->fechanacimiento = "";
		$this->nivelacademico = "";
		$this->direccion = "";
		$this->idMunic = "";
		$this->idDepto = "";
		$this->telefono = "";
		$this->area = "";
		$this->idsucursal = "";
	}

	public function getSucursal(){ return SucursalData::getById($this->idsucursal);}

	public function add(){
		$sql = "insert into empleado (dui, nit, nombre, apellido, sexo, estadoCivil, fechaNacimiento, nivelAcademico, direccion, idMunic, idDepto, area, telefono, idSucursal) ";
		$sql .= "values (\"$this->dui\",\"$this->nit\",\"$this->nombre\",\"$this->apellido\",\"$this->sexo\",\"$this->estadocivil\",\"$this->fechanacimiento\",\"$this->nivelacademico\",\"$this->direccion\",\"$this->idMunic\",\"$this->idDepto\",\"$this->area\",\"$this->telefono\",$this->idsucursal)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idEmpleado = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idEmpleado = $this->id";
		Executor::doit($sql);
	}
	
	public function update(){
		$sql = "update ".self::$tablename." set dui=\"$this->dui\", nit=\"$this->nit\", nombre=\"$this->nombre\", apellido=\"$this->apellido\", sexo=\"$this->sexo\", estadoCivil=\"$this->estadocivil\", fechaNacimiento=\"$this->fechanacimiento\", nivelAcademico=\"$this->nivelacademico\", direccion=\"$this->direccion\", idMunic=\"$this->idMunic\", idDepto=\"$this->idDepto\", area=\"$this->area\", telefono=\"$this->telefono\", idSucursal = $this->idsucursal where idEmpleado = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idEmpleado = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new EmpleadoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idEmpleado'];
			$data->dui = $r['dui'];
			$data->nit = $r['nit'];
			$data->nombre = $r['nombre'];
			$data->apellido = $r['apellido'];
			$data->nombrecompleto = $r['nombre']." ".$r['apellido'];
			$data->sexo = $r['sexo'];
			$data->estadocivil = $r['estadoCivil'];
			$data->fechanacimiento = $r['fechaNacimiento'];
			$data->nivelacademico = $r['nivelAcademico'];
			$data->direccion = $r['direccion'];
			$data->idMunic = $r['idMunic'];
			$data->idDepto = $r['idDepto'];
			$data->area = $r['area'];
			$data->telefono = $r['telefono'];
			$data->idsucursal = $r['idSucursal'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where activo = 1 order by idSucursal";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($inicio,$cantidad){
		$inicio = $inicio - 1;
		$sql = "select * from ".self::$tablename." where activo = 1 limit $inicio,$cantidad";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllForUser(){
		$sql = "select * from ".self::$tablename." where idEmpleado not in (select idEmpleado from usuario where idEmpleado is not null)";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllForUserBySucId($id){
		$sql = "select * from ".self::$tablename." where idEmpleado not in (select idEmpleado from usuario where idEmpleado is not null) and idSucursal = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucId($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and activo = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucPage($id,$inicio,$cantidad){
		$inicio = $inicio - 1;
		$sql = "select * from ".self::$tablename." where idSucursal = $id and activo = 1 limit $inicio,$cantidad";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->estadocivil = $r['estadoCivil'];
			$array[$cnt]->fechanacimiento = $r['fechaNacimiento'];
			$array[$cnt]->nivelacademico = $r['nivelAcademico'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->idMunic = $r['idMunic'];
			$array[$cnt]->idDepto = $r['idDepto'];
			$array[$cnt]->area = $r['area'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where nombre like '%$q%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EmpleadoData();
			$array[$cnt]->id = $r['idEmpleado'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->apellido = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$cnt++;
		}
		return $array;
	}
}

?>
