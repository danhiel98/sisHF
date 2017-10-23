<?php
	$updtG = false;
	$cq = false;

	if (isset($_COOKIE['question_updated'])):
		$cq = true;
	endif;

	if (isset($_POST["updateG"])) {
		include("controllers/general.php");
	}
	$user = UserData::getById($_SESSION["user_id"]);
	$pregs = SecretQuestionData::getAll();
?>
<div class="row">
	<h2>Actualizar Informaci&oacute;n De La Cuenta</h2>
	<br>
	<ul class="nav nav-tabs">
    <li <?php if(!$cq){echo "class='active'";} ?>><a href="#default">Datos Generales</a></li>
    <li><a href="#passwd">Contrase&ntilde;a</a></li>
		<li <?php if($cq){echo "class='active'";} ?>><a href="#secret">Pregunta De Recuperaci&oacute;n</a></li>
  </ul>
	<div class="tab-content">
		<div id="default" class="tab-pane fade <?php if(!$cq){echo 'in active';} ?> ">
			<div class="col-md-6">
				<h2>Modificar Datos</h2>
				<br>
				<form class="form-horizontal" action="" method="post">
					<div class="form-group control-group">
						<label for="username" class="control-label col-sm-2">Usuario</label>
            <div class="col-sm-10 controls">
							<?php $_SESSION["user_temp"] = $user->username; ?>
							<input class="form-control" type="text" name="username" id="username" placeholder="Nombre de usuario" maxlength="30" minlength="3" data-validation-regex-regex="[a-zA-Z]+[0-9]*" data-validation-regex-message="Nombre de usuario inválido" data-validation-ajax-ajax="ajax/usuario/result.php" value="<?php echo $user->username; ?>" required>
							<p class="help-block"></p>
            </div>
					</div>
					<div class="form-group control-group">
						<label for="email" class="control-label col-sm-2">Email</label>
            <div class="col-sm-10 controls">
            	<input type="email" id="email" name="email" class="form-control" placeholder="Correo Electr&oacute;nico" maxlength="100" required value="<?php echo $user->email; ?>">
            </div>
					</div>
					<div class="form-group">
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-success" type="submit" name="updateG" value="Actualizar Datos">
						</div>
					</div>
				</form>
				<?php if ($updtG): ?>
					<div class="form-group">
						<div class="alert alert-success alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<strong>Datos actualizados con &eacute;xito!</strong>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div id="passwd" class="tab-pane fade">
			<div class="col-md-6">
				<h2>Cambiar Contraseña</h2>
				<br>
				<form class="form-horizontal" id="changepasswd" method="post" action="index.php?view=changepasswd" role="form">

					<div class="form-group control-group">
		    		<label for="password" class="col-lg-4 control-label">Contraseña Actual</label>
		    		<div class="col-lg-8 controls">
							<input type="password" name="password" class="form-control" id="password" placeholder="Contrase&ntilde;a Actual" maxlength="30"  required>
							<p class="help-block"></p>
		    		</div>
		  		</div>

		  		<div class="form-group control-group">
		    		<label for="newpassword" class="col-lg-4 control-label">Nueva Contraseña</label>
		    		<div class="col-lg-8 controls">
		      		<input type="password" class="form-control"  id="newpassword" name="newpassword" placeholder="Nueva Contraseña" required>
							<p class="help-block"></p>
		    		</div>
		  		</div>

		  		<div class="form-group control-group">
		    		<label for="confirmnewpassword" class="col-lg-4 control-label">Confirmar Nueva Contraseña</label>
		    		<div class="col-lg-8 controls">
							<input type="password" name="confirmnewpassword" class="form-control" id="confirmnewpassword" placeholder="Confirmar Nueva Contraseña" maxlength="30" data-validation-match-match="newpassword" required>
							<p class="help-block"></p>
		    		</div>
		  		</div>

		  		<div class="form-group">
		    		<div class="col-lg-offset-4 col-lg-8">
		      		<button type="submit" class="btn btn-success">Cambiar Contraseña</button>
		    		</div>
		  		</div>
				</form>
			</div>
		</div>
		<div id="secret" class="tab-pane fade <?php if($cq){echo 'in active';} ?>">
			<div class="col-md-6">
				<h2>Cambiar Pregunta De Recuperaci&oacute;n</h2>
				<br>
				<form class="form-horizontal" id="changequestion" method="post" action="index.php?view=changeq" role="form">

					<div class="form-group control-group">
						<label class="col-lg-4 control-label">Pregunta Actual</label>
						<div class="col-lg-8">
							<h4><?php echo $user->getSecretQ()->pregunta; ?></h4>
						</div>
					</div>

					<div class="form-group control-group">
						<label for="respuestaactual" class="col-lg-4 control-label">Respuesta</label>
						<div class="col-lg-8 controls">
							<input type="password" class="form-control" id="respuestaactual" name="respuestaactual" placeholder="Respuesta de pregunta actual" required>
							<p class="help-block"></p>
						</div>
					</div>
					<hr>
					<div class="form-group control-group">
						<label for="question" class="col-lg-4 control-label">Elegir Pregunta</label>
						<div class="col-lg-8 controls">
							<select class="form-control" name="question" required>
								<?php foreach ($pregs as $p): ?>
									<option value="<?php echo $p->id; ?>"><?php echo $p->pregunta; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group control-group">
		    		<label for="newrespuesta" class="col-lg-4 control-label">Respuesta</label>
		    		<div class="col-lg-8 controls">
		      		<input type="password" class="form-control" id="newrespuesta" name="newrespuesta" placeholder="Intrdoduzca la respuesta" required>
							<p class="help-block"></p>
		    		</div>
		  		</div>

		  		<div class="form-group control-group">
		    		<label for="confirmnewrespuesta" class="col-lg-4 control-label">Confirmar Nueva Contraseña</label>
		    		<div class="col-lg-8 controls">
							<input type="password" name="confirmnewrespuesta" class="form-control" id="confirmnewrespuesta" placeholder="Confirmar respuesta" maxlength="30" data-validation-match-match="newrespuesta" required>
							<p class="help-block"></p>
		    		</div>
		  		</div>

					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-8">
							<button type="submit" class="btn btn-success">Actualizar Datos</button>
						</div>
					</div>

				</form>
				<?php if(isset($_COOKIE['question_updated'])):?>
	    		<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		    		<p><i class='glyphicon glyphicon-off'></i> Se ha cambiado pregunta de recuperaci&oacute;n exitosamente !!</p>
	    		</div>
	    	<?php setcookie("question_updated","",time()-18600);
	    	 endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
	    $(".nav-tabs a").click(function(){
	        $(this).tab('show');
	    });
	});
</script>
<br><br><br><br><br><br><br><br><br>
