<?php
class ClientData {
	public static $tablename = "cliente";

	public function ClientData(){
		$this->idusuario = "";
		$this->iddepto = "";
		$this->giro = "";
		$this->dui = "";
		$this->name = "";
		$this->sexo = "";
		$this->birth = "";
		$this->direccion = "";
		$this->phone = "";
		$this->nit = "";
		$this->email = "";
		$this->nrc = "";
	}

	public function getDepto(){return DireccionData::getDeptoById($this->iddepto);}

	public function add(){
		$sql = "insert into cliente (idUsuario, idDepto, giro, dui, nombre, sexo, fechaNacimiento, direccion, telefono, nit, email, nrc) ";
		if ($this->birth != "") {
			$sql .= "values ($this->idusuario,$this->iddepto,\"$this->giro\",\"$this->dui\",\"$this->name\",\"$this->sexo\",\"$this->birth\",\"$this->direccion\",\"$this->phone\",\"$this->nit\",\"$this->email\",\"$this->nrc\")";
		}else{
			$sql .= "values ($this->idusuario,$this->iddepto,\"$this->giro\",\"$this->dui\",\"$this->name\",\"$this->sexo\",NULL,\"$this->direccion\",\"$this->phone\",\"$this->nit\",\"$this->email\",\"$this->nrc\")";
		}
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idCliente = $id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idCliente = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		if ($this->birth != "") {
			$sql = "update ".self::$tablename." set idDepto=$this->iddepto, giro=\"$this->giro\", dui=\"$this->dui\", nit=\"$this->nit\", nombre=\"$this->name\", fechaNacimiento=\"$this->birth\", email=\"$this->email\", direccion=\"$this->direccion\", sexo=\"$this->sexo\", telefono=\"$this->phone\", nrc=\"$this->nrc\" where idCliente = $this->id";
		}else{
			$sql = "update ".self::$tablename." set idDepto=$this->iddepto, giro=\"$this->giro\", dui=\"$this->dui\", nit=\"$this->nit\", nombre=\"$this->name\", fechaNacimiento=NULL, email=\"$this->email\", direccion=\"$this->direccion\", sexo=\"$this->sexo\", telefono=\"$this->phone\", nrc=\"$this->nrc\" where idCliente = $this->id";
		}
		#return $sql;
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idCliente = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ClientData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCliente'];
			$data->iddepto = $r['idDepto'];
			$data->giro = $r['giro'];
			$data->dui = $r['dui'];
			$data->name = $r['nombre'];
			$data->sexo = $r['sexo'];
			$data->birth = $r['fechaNacimiento'];
			$data->direccion = $r['direccion'];
			$data->phone = $r['telefono'];
			$data->nit = $r['nit'];
			$data->email = $r['email'];
			$data->nrc = $r['nrc'];
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
			$array[$cnt] = new ClientData();
			$array[$cnt]->id = $r['idCliente'];
			$array[$cnt]->iddepto = $r['idDepto'];
			$array[$cnt]->giro = $r['giro'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->birth = $r['fechaNacimiento'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->phone = $r['telefono'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->nrc = $r['nrc'];
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
			$array[$cnt] = new ClientData();
			$array[$cnt]->id = $r['idCliente'];
			$array[$cnt]->iddepto = $r['idDepto'];
			$array[$cnt]->giro = $r['giro'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->birth = $r['fechaNacimiento'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->phone = $r['telefono'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->nrc = $r['nrc'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllWithNRC(){
		$sql = "select * from ".self::$tablename." where estado = 1 and nrc is not null or nrc <> ''";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ClientData();
			$array[$cnt]->id = $r['idCliente'];
			$array[$cnt]->iddepto = $r['idDepto'];
			$array[$cnt]->giro = $r['giro'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->birth = $r['fechaNacimiento'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->phone = $r['telefono'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->nrc = $r['nrc'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where nombre like '%$q%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ClientData();
			$array[$cnt]->id = $r['idCliente'];
			$array[$cnt]->iddepto = $r['idDepto'];
			$array[$cnt]->giro = $r['giro'];
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->birth = $r['fechaNacimiento'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->phone = $r['telefono'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->nrc = $r['nrc'];
			$cnt++;
		}
		return $array;
	}
}

?>
