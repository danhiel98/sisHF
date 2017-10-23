<?php
	class ProduccionMPData {
		public static $tablename = "materiaPrimaProduccion";

		public function ProduccionMPData(){
			$this->cantidad = "";
		}

		public function getProduccion(){ return ProduccionData::getById($this->idproduccion);}
		public function getMateriaPrima(){ return MateriaPrimaData::getById($this->idmateriaprima);}

		public function add(){
			$sql = "insert into ".self::$tablename." (idProduccion, idMateriaPrima, cantidad) ";
			$sql .= "value ($this->idproduccion, $this->idmateriaprima, $this->cantidad)";
			return Executor::doit($sql);
		}

		public static function delById($id){
			$sql = "update ".self::$tablename." set estado = 0 where idMateriaPrimaProduccion = $id";
			Executor::doit($sql);
		}

		public function del(){
			$sql = "update ".self::$tablename." set estado = 0 where idMateriaPrimaProduccion = $this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where idMateriaPrimaProduccion = $id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new ProduccionMPData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['idMateriaPrimaProduccion'];
				$data->idfacturamp = $r['idFacturaMateriaPrima'];
				$data->idmateriaprima = $r['idMateriaPrima'];
				$data->cantidad = $r['cantidad'];
				$data->precio = $r['precioUnitario'];
				$data->total = $r['total'];
				$found = $data;
				break;
			}
			return $found;
		}

		public static function getAllByProdId($id){
			$sql = "select * from ".self::$tablename." where idProduccion = $id";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ProduccionMPData();
				$array[$cnt]->id = $r['idMateriaPrimaProduccion'];
				$array[$cnt]->idproduccion = $r['idProduccion'];
				$array[$cnt]->idmateriaprima = $r['idMateriaPrima'];
				$array[$cnt]->cantidad = $r['cantidad'];
				$cnt++;
			}
			return $array;
		}

		public static function getAllByReabId($id){
			$sql = "select * from ".self::$tablename." where idFacturaMateriaPrima = $id and estado = 1";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ProduccionMPData();
				$array[$cnt]->id = $r['idMateriaPrimaProduccion'];
				$array[$cnt]->idfacturamp = $r['idFacturaMateriaPrima'];
				$array[$cnt]->idmateriaprima = $r['idMateriaPrima'];
				$array[$cnt]->cantidad = $r['cantidad'];
				$array[$cnt]->precio = $r['precioUnitario'];
				$array[$cnt]->total = $r['total'];
				$cnt++;
			}
			return $array;
		}

		public static function getAllByPage($start_from, $limit){
			$sql = "select * from ".self::$tablename." where idMateriaPrimaProduccion<=$start_from limit $limit";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ProduccionMPData();
				$array[$cnt]->id = $r['idMateriaPrima'];
				$array[$cnt]->idfacturamp = $r['idFacturaMateriaPrima'];
				$array[$cnt]->idmateriaprima = $r['idMateriaPrima'];
				$array[$cnt]->cantidad = $r['cantidad'];
				$array[$cnt]->precio = $r['precioUnitario'];
				$array[$cnt]->total = $r['total'];
				$cnt++;
			}
			return $array;
		}
	}

?>
