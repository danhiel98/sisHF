<?php

if(count($_POST)>0){
	$emp = false;
	$isAdmin=0;
	if(isset($_POST["isAdmin"])){$isAdmin=1;}
	$activo=0;
	if(isset($_POST["activo"])){$activo=1;}
	$user = UserData::getById($_POST["user_id"]);

	if (isset($_POST['idemploy']) && !empty($_POST['idemploy'])){
		$emp = true;
		$user->idempleado = $_POST['idemploy'];
		$user->name = $user->getEmpleado()->nombre;
		$user->lastname = $user->getEmpleado()->apellido;
	}else{
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
	}
	$user->username = $_POST["username"];
	$user->email = $_POST["email"];
	$user->isAdmin=$isAdmin;
	$user->activo=$activo;
	if ($emp) {
		$user->updateUE();
	}else {
		$user->update();
	}

	if(isset($_POST["password"]) && $_POST["password"]!=""){
		$user->password = sha1(md5($_POST["password"]));
		$user->update_passwd();
		print "<script>alert('Se ha actualizado el password');</script>";
	}

	print "<script>window.location='index.php?view=users';</script>";

}

?>
