<?php
class AbonoData {
	public static $tablename = "abono";

	public function AbonoData(){
        $this->idusuario = "";
        $this->idcliente = "";
        $this->idpedido = "";
		$this->cantidad = "";
		$this->fecha = "NOW()";
        $this->tipocomprobante = "";
        $this->numerocomprobante = "";
	}

    public function getPedido(){return PedidoData::getById($this->idpedido);}
    public function getUser(){return UserData::getById($this->idusuario);}
	public function getClient(){return ClientData::getById($this->idcliente);}
	public function getComprobante(){return ComprobanteData::getById($this->tipocomprobante);}

	public function add(){
		$sql = "insert into abono (idUsuario, idCliente, idPedido, cantidad, fecha, tipoComprobante, numeroComprobante) ";
		$sql .= "values ($this->idusuario,$this->idcliente,\"$this->idpedido\",\"$this->cantidad\",$this->fecha,\"$this->tipocomprobante\",\"$this->numerocomprobante\")";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idCliente=\"$this->idcliente\", idPedido=\"$this->idpedido\", cantidad=\"$this->cantidad\", fecha=\"$this->fecha\", tipoComprobante=\"$this->tipocomprobante\", numeroComprobante=\"$this->numerocomprobante\" where idAbono = $this->id";
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
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByPedidoId($id){
		$sql = "select * from ".self::$tablename." where idPedido = $id order by fecha desc";
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
			$cnt++;
		}
		return $array;
    }
    
}

?>
