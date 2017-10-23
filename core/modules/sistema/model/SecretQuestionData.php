<?php
class SecretQuestionData {
	public static $tablename = "preguntaSecreta";

	public function SecretQuestionData(){
		$this->pregunta = "";
	}

	public function add(){
		$sql = "insert into preguntaSecreta (pregunta) ";
		$sql .= "values (\"$this->pregunta\")";
		Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set activo = 0 where idPreguntaSecreta = $id";
		Executor::doit($sql);
	}
	public function del(){
		$sql = "update ".self::$tablename." set activo = 0 where idPreguntaSecreta = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set pregunta=\"$this->pregunta\" where idPreguntaSecreta = $this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idPreguntaSecreta = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new SecretQuestionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idPreguntaSecreta'];
			$data->pregunta = $r['pregunta'];
			$data->activo = $r['activo'];
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
			$array[$cnt] = new SecretQuestionData();
			$array[$cnt]->id = $r['idPreguntaSecreta'];
			$array[$cnt]->pregunta = $r['pregunta'];
			$array[$cnt]->activo = $r['activo'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where nombre like '%$q%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new BancoData();
			$array[$cnt]->id = $r['id'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->direccion = $r['direccion'];
			$array[$cnt]->telefono = $r['telefono'];
			$cnt++;
		}
		return $array;
	}
}

?>
