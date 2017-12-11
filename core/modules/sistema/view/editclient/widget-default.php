<?php
	if (isset($_GET["id"])) {
		$user = ClientData::getById($_GET["id"]);
	}else{
		echo "<script>window.location='index.php?view=clients';</script>";
	}
	if (is_null($user)) {
		@header("location: index.php?view=clients");
	}
 ?>
<div class="row">
	<a class="btn btn-default" href="index.php?view=clients"><i class="fa fa-arrow-left"></i> Regresar</a>
	<div class="col-md-12">
	<h1>Editar Datos De Cliente</h1>
	<br>
	<form class="form-horizontal" method="post" action="index.php?view=updateclient" role="form" name="frmcliente">
		<div class="form-group control-group">
			<label for="txtDui" class="col-lg-2 control-label">DUI*</label>
			<div class="col-md-6">
				<input autofocus type="text" name="txtDui" class="form-control" id="txtDui" maxlength="10" required data-validation-regex-regex="[0-9]{8}-[0-9]{1}" data-validation-regex-message="Introduzca un DUI válido" placeholder="DUI" onkeyup="fnc(this,'-',dui,true)" onpaste="return false" onkeypress="return soloNumeros(event)" value="<?php echo $user->dui;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtNit" class="col-lg-2 control-label">NIT</label>
			<div class="col-md-6">
				<input type="text" name="txtNit" class="form-control" id="txtNit" maxlength="17" data-validation-regex-regex="[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}" data-validation-regex-message="Introduzca un NIT válido" placeholder="N&uacute;mero De NIT" onkeyup="fnc(this,'-',nit,true)" onpaste="return false" onKeyPress="return soloNumeros(event)" value="<?php echo $user->nit;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtNrc" class="col-lg-2 control-label">NRC</label>
			<div class="col-md-6">
				<input type="text" name="txtNrc" maxlength="8" class="form-control" id="txtNrc" placeholder="N&uacute;mero De Registro De Contribuyente" onkeyup="fnc(this,'-',nrc,true)" onpaste="return false" onkeypress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{6}-[0-9]{1}" data-validation-regex-message="Introduzca un NCR válido" placeholder="N&uacute;mero De NCR" value="<?php echo $user->nrc;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtNombre" class="col-lg-2 control-label">Nombres*</label>
			<div class="col-md-6 controls">
				<input type="text" name="txtNombre" class="form-control" id="txtNombre" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" placeholder="Nombres" onkeypress="return vNom(event,this)" required value="<?php echo $user->name;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtApellido" class="col-lg-2 control-label">Apellidos</label>
			<div class="col-md-6">
				<input type="text" name="txtApellido" class="form-control" id="txtApellido" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un apellido válido"  placeholder="Apellidos" onkeypress="return vNom(event,this)" value="<?php echo $user->lastname;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group">
			<label for="txtSexo" class="col-lg-2 control-label">Sexo*</label>
			<div class="col-md-6">
				<select class="form-control" name="txtSexo">
					<option value="">--SELECCIONE--</option>
					<?php if ($user->sexo == "Hombre"): ?>
						<option selected>Hombre</option>
						<option>Mujer</option>
					<?php elseif($user->sexo == "Mujer"): ?>
						<option>Hombre</option>
						<option selected>Mujer</option>
					<?php else: ?>
						<option>Hombre</option>
						<option>Mujer</option>
					<?php endif; ?>
				</select>
			</div>
		</div>
		<?php
			if (!is_null($user->birth)):
				$fecha = array_reverse(preg_split("[-]",$user->birth));
				$user->birth = $fecha[0]."/".$fecha[1]."/".$fecha[2];
		?>
			<script type="text/javascript">
				$(function () {
					$("#birth").val("<?php echo $user->birth; ?>");
				});
			</script>
		<?php endif; ?>
		<div class="form-group control-group">
			<label for="txtFechaNacimiento" class="col-lg-2 control-label">Fecha De Nacimiento</label>
			<div class="col-md-6 controls">
				<div class='input-group date' id='datetimepicker1'>
					<input type="text" id="birth" name="txtFechaNacimiento" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" value="<?php echo $user->birth;?>"/>
					<span class="input-group-addon">
						<span class="fa fa-calendar"></span>
					</span>
				</div>
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
			<div class="col-md-6 controls">
				<textarea maxlength="150" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n" required data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,}" data-validation-regex-message="Introduzca una dirección válida"><?php echo $user->direccion; ?></textarea>
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtEmail" class="col-lg-2 control-label">Email</label>
			<div class="col-md-6 controls">
				<input type="email" name="txtEmail" class="form-control" id="txtEmail" placeholder="Email" maxlength="100" value="<?php echo $user->email;?>">
				<p class="help-block"></p>
			</div>
		</div>
		<div class="form-group control-group">
			<label for="txtPhone" class="col-lg-2 control-label">Tel&eacute;fono*</label>
			<div class="col-md-6">
			 <input type="text" name="txtPhone" class="form-control" id="txtPhone" placeholder="Telefono" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9" value="<?php echo $user->phone;?>">
			<p class="help-block"></p>
			</div>
		</div>
	  <p class="alert alert-info">* Campos obligatorios</p>
	  <div class="form-group">
	    <div class="col-lg-offset-2 col-lg-10">
	    	<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
	      <button type="submit" class="btn btn-primary">Actualizar Datos</button>
	    </div>
	  </div>
	</form>
	</div>
</div>
