<?php
	
	$empleados = EmpleadoData::getAllForUser();
	
	if (isset($_SESSION["usr_suc"]) && !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllForUserBySucId($_SESSION["usr_suc"]);
	}

	if(count($empleados) <= 0){
		error();
	}
	#Obtener los tipos de usuraios existentes
	$tipos = UserTypeData::getAll();
	
	// @header("location: index.php?view=users");
?>
<script type="text/javascript" src="ajax/usuario/ajax.js"></script>
<a href="index.php?view=users" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="row">
	<div class="col-md-12">
	<h1>Agregar Usuario</h1>
	<br>
		<form class="form-horizontal" method="post" id="adduser" action="index.php?view=adduser" role="form">
			<!-- <?php #if (!$emp): ?>
			<div class="form-group control-group">
			    <label for="name" class="col-lg-2 control-label">Nombres*</label>
			    <div class="col-md-6 controls">
			    	<input autofocus type="text" name="name" class="form-control" id="name" placeholder="Nombres" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" maxlength="30" required>
			    </div>
			</div>
			<div class="form-group control-group">
				<label for="lastname" class="col-lg-2 control-label">Apellidos*</label>
				<div class="col-md-6 controls">
					<input type="text" name="lastname" class="form-control" id="lastname" placeholder="Apellidos" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un apellido válido" maxlength="30" required>
				</div>
			</div>
			<?php #else: ?> -->
			<div class="form-group">
			    <label for="employ" class="col-lg-2 control-label">Empleado*</label>
			    <div class="col-md-6">
			      <select name="employ" id="employ" class="form-control selectpicker" data-live-search="true" data-size="5" required>
						<option value="">--SELECCIONE--</option>
						<?php foreach ($empleados as $emp): ?>
							<option value="<?php echo $emp->id; ?>"><?php echo $emp->nombre." ".$emp->apellido; ?></option>
						<?php endforeach; ?>
			      </select>
			    </div>
			  </div>
			<?php #endif; ?>
			
			<div class="form-group control-group">
				<label for="sucursal" class="col-lg-2 control-label">Sucursal*</label>
				<div class="col-md-6 controls">
					<input class="form-control" type="text" name="sucursal" id="sucursal" placeholder="Sucursal" readonly required>
					<div class="help-block"></div>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="username" class="col-lg-2 control-label">Nombre De Usuario*</label>
				<div class="col-md-6 controls">
					<input type="hidden" name="usr" id="usr" value="">
					<input class="form-control" type="text" name="username" id="username" placeholder="Nombre de usuario" maxlength="30" minlength="3" data-validation-regex-regex="[a-zA-Z]+[0-9]*" data-validation-regex-message="Nombre de usuario inválido" data-validation-ajax-ajax="ajax/usuario/result.php" required>
					<div class="help-block"></div>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="email" class="col-lg-2 control-label">Email*</label>
				<div class="col-md-6 controls">
				<input type="email" name="email" class="form-control" id="email" placeholder="Email" maxlength="100" data-validation-ajax-ajax="ajax/email/result.php" required>
						<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="password" class="col-lg-2 control-label">Contrase&ntilde;a*</label>
				<div class="col-md-6 controls">
				<input type="password" name="password" class="form-control" id="password" placeholder="Contrase&ntilde;a" maxlength="30" data-validation-regex-regex="[\w\d].*" data-validation-regex-message="Contraseña ingresada inválida" minlength="3" required>
						<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="password2" class="col-lg-2 control-label">Repetir Contrase&ntilde;a*</label>
				<div class="col-md-6 controls">
				<input type="password" name="password" class="form-control" id="password2" placeholder="Repetir Contrase&ntilde;a" maxlength="30" data-validation-match-match="password" required>
						<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group">
				<label for="tipo" class="col-lg-2 control-label">Tipo*</label>
				<div class="col-md-6">
					<select name="tipo" id="tipo" class="form-control" required>
						<option value="">--SELECCIONE--</option>
						<?php foreach ($tipos as $tipo): ?>
							<option value="<?php echo $tipo->id; ?>"><?php echo $tipo->nombre; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

		  	<p class="alert alert-info">* Campos obligatorios</p>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-primary">Agregar Usuario</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$("#employ").on("change",function(){
		id = $(this).val();
		if (id != null){
			$.ajax({
				url: "ajax/usuario/infoEmp.php",
				type: "POST",
				data: {
					id: id
				},
				success: function(data){
					if (data != ""){
						var oDato = JSON.parse(data);
						$("#sucursal").val(oDato.nombreSucursal);
					}else{
						$("#sucursal").val("");				
					}
				}
			});
		}
	});
</script>