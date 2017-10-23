<?php

if(Session::getUID()!=""){
	$user = UserData::getById(Session::getUID());
	#print_r($user);
	$respuesta = sha1(md5($_POST["respuestaactual"]));
	if($respuesta == $user->respuestapregunta){
		$user->idpreguntasecreta = $_POST["question"];
		$user->respuestapregunta= sha1(md5($_POST["newrespuesta"]));
		$user->updateSecretQ();
		setcookie("question_updated","true");
		print "<script>window.location='index.php?view=configuration';</script>";
	}else{
		print "<script>window.location='index.php?view=security&msg=invalidpasswd';</script>";
	}
}else {
		print "<script>window.location='index.php';</script>";
}

?>
