<?php
class ProductData {
	public static $tablename = "producto";

	public function ProductData(){
		$this->nombre = "";
		$this->descripcion = "";
		$this->preciocosteo = "";
		$this->precioventa = "";
		$this->existencias = "";
		$this->imagen = "";
		$this->idusuario = "";
		$this->mantenimiento = "NULL";
		$this->mesesmantto = "NULL";
		$this->estado = "";
	}

	public function getCategory(){ return CategoryData::getById($this->idcategoria);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idCategoria, nombre, descripcion, existencias, mantenimiento, precioCosteo, precioVenta, mesesMantto)";
		$sql .= "value ($this->idusuario,$this->idcategoria,\"$this->nombre\",\"$this->descripcion\",$this->existencias,$this->mantenimiento,$this->preciocosteo,$this->precioventa,$this->mesesmantto)";
		return Executor::doit($sql);
	}

	public function add_with_image(){
		$sql = "insert into ".self::$tablename." (imagen, idUsuario, idCategoria, nombre, descripcion, existencias, mantenimiento, precioCosteo, precioVenta, mesesMantto) ";
		$sql .= "value (\"$this->imagen\",$this->idusuario,$this->idcategoria,\"$this->nombre\",\"$this->descripcion\",$this->existencias,$this->mantenimiento,$this->preciocosteo,$this->precioventa,$this->mesesmantto)";
		return Executor::doit($sql);
	}

	public static function delById($id){
		$sql = "update ".self::$tablename." set estado = 0 where idProducto = $id";
		Executor::doit($sql);
	}

	public function del(){
		$sql = "update ".self::$tablename." set estado = 0 where idProducto = $this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set idCategoria=$this->idcategoria, nombre=\"$this->nombre\", descripcion=\"$this->descripcion\", mantenimiento=$this->mantenimiento, mesesMantto=$this->mesesmantto, preciocosteo=$this->preciocosteo, precioventa=$this->precioventa where idProducto=$this->id";
		return Executor::doit($sql);
	}

	public function updateEx(){
		$sql = "update ".self::$tablename." set existencias = $this->existencias where idProducto = $this->id";
		return Executor::doit($sql);
	}

	public function del_category(){
		$sql = "update ".self::$tablename." set category_id=NULL where id=$this->id";
		Executor::doit($sql);
	}

	public function update_image(){
		$sql = "update ".self::$tablename." set imagen=\"$this->imagen\" where idProducto=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where idProducto=$id";
		$query = Executor::doit($sql);
		$found = null;
		$data = new ProductData();
		while($r = $query[0]->fetch_array()){
			$data->id = $r['idProducto'];
			$data->idcategoria = $r['idCategoria'];
			$data->nombre = $r['nombre'];
			$data->descripcion = $r['descripcion'];
			$data->preciocosteo = $r['precioCosteo'];
			$data->precioventa = $r['precioVenta'];
			$data->existencias = $r['existencias'];
			$data->mantenimiento = $r['mantenimiento'];
			$data->mesesmantto = $r['mesesMantto'];
			$data->imagen = $r['imagen'];
			$data->fecha = $r['fechaRegistro'];
			$data->estado = $r['estado'];
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
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idcategoria = $r['idCategoria'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->preciocosteo = $r['precioCosteo'];
			$array[$cnt]->precioventa = $r['precioVenta'];
			$array[$cnt]->existencias = $r['existencias'];
			$array[$cnt]->mantenimiento = $r['mantenimiento'];
			$array[$cnt]->mesesmantto = $r['mesesMantto'];
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($inicio,$cantidad){
		$inicio = $inicio - 1;
		$sql = "select * from ".self::$tablename." where estado = 1 order by fechaRegistro desc limit $inicio,$cantidad";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idcategoria = $r['idCategoria'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->preciocosteo = $r['precioCosteo'];
			$array[$cnt]->precioventa = $r['precioVenta'];
			$array[$cnt]->existencias = $r['existencias'];
			$array[$cnt]->mantenimiento = $r['mantenimiento'];
			$array[$cnt]->mesesmantto = $r['mesesMantto'];
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getLike($p){
		$base = new Database();
		$cnx = $base->connect();
		$p = $cnx->real_escape_string($p);
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idcategoria = $r['idCategoria'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->preciocosteo = $r['precioCosteo'];
			$array[$cnt]->precioventa = $r['precioVenta'];
			$array[$cnt]->existencias = $r['existencias'];
			$array[$cnt]->mantenimiento = $r['mantenimiento'];
			$array[$cnt]->mesesmantto = $r['mesesMantto'];
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByCategory($id){
		$sql = "select * from ".self::$tablename." where idCategoria = $id and estado = 1";
		$query = Executor::doit($sql);
		$array = array();
		$cnt = 0;
		while($r = $query[0]->fetch_array()){
			$array[$cnt] = new ProductData();
			$array[$cnt]->id = $r['idProducto'];
			$array[$cnt]->idcategoria = $r['idCategoria'];
			$array[$cnt]->nombre = $r['nombre'];
			$array[$cnt]->descripcion = $r['descripcion'];
			$array[$cnt]->preciocosteo = $r['precioCosteo'];
			$array[$cnt]->precioventa = $r['precioVenta'];
			$array[$cnt]->existencias = $r['existencias'];
			$array[$cnt]->mantenimiento = $r['mantenimiento'];
			$array[$cnt]->mesesmantto = $r['mesesMantto'];
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}
}
?>
