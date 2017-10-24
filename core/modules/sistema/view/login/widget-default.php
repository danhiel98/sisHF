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
		  <form class="login-form" accept-charset="UTF-8" role="form" method="post" action="index.php?view=processlogin">
				<div class="thumbnail"><img src="storage/businessman.png"/></div>
		    <input type="text" placeholder="Nombre de usuario" name="user" autofocus/>
		    <input type="password" placeholder="Contrase&ntilde;a" name="pass"/>
		    <button>Iniciar Sesi&oacute;n</button>
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
