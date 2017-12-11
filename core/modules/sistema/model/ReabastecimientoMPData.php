<?php
	class ReabastecimientoMPData {
		public static $tablename = "compraMateriaPrima";

		public function ReabastecimientoMPData(){
			$this->cantidad = "";
			$this->precio = "";
			$this->total = "";
		}

		public function getFacturaMP(){ return ReabastecimientoData::getById($this->idfacturamp);}
		public function getMateriaPrima(){ return MateriaPrimaData::getById($this->idmateriaprima);}

		public function add(){
			$sql = "insert into ".self::$tablename." (idFacturaMateriaPrima, idMateriaPrima, cantidad, precioUnitario, total) ";
			$sql .= "value ($this->idfacturamp, $this->idmateriaprima, $this->cantidad, $this->precio, $this->total)";
			return Executor::doit($sql);
		}

		public static function delById($id){
			$sql = "update ".self::$tablename." set estado = 0 where idCompraMateriaPrima = $id";
			Executor::doit($sql);
		}

		public function del(){
			$sql = "update ".self::$tablename." set estado = 0 where idCompraMateriaPrima = $this->id";
			Executor::doit($sql);
		}

		public static function getById($id){
			$sql = "select * from ".self::$tablename." where idCompraMateriaPrima = $id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new ReabastecimientoMPData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['idCompraMateriaPrima'];
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

		public static function getAllByReabId($id){
			$sql = "select * from ".self::$tablename." where idFacturaMateriaPrima = $id and estado = 1";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ReabastecimientoMPData();
				$array[$cnt]->id = $r['idCompraMateriaPrima'];
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
			$sql = "select * from ".self::$tablename." where idCompraMateriaPrima<=$start_from limit $limit";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ReabastecimientoMPData();
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
