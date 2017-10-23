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

			if ($respuesta == $i_respuesta) {
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
				echo "<center><p class='alert alert-success ' ><b>¡Listo!</b> Su nueva contraseña a sido asignada con Éxito.  Contraseña: <b>$newpass</b></p></p></center>";
				#echo"<meta http-equiv='refresh' content='60; url=index.php'/ >";
			}else{
				echo "<center><p class='alert alert-danger ' ><b>¡Lo Sentimos!</b> La respuesta ingresada es incorrecta. No puede generarse su contraseña.</p></center>";
				#echo"<meta http-equiv='refresh' content='50; url=index.php?view=home'/ >";
			}
}

?>
<link rel="stylesheet" href="css/login.css">
<script src="ajax/rsetpwd/ajax.js"></script>
<div class="row vertical-offset-100">
	<div class="col-md-5 col-md-offset-2">
		<div class="info">
    	<h1></h1>
  	</div>
		<div class="form">
			<form class="form" action="index.php?view=rsetpwd" method="POST">
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
					<br>
					<div class="form-group">
						<a href="./" class="btn btn-default">Cancelar</a>
					</div>
			</form>
		</div>
	</div>
</div>
