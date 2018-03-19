<?php
class ProduccionData {
	public static $tablename = "produccion";

	public function ProduccionData(){
		$this->idusuario = "";
		$this->idproducto = "";
		$this->fechainicio = "";
		$this->fechafin = "";
		$this->cantidad = "";
		$this->terminado = "";
		$this->fecharegistro = "NOW()";
		$this->fechafinalizado = "NOW()"; //Se va a utilizar cuando la produccion haya finalizado (terminado)
		$this->estado = "";
	}

	public function getUser(){ return UserData::getById($this->idusuario);}
	public function getProduct(){return ProductData::getById($this->idproducto);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idProducto, fechaInicio, fechaFin, cantidadProducto, fechaRegistro)";
		$sql .= "value ($this->idusuario,$this->idproducto,\"$this->fechainicio\",\"$this->fechafin\",$this->cantidad,$this->fecharegistro)";
		return Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idProducto=$this->idproducto, fechaInicio=\"$this->fechainicio\", fechaFin=\"$this->fechafin\", cantidadProducto=$this->cantidad where idProduccion=$this->id";
		return Executor::doit($sql);
	}

	public function finalizar(){
		$sql = "update ".self::$tablename." set terminado = 1, fechaFinalizado = NOW() where idProduccion=$this->id;";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idProduccion = $this->id;";
		return Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idProduccion = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProduccionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idProduccion'];
			$data->idusuario = $r['idUsuario'];
			$data->idproducto = $r['idProducto'];
			$data->fechainicio = $r['fechaInicio'];
			$data->fechafin = $r['fechaFin'];
			$data->cantidad = $r['cantidadProducto'];
			$data->terminado = $r['terminado'];
			$data->fecharegistro = $r['fechaRegistro'];
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
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->estado = $r['estado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getFinished(){
		$sql = "select * from ".self::$tablename." where terminado = 1 and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getFinishedByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where terminado = 1 and estado = 1 order by fechaFinalizado desc limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getActive(){
		$sql = "select * from ".self::$tablename." where terminado = 0 and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

	public static function getActiveByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where terminado = 0 and estado = 1 order by fechaRegistro desc limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($p){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($p);
		$sql = "select * from ".self::$tablename." where fechaInicio like '%$p%' or fechaFin like '%$p%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->estado = $r['estado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByCategoryId($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->estado = $r['estado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}
}
?>
