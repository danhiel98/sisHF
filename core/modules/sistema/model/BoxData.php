<?php
class BoxData {
	public static $tablename = "cierreCaja";

	public function BoxData(){
		$this->idusuario = "";
		$this->idsucursal = "1";
		$this->fecha = "NOW()";

		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->image = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getSucursal(){return SucursalData::getById($this->idsucursal);}
	public function getUser(){return UserData::getById($this->idusuario);}

	public function add(){
		$sql = "insert into cierreCaja(idUsuario, idSucursal, fecha) ";
		$sql .= "value ($this->idusuario,$this->idsucursal,$this->fecha)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "delete from ".self::$tablename." where id=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idCierreCaja=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new BoxData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idCierreCaja'];
			$data->fecha = $r['fecha'];
			$data->idusuario = $r['idUsuario'];
			$data->idsucursal = $r['idSucursal'];
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
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['idCierreCaja'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllBySuc($id){
		$sql = "select * from ".self::$tablename." where idSucursal = $id and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['idCierreCaja'];
			$array[$cnt]->fecha = $r['fecha'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idsucursal = $r['idSucursal'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BoxData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->created_at = $r['created_at'];
			$cnt++;
		}
		return $array;
	}

}

?>
