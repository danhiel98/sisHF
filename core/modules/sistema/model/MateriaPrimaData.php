<?php
class MateriaPrimaData {
	public static $tablename = "materiaPrima";

	public function MateriaPrimaData(){
		$this->nombre = "";
		$this->descripcion = "";
		$this->minimo = "";
		$this->existencias = "";
		#$this->precio = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, nombre, descripcion, minimo)";
		$sql .= "values ($this->idusuario,\"$this->nombre\",\"$this->descripcion\",$this->minimo)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", descripcion=\"$this->descripcion\", minimo=$this->minimo where idMateriaPrima = $this->id";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idMateriaPrima = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idMateriaPrima = $this->id";
		Executor::doit($sql);
	}

	public function updateEx(){
		$sql = "update ".self::$tablename." set existencias = $this->existencias where idMateriaPrima = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idMateriaPrima=$id and estado = 1";
		$query = Executor::doit($sql);
		$found = null;
		$data = new MateriaPrimaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idMateriaPrima'];
			$data->nombre = $r['nombre'];
			$data->descripcion = $r['descripcion'];
			$data->minimo = $r['minimo'];
			$data->existencias = $r['existencias'];
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
			$array[$cnt] = new MateriaPrimaData();
			$array[$cnt]->id = $r['idMateriaPrima'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->existencias = $r['existencias'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start, $limit){
		$start--;
		$sql = "select * from ".self::$tablename." where estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MateriaPrimaData();
			$array[$cnt]->id = $r['idMateriaPrima'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->existencias = $r['existencias'];
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
			$array[$cnt] = new MateriaPrimaData();
			$array[$cnt]->id = $r['idMateriaPrima'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->existencias = $r['existencias'];
			$cnt++;
		}
		return $array;
	}
}
?>
