<?php
class ServiceData {
	public static $tablename = "servicio";

	public function ServiceData(){
		$this->nombre = "";
		$this->descripcion = "";
		$this->precio = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, nombre, descripcion, precio)";
		$sql .= "values ($this->idusuario,\"$this->nombre\",\"$this->descripcion\",\"$this->precio\")";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idServicio=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idServicio=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", descripcion=\"$this->descripcion\", precio=\"$this->precio\" where idServicio=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idServicio=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ServiceData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idServicio'];
			$data->nombre = $r['nombre'];
			$data->descripcion = $r['descripcion'];
			$data->precio = $r['precio'];
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
			$array[$cnt] = new ServiceData();
			$array[$cnt]->id = $r['idServicio'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->precio = $r['precio'];
			$cnt++;
		}
		return $array;
	}


	public static function getByPage($start, $limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 order by idServicio desc limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ServiceData();
			$array[$cnt]->id = $r['idServicio'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->precio = $r['precio'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($p){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($p);
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' or descripcion like '%$p%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ServiceData();
			$array[$cnt]->id = $r['idServicio'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->precio = $r['precio'];
			$cnt++;
		}
		return $array;
	}
}
?>
