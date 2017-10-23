<?php
	if (isset($_POST['accion'])) {

		include('ajax/conectarpdo.php');
		$conn =  conexion();
		$usuario = $_POST['txtusuario'];
		$email = $_POST['email'];
		$respuesta = sha1(md5($_POST['txtrespuesta']));
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$sql = "SELECT idUsuario, respuestaPregunta FROM usuario where email=\"$email\"";
			$result = $conn->query($sql);
			$rows = $result->fetchAll();
			foreach ($rows as $row){
				$i_u = $row['idUsuario'];
				$i_respuesta = $row['respuestaPregunta'];
			}
			$resp = false;
			if ($respuesta == $i_respuesta) {
				$resp = true;
				//generar contraseña aleatoria
				function passs_randow($length = 6){

					$charset ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkemnopqrstuvwxyz0123456789%$/()#?";
					$password= "";

					for ($i=0; $i < $length; $i++) {
						$rand = rand()%strlen($charset);
						$password .= substr($charset, $rand,1);
					}
					return $password;
				}

				$newpass = passs_randow(5);
				$conn = conexion();
				$xnewpass = sha1(md5($newpass));
				$squery = "update usuario SET clave = '$xnewpass' where idusuario = $i_u";

				$conn->exec($squery);
				#echo"<meta http-equiv='refresh' content='60; url=index.php'/ >";
			}else{
				#echo"<meta http-equiv='refresh' content='50; url=index.php?view=home'/ >";
			}
}

?>
<?php
	$incpwd = false;
	$_SESSION['rset'] = false;
	if(Session::getUID()!=""){
			print "<script>window.location='index.php?view=home';</script>";
	}
?>
<link rel="stylesheet" href="css/login.css">
<div class="row vertical-offset-100">
	<div class="col-md-5 col-md-offset-2 col-sm-8">
		<?php if (isset($resp) && $resp): ?>
			<div class='contenedor'>
				<div class='alert alert-success alert-dimissible'>
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>¡Listo!</b> Su nueva contraseña ha sido asignada con Éxito. <br> Contraseña: <b><?php echo $newpass; ?></b>
				</div>
			</div>
		<?php elseif(isset($resp) && !$resp): ?>
			<div class='contenedor'>
				<div class='alert alert-danger alert-dimissible'>
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<b>¡Lo Sentimos!</b> La respuesta ingresada es incorrecta. <br> No puede generarse su contraseña.
				</div>
			</div>
		<?php endif; ?>
		<?php if(isset($_COOKIE['password_updated'])):?>
			<div class="alert alert-success">
				<p><i class='glyphicon glyphicon-off'></i> Se ha cambiado la contraseña exitosamente!</p>
				<p>Inicie sesión con su nueva contraseña.</p>
			</div>
		<?php
				setcookie("password_updated","",time()-18600);
		 		endif;
		 ?>
		<div class="form">
			<form class="register-form" action="" method="POST">
				<div class="thumbnail"><img src="storage/lock.png"/></div>
				<div class="form-group">
					<input type="text" id="usuario" name="txtusuario"  onchange="load1(usuario.value,correo.value)" placeholder="Ingrese su usuario" required autofocus />
				</div>
				<div class="form-group">
					<input type="email" onchange="load1(usuario.value,correo.value)" id="correo" name="email" placeholder="Ingrese su correo" required>
				</div>
				<div class="form-group">
					<button type="button">Comprobar</button>
				</div>
				<div id="myDiv" class="container-fluid"></div>
				<p class="message"> <a href="#">Cancelar</a></p>
			</form>
		  <form class="login-form" accept-charset="UTF-8" role="form" method="post" action="index.php?view=processlogin">
				<div class="thumbnail"><img src="storage/businessman.png"/></div>
		    <input type="text" placeholder="Nombre de usuario" name="user" autofocus/>
		    <input type="password" placeholder="Contrase&ntilde;a" name="pass"/>
		    <button>Iniciar Sesi&oacute;n</button>
		    <p class="message">¿Olvidó su contraseña? <a href="#">Click Aquí</a></p>
		  </form>
		</div>
		<?php if (isset($_COOKIE["incpwd"])): ?>
			<div class="contenedor">
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning'></i> Usuario y/o contraseña incorrecto(s).</p>
					<p>Vuelva a intentarlo.</p>
				</div>
			</div>
		<?php
			setcookie("incpwd","",time()-18600);
		 	endif; ?>
	</div>
</div>
<script src="ajax/rsetpwd/ajax.js"></script>
<script src="js/login.js"></script>
