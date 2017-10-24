<?php

if(count($_POST)>0){
	$emp = false;
	$isAdmin=0;
	if(isset($_POST["isAdmin"])){$isAdmin=1;}
	$user = new UserData();

	if (isset($_POST['employ'])) {
		$emp = true;
		$user->idempleado = $_POST['employ'];
		$user->name = $user->getEmpleado()->nombre;
		$user->lastname = $user->getEmpleado()->apellido;
	}else{
		$user->name = $_POST["name"];
		$user->lastname = $_POST["lastname"];
	}
	$user->username = $_POST["username"];
	$user->email = $_POST["email"];
	$user->isAdmin = $isAdmin;
	$user->password = sha1(md5($_POST["password"]));
	if ($emp) {
		$user->addUE();
	}else {
		$user->add();
	}

	print "<script>window.location='index.php?view=users';</script>";

}

?>
