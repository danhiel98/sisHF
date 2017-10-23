<?php
//Funcion que contiene el enlace a la base de datos.
	function conexion(){
		$conn = null;
		$host = 'localhost';
		$db = 'sistemaHierroForjado';
		$user = 'root';
		$pwd = '';

		try{
			$conn = new PDO('mysql:host='.$host.'; dbname='.$db, $user, $pwd);
			$conn->exec("set names UTF8");
		}catch(PDOException $e){
			exit();
		}
		return $conn;
	}

?>
