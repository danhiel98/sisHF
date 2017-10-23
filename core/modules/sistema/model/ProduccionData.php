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
		$this->cancelado = "";
		$this->fecharegistro = "NOW()";
		$this->fechafinalizado = "NOW()"; //Se va a utilizar cuando la produccion haya finalizado (terminado o cancelado)
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

	public function cancelar(){
		$sql = "update ".self::$tablename." set cancelado = 1, fechaFinalizado = NOW() where idProduccion=$this->id;";
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
			$data->cancelado = $r['cancelado'];
			$data->fecharegistro = $r['fechaRegistro'];
			$data->fechafinalizado = $r['fechaFinalizado'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getFinished(){
		$sql = "select * from ".self::$tablename." where terminado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
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
		$sql = "select * from ".self::$tablename." where terminado = 0 and cancelado = 0";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$cnt++;
		}
		return $array;
	}

	public static function getCancel(){
		$sql = "select * from ".self::$tablename." where cancelado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProduccion'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where idProduccion >= $start_from limit $limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($p){
		$sql = "select * from ".self::$tablename." where fechaInicio like '%$p%' or fechaFin like '%$p%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProduccionData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idproducto = $r['idProducto'];
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->cancelado = $r['cancelado'];
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
			$array[$cnt]->fechainicio = $r['fechaInicio'];
			$array[$cnt]->fechafin = $r['fechaFin'];
			$array[$cnt]->cantidad = $r['cantidadProducto'];
			$array[$cnt]->terminado = $r['terminado'];
			$array[$cnt]->cancelado = $r['cancelado'];
			$array[$cnt]->fecharegistro = $r['fechaRegistro'];
			$array[$cnt]->fechafinalizado = $r['fechaFinalizado'];
			$cnt++;
		}
		return $array;
	}
}
?>
