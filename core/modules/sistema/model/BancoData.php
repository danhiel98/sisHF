<?php
class BancoData {
	public static $tablename = "banco";

	public function BancoData(){
		$this->nombre = "";
		$this->direccion = "";
		$this->telefono = "";
	}

	public function add(){
		$sql = "insert into banco (idUsuario,nombre, direccion, telefono) ";
		$sql .= "values ($this->idusuario,\"$this->nombre\",\"$this->direccion\",\"$this->telefono\")";
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

// partiendo de que ya tenemos creado un objecto ClientData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", direccion=\"$this->direccion\", telefono=\"$this->telefono\" where idBanco = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idBanco = $id and estado = 1";
		$query = Executor::doit($sql);
		$found = null;
		$data = new BancoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idBanco'];
			$data->nombre = $r['nombre'];
			$data->direccion = $r['direccion'];
			$data->telefono = $r['telefono'];
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
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
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
			$cnt++;
		}
		return $array;
	}
}

?>
