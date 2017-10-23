<?php
class CategoryData {
	public static $tablename = "categoria";

	public function CategoryData(){
		$this->nombre = "";
		$this->idusuario = "";
		$this->fecha = "NOW()";
	}

	public function add(){
		$sql = "insert into categoria (idUsuario,nombre,fecha) ";
		$sql .= "value ($this->idusuario,\"$this->nombre\",\"$this->fecha\")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

// partiendo de que ya tenemos creado un objecto CategoryData previamente utilizamos el contexto
	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\" where idCategoria = $this->id";
		Executor::doit($sql);
	}


	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idCategoria=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new CategoryData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCategoria'];
			$data->nombre = $r['nombre'];
			$data->idusuario = $r['idUsuario'];
			$data->fecha = $r['fecha'];
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
			$array[$cnt] = new CategoryData();
			$array[$cnt]->id = $r['idCategoria'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CategoryData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['name'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}


}

?>
