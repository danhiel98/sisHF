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
		$this->fechaFinalizado = "";

		$this->idproducto = "";
		$this->idservicio = "";
		$this->cantidad = "";
		$this->mantenimiento = "";
		$this->total = "";
	}

	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getClient(){ return ClientData::getById($this->idcliente);}
	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getService(){ return ServiceData::getById($this->idservicio);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idSucursal, idCliente, fechaPedido, fechaEntrega) ";
		$sql .= "value ($this->idusuario,$this->idsucursal,$this->idcliente,$this->fechapedido,\"$this->fechaentrega\")";
		return Executor::doit($sql);
	}

	public function addProdPd(){
		$sql = "insert into pedidoProducto (idPedido, idProducto, cantidad, mantenimiento, total)";
		$sql .= "value ($this->idpedido,$this->idproducto,$this->cantidad,$this->mantenimiento,$this->total)";
		return Executor::doit($sql);
	}

	public function addServPd(){
		$sql = "insert into pedidoServicio(idPedido, idServicio, cantidad, total)";
		$sql .= "value ($this->idpedido,$this->idservicio,$this->cantidad,$this->total)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idPedido=$id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\",price_in=\"$this->price_in\",price_out=\"$this->price_out\",unit=\"$this->unit\",presentation=\"$this->presentation\",category_id=$this->category_id,inventary_min=\"$this->inventary_min\",description=\"$this->description\",is_active=\"$this->is_active\" where id=$this->id";
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
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
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
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

}

?>
