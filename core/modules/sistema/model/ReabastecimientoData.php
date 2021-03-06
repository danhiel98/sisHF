<?php
	class ReabastecimientoData {
		public static $tablename = "facturaMateriaPrima";

		public function ReabastecimientoData(){
			$this->idusuario = "";
			$this->idproveedor = "";
			$this->tipoComprobante = "null"; #Tipo de comprobante
			$this->comprobante = "null"; #No. de comprobante
			$this->total = 0;
			$this->fecha = "NOW()";
		}

		public function getComprobante(){return ComprobanteData::getById($this->tipoComprobante);}
		public function getProvider(){ return ProviderData::getById($this->idproveedor);}
		public function getUser(){return UserData::getById($this->idusuario);}

		public function add(){
			$sql = "insert into ".self::$tablename." (idUsuario, idProveedor, tipoComprobante, numComprobante, fecha, total) ";
			$sql .= "value ($this->idusuario, $this->idproveedor, $this->tipoComprobante, \"$this->comprobante\", $this->fecha, $this->total)";
			return Executor::doit($sql);
		}

		public function updateTot(){
			$sql = "update ".self::$tablename." set total = $this->total where idFacturaMateriaPrima = $this->id";
			Executor::doit($sql);
		}

		public static function delById($id){
			$sql = "update ".self::$tablename." set estado = 0 where idFacturaMateriaPrima = $id";
			Executor::doit($sql);
		}

		public function del(){
			$sql = "update ".self::$tablename." set estado = 0 where idFacturaMateriaPrima = $this->id";
			Executor::doit($sql);
		}
		
		public static function getById($id){
			$sql = "select * from ".self::$tablename." where idFacturaMateriaPrima = $id";
			$query = Executor::doit($sql);
			$found = null;
			$data = new ReabastecimientoData();
			while($r = $query[0]->fetch_array()){
				$data->id = $r['idFacturaMateriaPrima'];
				$data->idproveedor = $r['idProveedor'];
				$data->idusuario = $r['idUsuario'];
				$data->tipoComprobante = $r['tipoComprobante'];
				$data->comprobante = $r['numComprobante'];
				$data->fecha = $r['fecha'];
				$data->total = $r['total'];
				$data->estado = $r['estado'];
				$found = $data;
				break;
			}
			return $found;
		}

		public static function getByPage($start, $limit){
			$start = $start - 1;
			$sql = "select * from ".self::$tablename." where estado = 1 order by fecha desc limit $start,$limit";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ReabastecimientoData();
				$array[$cnt]->id = $r['idFacturaMateriaPrima'];
				$array[$cnt]->idproveedor = $r['idProveedor'];
				$array[$cnt]->idUsuario = $r['idUsuario'];
				$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
				$array[$cnt]->comprobante = $r['numComprobante'];
				$array[$cnt]->fecha = $r['fecha'];
				$array[$cnt]->total = $r['total'];
				$cnt++;
			}
			return $array;
		}

		public static function getAll(){
			$sql = "select * from ".self::$tablename." where estado = 1";
			$query = Executor::doit($sql);
			$array = array();
			$cnt = 0;
			while($r = $query[0]->fetch_array()){
				$array[$cnt] = new ReabastecimientoData();
				$array[$cnt]->id = $r['idFacturaMateriaPrima'];
				$array[$cnt]->idproveedor = $r['idProveedor'];
				$array[$cnt]->idUsuario = $r['idUsuario'];
				$array[$cnt]->tipoComprobante = $r['tipoComprobante'];
				$array[$cnt]->comprobante = $r['numComprobante'];
				$array[$cnt]->fecha = $r['fecha'];
				$array[$cnt]->total = $r['total'];
				$cnt++;
			}
			return $array;
		}

	}

?>
