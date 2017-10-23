<?php
class DireccionData {

	public function getMunicipio(){return DireccionData::getMunicById($this->id);}
	public function getDepartamento(){return DireccionData::getDeptoById($this->id);}
	public function getZona(){return DireccionData::getZoneById($this->id);}

	public static function getZoneById($id){
		$sql = "select * from zonesv where id = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new DireccionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['ID'];
			$data->nombreZona = $r['ZoneName'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllZones(){
		$sql = "select * from zonesv";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DireccionData();
			$array[$cnt]->id = $r['ID'];
			$array[$cnt]->nombreZona = $r['ZoneName'];
			$cnt++;
		}
		return $array;
	}

	public static function getDeptoById($id){
		$sql = "select * from depsv where id = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new DireccionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['ID'];
			$data->nombreDepto = $r['DepName'];
			$data->codISO = $r['ISOCode'];
			$data->idZona = $r['ZONESV_ID'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getAllDeptos(){
		$sql = "select * from depsv";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DireccionData();
			$array[$cnt]->id = $r['ID'];
			$array[$cnt]->nombreDepto = $r['DepName'];
			$array[$cnt]->codISO = $r['ISOCode'];
			$array[$cnt]->idZona = $r['ZONESV_ID'];
			$cnt++;
		}
		return $array;
	}

	public static function getMunicById($id){
		$sql = "select * from munsv where id = $id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new DireccionData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['ID'];
			$data->nombreMunic = $r['MunName'];
			$data->idDept = $r['DEPSV_ID'];
			$found = $data;
			break;
		}
		return $found;
	}

	public static function getMunicsByDeptoId($idDepto){
		$sql = "select * from munsv where DEPSV_ID = $idDepto";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DireccionData();
			$array[$cnt]->id = $r['ID'];
			$array[$cnt]->nombreMunic = $r['MunName'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllMunics(){
		$sql = "select * from munsv";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new DireccionData();
			$array[$cnt]->id = $r['ID'];
			$array[$cnt]->nombreMunic = $r['MunName'];
			$array[$cnt]->idDept = $r['DEPSV_ID'];
			$cnt++;
		}
		return $array;
	}

}

?>
