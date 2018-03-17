<?php
class MantenimientoData {
	public static $tablename = "mantenimiento";

	public function MantenimientoData(){
		$this->idfactura = "null";
		$this->idpedido = "null";
		$this->idproducto = "";
		$this->idsucursal = "";
        $this->idusuario = "";
		$this->title = "";
		$this->url = "ajax/calendar/modal.php";
		$this->class = "";
		$this->start = "";
		$this->end = "";
	}

	public function getFactura(){return FacturaData::getById($this->idfactura);}
	public function getPedido(){return PedidoData::getById($this->idpedido);}
	public function getProduct(){return ProductData::getById($this->idproducto);}
	public function getUser(){return UserData::getById($this->idusuario);}
	public function getSucursal(){return SucursalData::getById($this->idsucursal);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idFactura, idPedido, idProducto, idSucursal, idUsuario, title, start, end, url) ";
		$sql .= "values($this->idfactura, $this->idpedido, $this->idproducto, $this->idsucursal, $this->idusuario, \"$this->title\", \"$this->start\", \"$this->end\", \"$this->url\")";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set title = \"$this->title\" where idMantenimiento = $this->id";
		Executor::doit($sql);
	}

	public function finish(){
		$sql = "update ".self::$tablename." set realizado = 1, fechaRealizado = NOW(), class=\"event-success\" where idMantenimiento = $this->id";
		Executor::doit($sql);
	}

	public function revert(){
		$sql = "update ".self::$tablename." set realizado = 0, fechaRealizado = NULL, class=\"event-info\" where idMantenimiento = $this->id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idMantenimiento = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idMantenimiento = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new MantenimientoData();
		while($r = $query[0]->fetch_array()){
            $data->id = $r['idMantenimiento'];
			$data->idfactura = $r['idFactura'];
			$data->idpedido = $r['idPedido'];
			$data->idproducto = $r['idProducto'];
            $data->idsucursal = $r['idSucursal'];
            $data->idusuario = $r['idUsuario'];
            $data->title = $r['title'];
            $data->url = $r['url'];
            $data->class = $r['class'];
			$data->start = $r['start'];
			$data->end = $r['end'];
			$data->realizado = $r['realizado'];
			$data->fecharealizado = $r['fechaRealizado'];
			$data->fecharegistro = $r['fechaRegistro'];
			$data->estado = $r['estado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByIdFactura($id){
		$sql = "select * from ".self::$tablename." where idFactura = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new MantenimientoData();
		while($r = $query[0]->fetch_array()){
            $data->id = $r['idMantenimiento'];
			$data->idfactura = $r['idFactura'];
			$data->idpedido = $r['idPedido'];
			$data->idproducto = $r['idProducto'];
            $data->idsucursal = $r['idSucursal'];
            $data->idusuario = $r['idUsuario'];
            $data->title = $r['title'];
            $data->url = $r['url'];
            $data->class = $r['class'];
			$data->start = $r['start'];
			$data->end = $r['end'];
			$data->realizado = $r['realizado'];
			$data->fecharealizado = $r['fechaRealizado'];
			$data->fecharegistro = $r['fechaRegistro'];
			$data->estado = $r['estado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByIdPedido($id){
		$sql = "select * from ".self::$tablename." where idPedido = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new MantenimientoData();
		while($r = $query[0]->fetch_array()){
            $data->id = $r['idMantenimiento'];
			$data->idfactura = $r['idFactura'];
			$data->idpedido = $r['idPedido'];
			$data->idproducto = $r['idProducto'];
            $data->idsucursal = $r['idSucursal'];
            $data->idusuario = $r['idUsuario'];
            $data->title = $r['title'];
            $data->url = $r['url'];
            $data->class = $r['class'];
			$data->start = $r['start'];
			$data->end = $r['end'];
			$data->realizado = $r['realizado'];
			$data->fecharealizado = $r['fechaRealizado'];
			$data->fecharegistro = $r['fechaRegistro'];
			$data->estado = $r['estado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from manttoProds";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MantenimientoData();
			$array[$cnt]->id = $r['idMantenimiento'];
			$array[$cnt]->idfactura = $r['idFactura'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idproducto = $r['idProducto'];
            $array[$cnt]->idsucursal = $r['idSucursal'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->title = $r['title'];
            $array[$cnt]->url = $r['url'];
            $array[$cnt]->class = $r['class'];
			$array[$cnt]->start = $r['start'];
			$array[$cnt]->end = $r['end'];
			$array[$cnt]->fecha = $r['fecha']; #Esa fecha NO irá formateada como start y end
			$array[$cnt]->realizado = $r['realizado'];
			$array[$cnt]->fecharealizado = $r['fechaRealizado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucId($id){
		$sql = "select * from manttoProds where idSucursal = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MantenimientoData();
			$array[$cnt]->id = $r['idMantenimiento'];
			$array[$cnt]->idfactura = $r['idFactura'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idproducto = $r['idProducto'];
            $array[$cnt]->idsucursal = $r['idSucursal'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->title = $r['title'];
            $array[$cnt]->url = $r['url'];
            $array[$cnt]->class = $r['class'];
			$array[$cnt]->start = $r['start'];
			$array[$cnt]->end = $r['end'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->realizado = $r['realizado'];
			$array[$cnt]->fecharealizado = $r['fechaRealizado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

	public static function getForCalendar($meses,$idSuc){
		$sql = "SELECT * from mantenimiento WHERE start BETWEEN now() and DATE_ADD(now(),INTERVAL $meses MONTH) and idSucursal = $idSuc and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new MantenimientoData();
			$array[$cnt]->id = $r['idMantenimiento'];
			$array[$cnt]->idfactura = $r['idFactura'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idproducto = $r['idProducto'];
            $array[$cnt]->idsucursal = $r['idSucursal'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->title = $r['title'];
            $array[$cnt]->url = $r['url'];
            $array[$cnt]->class = $r['class'];
			$array[$cnt]->start = $r['start'];
			$array[$cnt]->end = $r['end'];
			$array[$cnt]->realizado = $r['realizado'];
			$array[$cnt]->fecharealizado = $r['fechaRealizado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

}

?>
