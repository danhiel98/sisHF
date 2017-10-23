<?php
	include 'loader.php';
  if (isset($_POST["addBanco"])) {
    $banco = new BancoData();
		$banco->idusuario = $_SESSION["user_id"];
		$banco->nombre = $_POST["nombre"];
		$banco->direccion = $_POST["direccion"];
		$banco->telefono = $_POST["telefono"];
		$banco->add();
  }
	@header("location: index.php?view=banco");
?>
