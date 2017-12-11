<?php
class SucursalData {
	public static $tablename = "sucursal";

	public function SucursalData(){
		$this->nombre = "";
		$this->direccion = "";
		$this->telefono = "";
	}

	public function add(){
		$sql = "insert into sucursal (nombre, direccion, telefono) ";
		$sql .= "values (\"$this->nombre\",\"$this->direccion\",\"$this->telefono\")";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idSucursal = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idSucursal = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", direccion=\"$this->direccion\", telefono=\"$this->telefono\" where idSucursal = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new SucursalData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idSucursal'];
			$data->nombre = $r['nombre'];
			$data->direccion = $r['direccion'];
			$data->telefono = $r['telefono'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SucursalData();
			$array[$cnt]->id = $r['idSucursal'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
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
			$array[$cnt] = new SucursalData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$cnt++;
		}
		return $array;
	}
}

?>
