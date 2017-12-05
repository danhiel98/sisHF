<?php
class FacturaData {
	public static $tablename = "facturaVenta";

	public function FacturaData(){
		$this->numerofactura = "";
		$this->idcliente = "";
		$this->idusuario = "";
		$this->idsucursal = "";
		$this->tipo = "Factura";
		$this->idcierrecaja = "";
		#$this->fecha = "NOW()";

		$this->idfactura = "";
		$this->idproducto = "";
		$this->idservicio = "";
		$this->cantidad = "";
		$this->mantenimiento = "";
		$this->total = "";
	}

	public function getFact(){ return FacturaData::getById($this->idfactura);}
	public function getClient(){ return ClientData::getById($this->idcliente);}
	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getService(){ return ServiceData::getById($this->idservicio);}

	public function add(){
		$sql = "insert into ".self::$tablename." (numeroFactura, idCliente, idUsuario, idSucursal, tipo)";
		$sql .= "value (\"$this->numerofactura\",$this->idcliente,$this->idusuario,$this->idsucursal,\"$this->tipo\")";
		return Executor::doit($sql);
	}

	public function addProdV(){
		$sql = "insert into ventaProducto (idFacturaVenta, idProducto, cantidad, mantenimiento, total)";
		$sql .= "value ($this->idfactura,$this->idproducto,$this->cantidad,$this->mantenimiento,$this->total)";
		return Executor::doit($sql);
	}

	public function addServV(){
		$sql = "insert into ventaServicio(idFacturaVenta, idServicio, cantidad, total)";
		$sql .= "value ($this->idfactura,$this->idservicio,$this->cantidad,$this->total)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update_box(){
		$sql = "update ".self::$tablename." set idCierreCaja=$this->idcierrecaja where idFacturaVenta=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idFacturaVenta=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new FacturaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idFacturaVenta'];
			$data->numerofactura = $r['numeroFactura'];
			$data->idusuario = $r['idUsuario'];
			$data->idcliente = $r['idCliente'];
			$data->tipo = $r['tipo'];
			$data->fecha = $r['fecha'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllSellsByFactId($id){
		$sql = "select * from ventaProducto where idFacturaVenta = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->idventa = $r['idVentaProducto'];
			$array[$cnt]->idfactura = $r['idFacturaVenta'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->total = $r['total'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllServicesByFactId($id){
		$sql = "select * from ventaServicio where idFacturaVenta = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->idventa = $r['idVentaServicio'];
			$array[$cnt]->idfactura = $r['idFacturaVenta'];
			$array[$cnt]->idservicio = $r['idServicio'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->total = $r['total'];
			$cnt++;
		}
		return $array;
	}

	public static function getFacturas(){
		$sql = "select * from ".self::$tablename." order by fecha desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getBetweenDates($start,$end){
		$sql = "select * from ".self::$tablename." where date(fecha) between '$start' and '$end' order by fecha desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getSellsUnBoxed(){
		$sql = "select * from ".self::$tablename." where idCierreCaja IS NULL";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getSellsBoxed(){
		$sql = "select * from ".self::$tablename." where idCierreCaja IS NOT NULL";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getByBoxId($id){
		$sql = "select * from ".self::$tablename." where idCierreCaja = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getRes(){
		$sql = "select * from ".self::$tablename." where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SellData();
			$array[$cnt]->id = $r['id'];
		$array[$cnt]->person_id = $r['person_id'];
			$array[$cnt]->user_id = $r['user_id'];
				$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

		public static function getBetweenDates($start,$end){
		$sql = "select * from ".self::$tablename." where date(fecha) between '$start' and '$end' order by fecha desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new FacturaData();
			$array[$cnt]->id = $r['idFacturaVenta'];
			$array[$cnt]->numerofactura = $r['numeroFactura'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->tipo = $r['tipo'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new SellData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->person_id = $r['person_id'];
			$array[$cnt]->user_id = $r['user_id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

}

?>
