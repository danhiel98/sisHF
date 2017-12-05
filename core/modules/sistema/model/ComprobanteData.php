<?php
class ComprobanteData {
	public static $tablename = "tipoComprobante";

	public function ComprobanteData(){
		$this->nombre = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (nombre) ";
		$sql .= "values (\"$this->nombre\")";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\" where idTipo = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idTipo = $id";
		$query = Executor::doit($sql);
			$found = null;
			$data = new ReabastecimientoData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['idTipo'];
				$data->nombre = $r['nombre'];
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
			$array[$cnt] = new ComprobanteData();
			$array[$cnt]->id = $r['idTipo'];
			$array[$cnt]->nombre = $r['nombre'];
			$cnt++;
		}
		return $array;
	}

}

?>
