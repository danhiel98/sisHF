<?php
class PedidoData {
	public static $tablename = "pedido";

	public function PedidoData(){
		$this->idpedido = "";
		$this->idusuario = "";
		$this->idcliente = "";
		$this->idusuario = "";
		$this->fechapedido = "";
		$this->fechaentrega = "";
		$this->entregado = "";
		$this->fechafinalizado = "";
		$this->restante = ""; #Para saber cuanto dinero debe el cliente del pedido

		$this->idproducto = "";
		$this->idservicio = "";
		$this->cantidad = "";
		$this->precio = "";		
		$this->mantenimiento = "";
		$this->total = "";
	}

	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getClient(){ return ClientData::getById($this->idcliente);}
	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getService(){ return ServiceData::getById($this->idservicio);}
	public function getReq(){ return PedidoData::getById($this->idpedido);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idSucursal, idCliente, fechaPedido, fechaEntrega, restante) ";
		$sql .= "value ($this->idusuario,$this->idsucursal,$this->idcliente,$this->fechapedido,\"$this->fechaentrega\",0)";
		return Executor::doit($sql);
	}

	public function addProdPd(){
		$sql = "insert into pedidoProducto (idPedido, idProducto, cantidad, precio, mantenimiento, total)";
		$sql .= "value ($this->idpedido,$this->idproducto,$this->cantidad,$this->precio,$this->mantenimiento,$this->total)";
		return Executor::doit($sql);
	}

	public function addServPd(){
		$sql = "insert into pedidoServicio(idPedido, idServicio, cantidad, precio, total)";
		$sql .= "value ($this->idpedido,$this->idservicio,$this->cantidad,$this->precio,$this->total)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idPedido=$id";
		Executor::doit($sql);
	}

	public function updateRestante(){
		$sql = "update ".self::$tablename." set restante = $this->restante where idPedido=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\",category_id=$this->category_id,inventary_min=\"$this->inventary_min\",description=\"$this->description\",is_active=\"$this->is_active\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function finalizar($id){
		$sql = "update ".self::$tablename." set entregado = 1, fechaFinalizado = NOW() where idPedido=$id;";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idPedido=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new PedidoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idPedido'];
			$data->idusuario = $r['idUsuario'];
			$data->idcliente = $r['idCliente'];
			$data->fechapedido = $r['fechaPedido'];
			$data->fechaentrega = $r['fechaEntrega'];
			$data->entregado = $r['entregado'];
			$data->cancelado = $r['cancelado'];
			$data->fechafinalizado = $r['fechaFinalizado'];
			$data->restante = $r['restante'];
			$data->estado = $r['estado'];
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
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getEntregado(){
		$sql = "select * from ".self::$tablename." where entregado = 1 AND estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getEntregadoBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and entregado = 1 AND estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getEntregadoByPage($idSuc,$start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where idSucursal = $idSuc and entregado = 1 AND estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getPendiente(){
		$sql = "select * from ".self::$tablename." where entregado = 0 AND estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getPendienteBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and entregado = 0 AND estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getPendienteByPage($idSuc, $start, $limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where idSucursal = $idSuc and entregado = 0 AND estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where idPedido>=$start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->id = $r['idPedido'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idcliente = $r['idCliente'];
			$array[$cnt]->fechapedido = $r['fechaPedido'];
			$array[$cnt]->fechaentrega = $r['fechaEntrega'];
			$array[$cnt]->entregado = $r['entregado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->restante = $r['restante'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllProductsByPedidoId($id){
		$sql = "select * from pedidoProducto where idPedido = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->idpedidoproducto = $r['idPedidoProducto'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->precio = $r['precio'];			
			$array[$cnt]->total = $r['total'];
			$array[$cnt]->mantenimiento = $r['mantenimiento'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllServicesByPedidoId($id){
		$sql = "select * from pedidoServicio where idPedido = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->idpedidoservicio = $r['idPedidoServicio'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idservicio = $r['idServicio'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->precio = $r['precio'];
			$array[$cnt]->total = $r['total'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByService($id){
		$sql = "select * from pedidoServicio where idServicio = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new PedidoData();
			$array[$cnt]->idpedidoservicio = $r['idPedidoServicio'];
			$array[$cnt]->idpedido = $r['idPedido'];
			$array[$cnt]->idservicio = $r['idServicio'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->precio = $r['precio'];
			$array[$cnt]->total = $r['total'];
			$cnt++;
		}
		return $array;
	}

}

?>
