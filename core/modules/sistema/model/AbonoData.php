<?php
class AbonoData {
	public static $tablename = "abono";

	public function AbonoData(){
		$this->idsucursal = "";
        $this->idusuario = "";
        $this->idcliente = "";
        $this->idpedido = "";
		$this->cantidad = "";
		$this->fecha = "NOW()";
        $this->tipocomprobante = "";
		$this->numerocomprobante = "";
		$this->totalLetras = "";
	}

    public function getPedido(){return PedidoData::getById($this->idpedido);}
    public function getUser(){return UserData::getById($this->idusuario);}
	public function getClient(){return ClientData::getById($this->idcliente);}
	public function getComprobante(){return ComprobanteData::getById($this->tipocomprobante);}

	public function add(){
		$sql = "insert into abono (idSucursal, idUsuario, idCliente, idPedido, cantidad, fecha, tipoComprobante, numeroComprobante, totalLetras) ";
		$sql .= "values ($this->idsucursal,$this->idusuario,$this->idcliente,\"$this->idpedido\",\"$this->cantidad\",$this->fecha,\"$this->tipocomprobante\",\"$this->numerocomprobante\",\"$this->totalLetras\")";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idCliente=\"$this->idcliente\", idPedido=\"$this->idpedido\", cantidad=\"$this->cantidad\", fecha=\"$this->fecha\", tipoComprobante=\"$this->tipocomprobante\", numeroComprobante=\"$this->numerocomprobante\", totalLetras=\"$this->totalLetras\" where idAbono = $this->id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idAbono = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idAbono = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new AbonoData();
		while($r = $query[0]->fetch_array()){
            $data->id = $r['idAbono'];
            $data->idusuario = $r['idUsuario'];
            $data->idcliente = $r['idCliente'];
            $data->idpedido = $r['idPedido'];
            $data->cantidad = $r['cantidad'];
            $data->fecha = $r['fecha'];
            $data->tipocomprobante = $r['tipoComprobante'];
			$data->numerocomprobante = $r['numeroComprobante'];
			$data->totalLetras = $r['totalLetras'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByPedidoId($id){
		$sql = "select * from ".self::$tablename." where idPedido = $id and estado = 1 order by fecha";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new AbonoData();
			$array[$cnt]->id = $r['idAbono'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->idcliente = $r['idCliente'];
            $array[$cnt]->idpedido = $r['idPedido'];
            $array[$cnt]->cantidad = $r['cantidad'];
            $array[$cnt]->fecha = $r['fecha'];
            $array[$cnt]->tipocomprobante = $r['tipoComprobante'];
			$array[$cnt]->numerocomprobante = $r['numeroComprobante'];
			$array[$cnt]->totalLetras = $r['totalLetras'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where estado = 1 order by fecha desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new AbonoData();
			$array[$cnt]->id = $r['idAbono'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->idcliente = $r['idCliente'];
            $array[$cnt]->idpedido = $r['idPedido'];
            $array[$cnt]->cantidad = $r['cantidad'];
            $array[$cnt]->fecha = $r['fecha'];
            $array[$cnt]->tipocomprobante = $r['tipoComprobante'];
			$array[$cnt]->numerocomprobante = $r['numeroComprobante'];
			$array[$cnt]->totalLetras = $r['totalLetras'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and estado = 1 order by fecha desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new AbonoData();
			$array[$cnt]->id = $r['idAbono'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->idcliente = $r['idCliente'];
            $array[$cnt]->idpedido = $r['idPedido'];
            $array[$cnt]->cantidad = $r['cantidad'];
            $array[$cnt]->fecha = $r['fecha'];
            $array[$cnt]->tipocomprobante = $r['tipoComprobante'];
			$array[$cnt]->numerocomprobante = $r['numeroComprobante'];
			$array[$cnt]->totalLetras = $r['totalLetras'];
			$cnt++;
		}
		return $array;
	}
	
	public static function getByPage($idSuc,$start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where idSucursal = $idSuc and estado = 1 order by fecha desc limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new AbonoData();
			$array[$cnt]->id = $r['idAbono'];
            $array[$cnt]->idusuario = $r['idUsuario'];
            $array[$cnt]->idcliente = $r['idCliente'];
            $array[$cnt]->idpedido = $r['idPedido'];
            $array[$cnt]->cantidad = $r['cantidad'];
            $array[$cnt]->fecha = $r['fecha'];
            $array[$cnt]->tipocomprobante = $r['tipoComprobante'];
			$array[$cnt]->numerocomprobante = $r['numeroComprobante'];
			$array[$cnt]->totalLetras = $r['totalLetras'];
			$cnt++;
		}
		return $array;
    }
    
}

?>
