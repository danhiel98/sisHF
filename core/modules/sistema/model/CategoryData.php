<?php
	
	class CategoryData {
		public static $tablename = "categoria";

		public function CategoryData(){
			$this->nombre = "";
			$this->idusuario = "";
			$this->fecha = "NOW()";
		}

		public function add(){
			$sql = "insert into categoria (idUsuario,nombre,fecha) ";
			$sql .= "value ($this->idusuario,\"$this->nombre\",\"$this->fecha\")";
			Executor::doit($sql);
		}

		public static function delById($id){
			$sql = "update ".self::$tablename." set estado = 0 where idCategoria = $id";
			Executor::doit($sql);
		}
		
		public function del(){
			$sql = "update ".self::$tablename." set estado = 0 where idCategoria = $this->id";
			Executor::doit($sql);
		}

		public function update(){
			$sql = "update ".self::$tablename." set nombre=\"$this->nombre\" where idCategoria = $this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where idCategoria=$id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new CategoryData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['idCategoria'];
				$data->nombre = $r['nombre'];
				$data->idusuario = $r['idUsuario'];
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
				$array[$cnt] = new CategoryData();
				$array[$cnt]->id = $r['idCategoria'];
				$array[$cnt]->nombre = $r['nombre'];
				$array[$cnt]->idusuario = $r['idUsuario'];
				$array[$cnt]->fecha = $r['fecha'];
				$cnt++;
			}
			return $array;
		}

		public static function getByPage($start,$limit){
			$start = $start - 1;
			$sql = "select * from ".self::$tablename." where estado = 1 order by idCategoria desc limit $start,$limit";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new CategoryData();
				$array[$cnt]->id = $r['idCategoria'];
				$array[$cnt]->nombre = $r['nombre'];
				$array[$cnt]->idusuario = $r['idUsuario'];
				$array[$cnt]->fecha = $r['fecha'];
				$cnt++;
			}
			return $array;
		}

	}

?>
