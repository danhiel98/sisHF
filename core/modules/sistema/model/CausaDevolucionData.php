<?php
class CausaDevolucionData {
	public static $tablename = "causaDevolucion";

	public function CausaDevolucionData(){
		$this->idusuario = "";
		$this->fecha = "";
		$this->descripcion = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario,fecha,descripcion,estado) ";
		$sql .= "values ($this->idusuario,\"$this->fecha\",\"$this->descripcion\")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idCausa = $id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idCausa = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set descripcion=\"$this->descripcion\" where idCausa = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idCausa = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new CausaDevolucionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCausa'];
			$data->idusuario = $r['idUsuario'];
			$data->fecha = $r['fecha'];
			$data->descripcion = $r['descripcion'];
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
			$array[$cnt] = new CausaDevolucionData();
			$array[$cnt]->id = $r['idCausa'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$cnt++;
		}
		return $array;
	}

	public static function getByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new CausaDevolucionData();
			$array[$cnt]->id = $r['idCausa'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$cnt++;
		}
		return $array;
	}
	
}

?>
