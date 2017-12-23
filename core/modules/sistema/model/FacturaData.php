<?php
class FacturaData {
	public static $tablename = "facturaVenta";

	public function FacturaData(){
		$this->numerofactura = "";
		$this->idcliente = "";
		$this->idusuario = "";
		$this->idsucursal = "";
		$this->tipoComprobante = "";
		$this->idcierrecaja = "";
		$this->totalLetras = "";

		$this->idfactura = "";
		$this->idproducto = "";
		$this->idservicio = "";
		$this->precio = "";
		$this->cantidad = "";
		$this->mantenimiento = "";
		$this->total = "";
	}

	public function getComprobante(){ return ComprobanteData::getById($this->tipoComprobante);}
	public function getFact(){ return FacturaData::getById($this->idfactura);}
	public function getClient(){ return ClientData::getById($this->idcliente);}
	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getService(){ return ServiceData::getById($this->idservicio);}

	public function add(){
		$sql = "insert into ".self::$tablename." (numeroFactura, idCliente, idUsuario, idSucursal, tipoComprobante, totalLetras)";
		$sql .= "value (\"$this->numerofactura\",$this->idcliente,$this->idusuario,$this->idsucursal,\"$this->tipoComprobante\",\"$this->totalLetras\")";
		return Executor::doit($sql);
	}

	public function addProdV(){
		$sql = "insert into ventaProducto (idFacturaVenta, idProducto, precio, cantidad, mantenimiento, total)";
		$sql .= "value ($this->idfactura,$this->idproducto,\"$this->precio\",$this->cantidad,$this->mantenimiento,$this->total)";
		return Executor::doit($sql);
	}

	public function addServV(){
		$sql = "insert into ventaServicio(idFacturaVenta, idServicio, precio, cantidad, total)";
		$sql .= "value ($this->idfactura,$this->idservicio,\"$this->precio\",$this->cantidad,$this->total)";
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
			$data->tipoComprobante = $r['tipoComprobante'];
			$data->totalLetras = $r['totalLetras'];
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
			$array[$cnt]->precio = $r['precio'];
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
			$array[$cnt]->precio = $r['precio'];
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
			$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
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
			$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
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
			$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
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
			$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
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
			$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getLastRecibo(){
		$sqlVenta = "select max(numeroFactura) as lastRecibo from facturaventa where tipoComprobante = 3";
		$query = Executor::doit($sqlVenta);
		while($r = $query[0]->fetch_array()){
			$reciboVenta = $r['lastRecibo'];
			break;
		}

		$sqlAbono = "select max(numeroComprobante) as lastRecibo from abono where tipoComprobante = 3";
		$query = Executor::doit($sqlAbono);
		while($r = $query[0]->fetch_array()){
			$reciboAbono = $r['lastRecibo'];
			break;
		}

		return max($reciboAbono, $reciboVenta);

	}

	public static function getByNumber($num){
		$sql = "select * from ".self::$tablename." where numeroFactura = $num";
		$query = Executor::doit($sql);
		$found = null;
		$data = new FacturaData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idFacturaVenta'];
			$data->numerofactura = $r['numeroFactura'];
			$data->idusuario = $r['idUsuario'];
			$data->idcliente = $r['idCliente'];
			$data->tipoComprobante = $r['tipoComprobante'];
			$data->totalLetras = $r['totalLetras'];
			$data->fecha = $r['fecha'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByFactProduct($idFact,$idProd){
		$sql = "select * from ventaproducto where idFacturaVenta = $idFact AND idProducto = $idProd";
		$query = Executor::doit($sql);
		$found = null;
		$data = new FacturaData();
		while($r = $query[0]->fetch_array()){
			$data->idventa = $r['idVentaProducto'];
			$data->idfactura = $r['idFacturaVenta'];
			$data->idproducto = $r['idProducto'];
			$data->precio = $r['precio'];
			$data->cantidad = $r['cantidad'];
			$data->total = $r['total'];
			$found = $data;
			break;
		}
		return $found;
	}

}

?>
