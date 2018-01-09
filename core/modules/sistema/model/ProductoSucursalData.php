<?php
class ProductoSucursalData {
	public static $tablename = "productoSucursal";

	public function ProductoSucursalData(){
		$this->cantidad = 0;
	}

	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getSucursal(){ return SucursalData::getById($this->idsucursal);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idSucursal, idProducto, minimo, cantidad) ";
		$sql .= "values ($this->idsucursal, $this->idproducto, $this->minimo, $this->cantidad)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idSucursal = $this->idsucursal, idProducto = $this->idproducto, minimo = $this->minimo, cantidad = $this->cantidad where idProductoSucursal = $this->id";
		return Executor::doit($sql);
	}

	public function updateEx(){
		$sql = "update ".self::$tablename." set cantidad = $this->cantidad where idProductoSucursal = $this->id";
		return Executor::doit($sql);
	}

	public function updateMin(){
		$sql = "update ".self::$tablename." set minimo = $this->minimo where idProductoSucursal = $this->id";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idProductoSucursal = $id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idProductoSucursal = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductoSucursalData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idProductoSucursal'];
			$data->idsucursal = $r['idSucursal'];
			$data->idproducto = $r['idProducto'];
			$data->minimo = $r['minimo'];
			$data->cantidad = $r['cantidad'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getBySucursalProducto($idsucursal,$idproducto){
		$sql = "select * from ".self::$tablename." where idSucursal = $idsucursal and idProducto = $idproducto";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductoSucursalData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idProductoSucursal'];
			$data->idsucursal = $r['idSucursal'];
			$data->idproducto = $r['idProducto'];
			$data->minimo = $r['minimo'];
			$data->cantidad = $r['cantidad'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllByProductId($id){
		$sql = "select * from ".self::$tablename." where idProducto = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductoSucursalData();
			$array[$cnt]->id = $r['idProductoSucursal'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucId($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductoSucursalData();
			$array[$cnt]->id = $r['idProductoSucursal'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllForSell($idsuc){
		$sql = "select * from ".self::$tablename." where idSucursal = $idsuc AND cantidad > 0";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductoSucursalData();
			$array[$cnt]->id = $r['idProductoSucursal'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductoSucursalData();
			$array[$cnt]->id = $r['idProductoSucursal'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->minimo = $r['minimo'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

}

?>
