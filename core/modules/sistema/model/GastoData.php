<?php
class GastoData {
	public static $tablename = "gasto";

	public function GastoData(){
		$this->idsucursal = ""; #La sucursal donde se hizo
		$this->idusuario = ""; #Quien registra el gasto
		$this->idempleado = "null"; #Responsable del gasto
		$this->descripcion = "";
		$this->comprobante = "";
		$this->pago = "";
	}
	
	public function getUsuario(){ return UserData::getById($this->idusuario);}
	public function getEmpleado(){ return EmpleadoData::getById($this->idempleado);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idSucursal, idUsuario, idEmpleado, descripcion, pago, numeroComprobante, fecha)";
		$sql .= " value ($this->idsucursal,$this->idusuario,$this->idempleado,\"$this->descripcion\",\"$this->pago\", \"$this->comprobante\", NOW())";
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
		$sql = "update ".self::$tablename." set idEmpleado=$this->idempleado, descripcion=\"$this->descripcion\", pago=\"$this->pago\", numeroComprobante=\"$this->comprobante\"  where idGasto = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idGasto=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new GastoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idGasto'];
			$data->idusuario = $r['idUsuario'];
			$data->idempleado = $r['idEmpleado'];
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
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getByPage($start, $limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id AND estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucPage($id, $start, $limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where idSucursal = $id AND estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->pago = $r['pago'];
			$array[$cnt]->comprobante = $r['numeroComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}


	public static function getLike($p){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($p);
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' or idGasto like '%$p%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new GastoData();
			$array[$cnt]->id = $r['idGasto'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
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
