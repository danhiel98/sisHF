<?php
class ClientData {
	public static $tablename = "cliente";

	public function ClientData(){
		$this->dui = "";
		$this->name = "";
		$this->lastname = "";
		$this->sexo = "";
		$this->birth = "";
		$this->direccion = "";
		$this->phone = "";
		$this->nit = "";
		$this->email = "";
		$this->nrc = "";
	}

	public function add(){
		$sql = "insert into cliente (idUsuario, dui, nombre, apellido, sexo, fechaNacimiento, direccion, telefono, nit, email, nrc) ";
		if ($this->birth != "") {
			$sql .= "values ($this->idusuario,\"$this->dui\",\"$this->name\",\"$this->lastname\",\"$this->sexo\",\"$this->birth\",\"$this->direccion\",\"$this->phone\",\"$this->nit\",\"$this->email\",\"$this->nrc\")";
		}else{
			$sql .= "values ($this->idusuario,\"$this->dui\",\"$this->name\",\"$this->lastname\",\"$this->sexo\",NULL,\"$this->direccion\",\"$this->phone\",\"$this->nit\",\"$this->email\",\"$this->nrc\")";
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
			$sql = "update ".self::$tablename." set dui=\"$this->dui\", nit=\"$this->nit\", nombre=\"$this->name\", apellido=\"$this->lastname\", fechaNacimiento=\"$this->birth\", email=\"$this->email\", direccion=\"$this->direccion\", sexo=\"$this->sexo\", telefono=\"$this->phone\", nrc=\"$this->nrc\" where idCliente = $this->id";
		}else{
			$sql = "update ".self::$tablename." set dui=\"$this->dui\", nit=\"$this->nit\", nombre=\"$this->name\", apellido=\"$this->lastname\", fechaNacimiento=NULL, email=\"$this->email\", direccion=\"$this->direccion\", sexo=\"$this->sexo\", telefono=\"$this->phone\", nrc=\"$this->nrc\" where idCliente = $this->id";
		}
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idCliente = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ClientData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCliente'];
			$data->dui = $r['dui'];
			$data->nit = $r['nit'];
			$data->name = $r['nombre'];
			$data->lastname = $r['apellido'];
			$data->sexo = $r['sexo'];
			$data->birth = $r['fechaNacimiento'];
			$data->phone = $r['telefono'];
			$data->direccion = $r['direccion'];
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
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->birth = $r['fechaNacimiento'];
			$array[$cnt]->phone = $r['telefono'];
			$array[$cnt]->direccion = $r['direccion'];
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
			$array[$cnt]->dui = $r['dui'];
			$array[$cnt]->nit = $r['nit'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->sexo = $r['sexo'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->phone = $r['telefono'];
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
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->email = $r['email'];
			$cnt++;
		}
		return $array;
	}
}

?>
