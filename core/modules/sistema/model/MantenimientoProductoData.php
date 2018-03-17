<?php
class MantenimientoProductoData {
	public static $tablename = "mantenimientoProducto";

	public function MantenimientoProductoData(){
		$this->idmantenimiento = "";
		$this->idproducto = "";
	}

	public function getProducto(){return ProductData::getById($this->idproducto);}
	public function getMantenimiento(){return MantenimientoProductoData::getById($this->idmanteniminto);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idMantenimiento, idProducto) ";
		$sql .= "values($this->idmantenimiento,$this->idproducto)";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idMantenimientoProducto = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idMantenimientoProducto = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new MantenimientoProductoData();
		while($r = $query[0]->fetch_array()){
            $data->id = $r['idMantenimiento'];
			$data->idmantenimiento = $r['idMantenimiento'];
			$data->idproducto = $r['idProducto'];
			$data->estado = $r['estado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByManttoId($id){
		$sql = "select * from ".self::$tablename." where idMantenimiento = $id and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MantenimientoProductoData();
			$array[$cnt]->id = $r['idMantenimiento'];
			$array[$cnt]->idmantenimiento = $r['idMantenimiento'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MantenimientoProductoData();
			$array[$cnt]->id = $r['idMantenimiento'];
			$array[$cnt]->idmantenimiento = $r['idMantenimiento'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}
}

?>
