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
		$this->mantenimiento = "";
		$this->estado = "";
	}

	public function getCategory(){ return CategoryData::getById($this->idcategoria);}

	public function add(){
		$sql = "insert into ".self::$tablename." (idUsuario, idCategoria, nombre, descripcion, existencias, mantenimiento, precioCosteo, precioVenta)";
		$sql .= "value ($this->idusuario,$this->idcategoria,\"$this->nombre\",\"$this->descripcion\",$this->existencias,$this->mantenimiento,$this->preciocosteo,$this->precioventa)";
		return Executor::doit($sql);
	}

	public function add_with_image(){
		$sql = "insert into ".self::$tablename." (imagen, idUsuario, idCategoria, nombre, descripcion, existencias, mantenimiento, precioCosteo, precioVenta) ";
		$sql .= "value (\"$this->imagen\",$this->idusuario,$this->idcategoria,\"$this->nombre\",\"$this->descripcion\",$this->existencias,$this->mantenimiento,$this->preciocosteo,$this->precioventa)";
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
		$sql = "update ".self::$tablename." set idCategoria=$this->idcategoria, nombre=\"$this->nombre\", descripcion=\"$this->descripcion\", mantenimiento=$this->mantenimiento, preciocosteo=$this->preciocosteo, precioventa=$this->precioventa, estado=$this->estado where idProducto=$this->id";
		return Executor::doit($sql);
	}

	public function updateEx(){
		$sql = "update ".self::$tablename." set existencias = $this->existencias where idProducto=$this->id";
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
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByPage($start_from,$limit){
		$sql = "select * from ".self::$tablename." where estado = 1 and idProducto >= $start_from limit $limit";
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
		$sql = "select * from ".self::$tablename." where nombre like '%$p%' or descripcion like '%$p%'";
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
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByUserId($user_id){
		$sql = "select * from ".self::$tablename." where user_id=$user_id order by created_at desc";
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
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}

	public static function getAllByCategoryId($category_id){
		$sql = "select * from ".self::$tablename." where category_id=$category_id order by created_at desc";
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
			$array[$cnt]->imagen = $r['imagen'];
			$array[$cnt]->fecha = $r['fechaRegistro'];
			$array[$cnt]->estado = $r['estado'];
			$cnt++;
		}
		return $array;
	}
}
?>
