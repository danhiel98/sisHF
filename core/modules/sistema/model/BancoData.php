<?php
class BancoData {
	public static $tablename = "banco";

	public function BancoData(){
		$this->nombre = "";
		$this->direccion = "";
		$this->telefono = "";
		$this->numCuenta = "";
	}

	public function add(){
		$sql = "insert into banco (idUsuario,nombre, direccion, telefono, numeroCuenta) ";
		$sql .= "values ($this->idusuario,\"$this->nombre\",\"$this->direccion\",\"$this->telefono\",\"$this->numCuenta\")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idBanco = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idBanco = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", direccion=\"$this->direccion\", telefono=\"$this->telefono\", numeroCuenta=\"$this->numCuenta\" where idBanco = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idBanco = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new BancoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idBanco'];
			$data->nombre = $r['nombre'];
			$data->direccion = $r['direccion'];
			$data->telefono = $r['telefono'];
			$data->numCuenta = $r['numeroCuenta'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BancoData();
			$array[$cnt]->id = $r['idBanco'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->numCuenta = $r['numeroCuenta'];
			$cnt++;
		}
		return $array;
	}

	public static function getByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 order by idBanco desc limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BancoData();
			$array[$cnt]->id = $r['idBanco'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->numCuenta = $r['numeroCuenta'];
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
			$array[$cnt] = new BancoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->numCuenta = $r['numeroCuenta'];
			$cnt++;
		}
		return $array;
	}
}

?>
