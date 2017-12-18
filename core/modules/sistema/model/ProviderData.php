<?php
class ProviderData {
	public static $tablename = "proveedor";

	public function ProviderData(){
		$this->nombre = "";
		$this->tipoprovee = "";
		$this->direccion = "";
		$this->telefono = "";
		$this->correo = "";
	}

	public function add(){
		$sql = "insert into proveedor (idUsuario, nombre, tipoProvee, direccion, telefono, correo) ";
		$sql .= "values ($this->idusuario,\"$this->nombre\",\"$this->tipoprovee\",\"$this->direccion\",\"$this->telefono\",\"$this->correo\")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idProveedor = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idProveedor = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->nombre\", tipoProvee=\"$this->tipoprovee\", direccion=\"$this->direccion\", telefono=\"$this->telefono\", correo=\"$this->correo\" where idProveedor = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idProveedor = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProviderData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idProveedor'];
			$data->idusuario = $r['idUsuario'];
			$data->nombre = $r['nombre'];
			$data->tipoprovee = $r['tipoProvee'];
			$data->direccion = $r['direccion'];
			$data->telefono = $r['telefono'];
			$data->correo = $r['correo'];
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
			$array[$cnt] = new ProviderData();
			$array[$cnt]->id = $r['idProveedor'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->tipoprovee = $r['tipoProvee'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->correo = $r['correo'];
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
			$array[$cnt] = new ProviderData();
			$array[$cnt]->id = $r['idProveedor'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->tipoprovee = $r['tipoProvee'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->correo = $r['correo'];
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
			$array[$cnt] = new ProviderData();
			$array[$cnt]->id = $r['idProveedor'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->tipoprovee = $r['tipoprovee'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$array[$cnt]->correo = $r['correo'];
			$cnt++;
		}
		return $array;
	}
}

?>
