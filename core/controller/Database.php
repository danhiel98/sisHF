<?php
class Database {
	public static $db;
	public static $con;
	
	function Database(){
		$this->user="root";
		$this->pass="";
		$this->host="localhost";
		$this->ddbb="sistemaHierroForjado";
	}

	function connect(){
		$con = new mysqli($this->host,$this->user,$this->pass,$this->ddbb);
		if ($con->connect_error) {
			die('Error de Conexión (No se puede conectar a la base de datos)');
		}
		$con->set_charset("utf8");
		return $con;
	}

	public static function getCon(){
		if(self::$con==null && self::$db==null){
			self::$db = new Database();
			self::$con = self::$db->connect();
		}
		return self::$con;
	}

}
?>
