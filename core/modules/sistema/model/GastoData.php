<?php
class GastoData {
	public static $tablename = "gasto";

	public function GastoData(){
		$this->idusuario = "";
		$this->descripcion = "";
		$this->comprobante = "";
		$this->pago = "";
	}
public function getUsuario(){ return UserData::getById($this->idusuario);}
	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, descripcion, pago, numeroComprobante, fecha)";
		$sql .= "value ($this->idusuario,\"$this->descripcion\",\"$this->pago\", \"$this->comprobante\", NOW())";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idGasto = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idGasto = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set descripcion=\"$this->descripcion\", pago=\"$this->pago\", numeroComprobante=\"$this->comprobante\"  where idGasto = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idGasto=$id and estado = 1";
		$query = Executor::doit($sql);
		$found = null;
		$data = new GastoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idGasto'];
			$data->idusuario = $r['idUsuario'];
			$data->descripcion = $r['descripcion'];
			$data->pago = $r['pago'];
			$data->comprobante = $r['numeroComprobante'];
			$data->fecha = $r['fecha'];
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
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}


	public static function getAllByPage($start_from, $limit){
		$sql = "select * from ".self::$tablename." where idGasto>=$start_from and estado = 1 limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' or idGasto like '%$p%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}
}
?>