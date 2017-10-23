<?php
	$incpwd = false;
	$_SESSION['rset'] = false;
	if(Session::getUID()!=""){
			print "<script>window.location='index.php?view=home';</script>";
	}
	if (isset($_SESSION['incpwd']) && $_SESSION['incpwd']) {
		$incpwd = true;
	}
?>
<br><br><br><br><br>
<div class="row vertical-offset-100">
    	<div class="col-md-4 col-md-offset-3">
    	<?php if(isset($_COOKIE['password_updated'])):?>
    		<div class="alert alert-success">
	    		<p><i class='glyphicon glyphicon-off'></i> Se ha cambiado la contraseña exitosamente !!</p>
	    		<p>Pruebe iniciar sesión con su nueva contraseña.</p>
    		</div>
    	<?php setcookie("password_updated","",time()-18600);
    	 endif; ?>
    		<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Iniciar Sesión</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" method="post" action="index.php?view=processlogin">
							<div class="form-group">
								<input class="form-control" placeholder="Usuario" name="user" type="text" autofocus>
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Contraseña" name="pass" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Iniciar Sesión">
							<a class="btn btn-lg btn-block btn-feedback" href="index.php?view=rsetpwd">Olvid&eacute; mi contrase&ntilde;a</a>
			      </form>
			    </div>
			</div>
			<?php if ($incpwd): ?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning'></i> Usuario y/o contraseña incorrecto(s).</p>
					<p>Vuelva a intentarlo.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
<br><br><br>
