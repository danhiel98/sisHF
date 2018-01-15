<?php
class TraspasoData {
	public static $tablename = "traspaso";

	public function TraspasoData(){
		#Datos generales del traspaso
		$this->idorigen = "";
		$this->iddestino = "";
		$this->idusuario = "";
		$this->fecha = "NOW()";

		#Realizar el traspaso de cada producto
		$this->idtraspaso = "";
		$this->idproducto = "";
		$this->cantidad = "";
	}

	public function getSucursalO(){ return SucursalData::getById($this->idorigen);}
	public function getSucursalD(){ return SucursalData::getById($this->iddestino);}
	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getProduct(){ return ProductData::getById($this->idproducto);}
	public function getTraspaso(){ return TraspasoData::getById($this->idtraspaso);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idSucursalOrigen, idSucursalDestino, fecha) ";
		$sql .= "values ($this->idusuario, $this->idorigen, $this->iddestino, $this->fecha)";
		return Executor::doit($sql);
	}

	public function addTraspasoProd(){
		$sql = "insert into traspasoProducto (idTraspaso, idProducto, cantidad) ";
		$sql .= "values ($this->idtraspaso, $this->idproducto, $this->cantidad)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idTraspaso = $id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idTraspaso = $this->id";
		Executor::doit($sql);
	}

	
	public function update(){
		$sql = "update ".self::$tablename." set idSucursalOrigen=$this->idorigen, idSucursalDestino=$this->destino where idTraspaso = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idTraspaso = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new TraspasoData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idTraspaso'];
			$data->idorigen = $r['idSucursalOrigen'];
			$data->iddestino = $r['idSucursalDestino'];
			$data->idusuario = $r['idUsuario'];
			$data->fecha = $r['fecha'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllProductsByTraspasoId($id){
		$sql = "select * from traspasoProducto where idTraspaso = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->idtraspasoprod = $r['idTraspasoProducto'];
			$array[$cnt]->idtraspaso = $r['idTraspaso'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllTraspasosByProductId($id){
		$sql = "select * from traspasoProducto where idProducto = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->idtraspasoprod = $r['idTraspasoProducto'];
			$array[$cnt]->idtraspaso = $r['idTraspaso'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->id = $r['idTraspaso'];
			$array[$cnt]->idorigen = $r['idSucursalOrigen'];
			$array[$cnt]->iddestino = $r['idSucursalDestino'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where idTraspaso >= $start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->id = $r['idTraspaso'];
			$array[$cnt]->idorigen = $r['idSucursalOrigen'];
			$array[$cnt]->iddestino = $r['idSucursalDestino'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySuc($id){
		$sql = "select * from ".self::$tablename." where (idSucursalOrigen = $id or idSucursalDestino = $id) and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->id = $r['idTraspaso'];
			$array[$cnt]->idorigen = $r['idSucursalOrigen'];
			$array[$cnt]->iddestino = $r['idSucursalDestino'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucPage($idSuc,$start,$limit){
		$start--;
		$sql = "select * from ".self::$tablename." where (idSucursalOrigen = $idSuc or idSucursalDestino = $idSuc) and estado = 1 limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new TraspasoData();
			$array[$cnt]->id = $r['idTraspaso'];
			$array[$cnt]->idorigen = $r['idSucursalOrigen'];
			$array[$cnt]->iddestino = $r['idSucursalDestino'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

}

?>
