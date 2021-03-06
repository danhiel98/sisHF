<?php
class UserData {
	public static $tablename = "usuario";

	public function Userdata(){
		$this->idempleado = "";
		$this->name = "";
		$this->lastname = "";
		$this->user = "";
		$this->email = "";
		$this->password = "";
		$this->activo = "";
		$this->tipo = "";
		$this->fechacreacion = "NOW()";
	}

	public function getEmpleado(){ return EmpleadoData::getById($this->idempleado);}
	public function getUserType(){ return UserTypeData::getById($this->tipo);}

	public function add(){
		$sql = "insert into usuario (nombre, apellido, usuario, email, clave, tipo, fechaCreacion) ";
		$sql .= "value (\"$this->name\",\"$this->lastname\",\"$this->username\",\"$this->email\",\"$this->password\",\"$this->tipo\",$this->fechacreacion)";
		Executor::doit($sql);
	}

	public function addUE(){
		$sql = "insert into usuario (idempleado, nombre, apellido, usuario, email, clave, tipo, fechaCreacion) ";
		$sql .= "value ($this->idempleado,\"$this->name\",\"$this->lastname\",\"$this->username\",\"$this->email\",\"$this->password\",\"$this->tipo\",$this->fechacreacion)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idUsuario = $id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idUsuario = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set nombre=\"$this->name\", apellido=\"$this->lastname\", usuario=\"$this->username\", email=\"$this->email\", activo=\"$this->activo\", tipo=\"$this->tipo\" where idUsuario=$this->id";
		Executor::doit($sql);
	}

	public function updateS(){
		$sql = "update ".self::$tablename." set activo = $this->activo where idUsuario=$this->id";
		Executor::doit($sql);
	}

	public function updateT(){
		$sql = "update ".self::$tablename." set tipo = $this->tipo where idUsuario=$this->id";
		Executor::doit($sql);
	}

	public function updateUE(){
		$sql = "update ".self::$tablename." set usuario=\"$this->user\", email=\"$this->email\" where idUsuario=$this->id";
		Executor::doit($sql);
	}

	public function update_passwd(){
		$sql = "update ".self::$tablename." set clave=\"$this->password\" where idUsuario=$this->id";
		Executor::doit($sql);
	}

	public static function login($user,$pass){
		$sql = "select * from usuario where (email= \"".$user."\" or usuario = \"".$user."\") and clave= \"".$pass."\"";
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idUsuario'];
			$data->idempleado = $r['idEmpleado'];
			$data->name = $r['nombre'];
			$data->lastname = $r['apellido'];
			$data->username = $r['usuario'];
			$data->email = $r['email'];
			$data->password = $r['clave'];
			$data->activo = $r['activo'];
			$data->tipo = $r['tipo'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idUsuario = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new UserData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idUsuario'];
			$data->idempleado = $r['idEmpleado'];
			$data->name = $r['nombre'];
			$data->lastname = $r['apellido'];
			$data->fullname = $r['nombre']." ".$r['apellido'];
			$data->username = $r['usuario'];
			$data->email = $r['email'];
			$data->password = $r['clave'];
			$data->activo = $r['activo'];
			$data->tipo = $r['tipo'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getByMail($mail){
		$sql = "select * from ".self::$tablename." where email='$mail'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->password = $r['clave'];
			$cnt++;
		}
		return $array;
	}

	public static function getAll(){
		$sql = "select * from ".self::$tablename." where idEmpleado is not null";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->password = $r['clave'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start,$limit){
		$start = $start - 1;
		$sql = "select * from ".self::$tablename." where idEmpleado is not null limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->password = $r['clave'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucId($id){
		$sql = "select idUsuario, usuario.idEmpleado, usuario, email, clave, tipo, fechaCreacion, usuario.activo, empleado.idSucursal";
		$sql .= " from usuario inner join empleado on empleado.idEmpleado = usuario.idEmpleado where empleado.idSucursal = $id";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->password = $r['clave'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySucPage($id,$start,$limit){
		$start = $start - 1;
		$sql = "select idUsuario, usuario.idEmpleado, usuario, email, clave, tipo, fechaCreacion, usuario.activo, empleado.idSucursal";
		$sql .= " from usuario inner join empleado on empleado.idEmpleado = usuario.idEmpleado where empleado.idSucursal = $id limit $start,$limit";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->password = $r['clave'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}

	public static function getByUsername($usuario){
		$sql = "select * from ".self::$tablename." where usuario = '$usuario'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->password = $r['clave'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where nombre like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new UserData();
			$array[$cnt]->id = $r['idUsuario'];
			$array[$cnt]->idempleado = $r['idEmpleado'];
			$array[$cnt]->name = $r['nombre'];
			$array[$cnt]->lastname = $r['apellido'];
			$array[$cnt]->email = $r['email'];
			$array[$cnt]->username = $r['usuario'];
			$array[$cnt]->activo = $r['activo'];
			$array[$cnt]->tipo = $r['tipo'];
			$cnt++;
		}
		return $array;
	}
}
?>
