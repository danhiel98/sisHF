<?php
	$u = UserData::getById(Session::getUID());
	if (!$u->tipo == 1 || !$u->tipo == 2) {
		?>
		<script type="text/javascript">
			window.location = "index.php?view=home";
		</script>
		<?php
	}
	$emp = false;
	if (isset($_GET['emp']) && !empty($_GET['emp'])) {
		$emp = true;
		$empleado = EmpleadoData::getById($_GET['emp']);
	}else{
		@header("location: index.php?view=users");
	}
 ?>
<?php $user = UserData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Datos De Usuario</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateuser" role="form">
			<?php if ($emp): ?>
				<div class="form-group control-group">
			    <label for="name" class="col-lg-2 control-label">Empleado*</label>
			    <div class="col-md-6 controls">
						<input type="text" name="employ" value="<?php echo $empleado->nombre." ".$empleado->apellido;?>" class="form-control" id="name" placeholder="Nombres" pattern="[A-Za-zÁ-Úá-ú ]{3,}" maxlength="30" readonly>
			    </div>
			  </div>
			<?php else: ?>
		  <div class="form-group control-group">
		    <label for="name" class="col-lg-2 control-label">Nombres*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombres" pattern="[A-Za-zÁ-Úá-ú ]{3,}" maxlength="30">
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="lastname" class="col-lg-2 control-label">Apellidos*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" id="lastname" placeholder="Apellidos" pattern="[A-Za-zÁ-Úá-ú ]{3,}" maxlength="30">
		    </div>
		  </div>
		<?php endif; ?>
		  <div class="form-group control-group">
		    <label for="username" class="col-lg-2 control-label">Nombre De Usuario*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="username" value="<?php echo $user->username;?>" class="form-control" required id="username" placeholder="Nombre de usuario" maxlength="30">
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="email" class="col-lg-2 control-label">Email*</label>
		    <div class="col-md-6 controls">
		      <input type="email" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Email">
					<p class="help-block"></p>
		    </div>
		  </div>
			<!--
		  <div class="form-group control-group">
		    <label for="password" class="col-lg-2 control-label">Contrase&ntilde;a</label>
		    <div class="col-md-6 controls">
		      <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
		    </div>
		  </div>
			<div class="form-group control-group">
		    <label for="password2" class="col-lg-2 control-label">Repetir Contrase&ntilde;a*</label>
		    <div class="col-md-6 controls">
		      <input type="password" name="password2" class="form-control" id="password2" placeholder="Repetir Contrase&ntilde;a" maxlength="30" data-validation-match-match="password">
					<p class="help-block"></p>
					<p class="help-block has-feedback !important">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
		    </div>
		  </div>
			-->
		  <div class="form-group">
		    <label for="activo" class="col-lg-2 control-label" >Est&aacute; activo</label>
		    <div class="col-md-6">
					<div class="checkbox">
		    		<label>
		    			<input type="checkbox" name="activo" <?php if($user->activo){ echo "checked";}?>>
		    		</label>
		  		</div>
		    </div>
		  </div>

		  <div class="form-group">
		    <label for="isAdmin" class="col-lg-2 control-label" >Es administrador</label>
		    <div class="col-md-6">
					<div class="checkbox">
		    		<label>
		      		<input type="checkbox" name="isAdmin" <?php if($user->tipo == 2){ echo "checked";}?>>
		    		</label>
		  		</div>
		    </div>
		  </div>

		  <p class="alert alert-info">* Campos obligatorios</p>

		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
					<input type="hidden" name="idemploy" value="<?php echo $empleado->id; ?>">
		    	<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
		      <button type="submit" class="btn btn-primary">Actualizar Datos</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
