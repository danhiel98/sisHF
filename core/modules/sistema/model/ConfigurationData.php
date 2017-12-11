<?php
class ConfigurationData {
	public static $tablename = "configuraciones";

	public function ConfigurationData(){
		$this->name = "";
		$this->value = "";
	}

	public function add(){
		$sql = "insert into configuracion (nombre, valor) ";
		$sql .= "value (\"$this->name\",\"$this->value)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where idConfig=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where idConfig=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->name\" where idConfig=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idConfig=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ConfigurationData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idConfig'];
			$data->name = $r['nombre'];
			$data->value = $r['valor'];
			break;
		}
		return $found;
	}

	public static function getByName($name){
		$sql = "select * from ".self::$tablename." where nombre=\"$name\"";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ConfigurationData();
			$array[$cnt]->id = $r['idConfig'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->value = $r['valor'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ConfigurationData();
			$array[$cnt]->id = $r['idConfig'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->value = $r['valor'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ConfigurationData();
			$array[$cnt]->id = $r['idConfig'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->value = $r['valor'];
			$cnt++;
		}
		return $array;
	}


}

?>