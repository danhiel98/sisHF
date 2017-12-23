<?php
class DevolucionData {
	
	public static $tablename = "devolucion";

	public function DevolucionData(){
		$this->idusuaio = "";
		$this->idfactura = "";
		$this->idcausa = "";
		$this->fecha = "";
		$this->reembolso = "";
	}

	public function getFactura(){return FacturaData::getById($this->idfactura);}
	public function getCausa(){return CausaDevolucionData::getById($this->idcausa);}
	public function getUser(){return UserData::getById($this->idusuario);}
	public function getProduct(){return ProductData::getById($this->idproducto);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario,idFacturaVenta,idCausa,fecha,reembolso) ";
		$sql .= "values ($this->idusuario,\"$this->idfactura\",\"$this->idcausa\",$this->fecha,\"$this->reembolso\")";
		return Executor::doit($sql);
	}

	public function addProds(){
		$sql = "insert into productodevolucion (idDevolucion,idProducto,cantidad) ";
		$sql .= "values ($this->iddevolucion,\"$this->idproducto\",\"$this->cantidad\")";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idUsuario=\"$this->idusuario\", idFacturaVenta=\"$this->idfactura\", idCausa=\"$this->idcausa\", fecha=\"$this->fecha\", reembolso=\"$this->reembolso\" where idDevolucion = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idDevolucion = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new DevolucionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idDevolucion'];
			$data->idusuario = $r['idUsuario'];
			$data->idfactura = $r['idFacturaVenta'];
			$data->idcausa = $r['idCausa'];
			$data->fecha = $r['fecha'];
			$data->reembolso = $r['reembolso'];
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
			$array[$cnt] = new DevolucionData();
			$array[$cnt]->id = $r['idDevolucion'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idfactura = $r['idFacturaVenta'];
			$array[$cnt]->idcausa = $r['idCausa'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->reembolso = $r['reembolso'];
			$cnt++;
		}
		return $array;
	}

	public static function getByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DevolucionData();
			$array[$cnt]->id = $r['idDevolucion'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idfactura = $r['idFacturaVenta'];
			$array[$cnt]->idcausa = $r['idCausa'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->reembolso = $r['reembolso'];
			$cnt++;
		}
		return $array;
	}

	public static function getProdsByDev($id){
		$sql = "select * from productoDevolucion where idDevolucion = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DevolucionData();
			$array[$cnt]->idproddev = $r['idProdDev'];
			$array[$cnt]->iddevolucion = $r['idDevolucion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

}

?>
