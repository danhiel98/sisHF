<?php
class EnvioData {
	public static $tablename = "enviobanco";

	public function EnvioData(){
		$this->cantidad = "";
		$this->idbanco = "";
		$this->idusuario = "";
		$this->comprobante = "";
		$this->fecha = "NOW()";
	}

	public function getUsuario(){ return UserData::getById($this->idusuario);}
	public function getBanco(){ return BancoData::getById($this->idbanco);}

	public function add(){
		$sql = "insert into envioBanco (idUsuario, idBanco, cantidad, numComprobante, fecha) ";
		$sql .= "values ($this->idusuario, $this->idbanco, $this->cantidad, \"$this->comprobante\", $this->fecha)";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idEnvioBanco=$id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idEnvioBanco=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idBanco=\"$this->idBanco\", cantidad=\"$this->cantidad\", numComprobante=\"$this->comprobante\" where idEnvioBanco = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idEnvioBanco = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new EnvioData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idEnvioBanco'];
			$data->idusuario = $r['idUsuario'];
			$data->idbanco = $r['idBanco'];
			$data->cantidad = $r['cantidad'];
			$data->comprobante = $r['numComprobante'];
			$data->fecha = $r['fecha'];
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
			$array[$cnt] = new EnvioData();
			$array[$cnt]->id = $r['idEnvioBanco'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idbanco = $r['idBanco'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->comprobante = $r['numComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
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
			$array[$cnt] = new EnvioData();
			$array[$cnt]->id = $r['idEnvioBanco'];
			$array[$cnt]->idusuario = $r['idUsuario'];
			$array[$cnt]->idbanco = $r['idBanco'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->comprobante = $r['numComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($q);
		$sql = "select * from ".self::$tablename." where fecha like '%$q%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new EnvioData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->idBanco = $r['idBanco'];
			$array[$cnt]->cantidad = $r['cantidad'];
			$array[$cnt]->comprobante = $r['numComprobante'];
			$array[$cnt]->fecha = $r['fecha'];
			$cnt++;
		}
		return $array;
	}
}

?>
