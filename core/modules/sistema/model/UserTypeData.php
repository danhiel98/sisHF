<?php
class UserTypeData {
	public static $tablename = "tipoUsuario";

	public function UserTypeData(){
		$this->nombre = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (nombre) ";
		$sql .= "values (\"$this->nombre\")";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set activo = 0 where idTipo = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set activo = 0 where idTipo = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\"";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idTipo = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserTypeData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idTipo'];
			$data->nombre = $r['nombre'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where idTipo != 1 AND activo = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserTypeData();
			$array[$cnt]->id = $r['idTipo'];
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where nombre like '%$q%' and activo = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserTypeData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}
}

?>
