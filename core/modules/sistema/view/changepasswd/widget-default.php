<?php

if((isset($_POST["password"]) && !empty($_POST["password"])) && isset($_POST["idUsr"]) && is_numeric($_POST["idUsr"])){
	$id = $_POST["idUsr"];
	$password = sha1(md5($_POST["password"]));
	
	$user = UserData::getById($id);
	
	$user->password = $password;
	$user->update_passwd();
	setcookie("password_updated","¡La contraseña del usuario '$user->username' se cambió correctamente!");
	@header("location: index.php?view=users");
}else{
	if(Session::getUID() != ""){
		$user = UserData::getById(Session::getUID());
		$password = sha1(md5($_POST["password"]));
		if($password == $user->password){
			$user->password = sha1(md5($_POST["newpassword"]));
			$user->update_passwd();
			setcookie("password_updated","true");
			print "<script>window.location='logout.php';</script>";
		}else{
			setcookie("icorrectPassword","¡Vaya! No se ha podido cambiar la contraseña.");
			print "<script>window.location='index.php?view=configuration';</script>";
		}
	}else {
		print "<script>window.location='index.php';</script>";
	}
}


?>
