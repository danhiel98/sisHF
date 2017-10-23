<?php
	$sucursales = SucursalData::getAll();
?>
<a href="index.php?view=empleados" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<script type="text/javascript" src="ajax/empleados/main.js"></script>
<div class="row">
	<div class="col-md-12">
		<h1>Registrar Empleado</h1>
		<br>
		<form class="form-horizontal" method="post" id="addemploy" action="index.php?view=addemploy" role="form">
			<div class="form-group control-group">
				<label for="txtSucursal" class="col-lg-2 control-label">Sucursal*</label>
				<div class="col-md-6 controls">
					<select name="txtSucursal" class="form-control" id="txtSucursal" required>
						<option value="">-- SELECCIONE --</option>
	 					<?php if (isset($_SESSION["user_suc"])): ?>
	 						<?php $suc = SucursalData::getById($_SESSION["user_suc"]); ?>
	 						<option value="<?php echo $suc->id; ?>"><?php echo $suc->nombre;?></option>
	 					<?php else: ?>
	 						<?php foreach($sucursales as $sucursal):?>
	 							<option <?php if(count($sucursales)==1){echo "selected";} ?> value="<?php echo $sucursal->id; ?>"><?php echo $sucursal->nombre;?></option>
	 			    	<?php endforeach;?>
	 					<?php endif; ?>
					</select>
				</div>
			</div>
			<div class="form-group control-group">
		    <label for="txtDui" class="col-lg-2 control-label">DUI*</label>
		    <div class="col-md-6 controls">
		      <input autofocus type="text" name="txtDui" class="form-control" id="txtDui" placeholder="DUI" maxlength="10" data-validation-regex-regex="[0-9]{8}-[0-9]{1}" data-validation-regex-message="Introduzca un DUI válido" onkeyup="fnc(this,'-',dui,true)" onpaste="return false" onkeypress="return soloNumeros(event)" data-validation-ajax-ajax="ajax/empleados/dui.php" required>
					<p class="help-block"></p>
				</div>
			</div>
		   <div class="form-group control-group">
		    <label for="txtNit" class="col-lg-2 control-label">NIT</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtNit" class="form-control" id="txtNit" maxlength="17" data-validation-regex-regex="[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}" data-validation-regex-message="Introduzca un NIT válido" placeholder="N&uacute;mero De NIT" onkeyup="fnc(this,'-',nit,true)" onpaste="return false" onKeyPress="return soloNumeros(event)" data-validation-ajax-ajax="ajax/empleados/nit.php" required>
					<p class="help-block"></p>
				</div>
		  </div>
			<div class="form-group control-group">
				<label for="txtNombre" class="col-lg-2 control-label">Nombres*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtNombre" class="form-control" id="txtNombre" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" onSubmit="return validarnombre()" placeholder="Nombres" onkeypress="return vNom(event,this)" required>
					<p class="help-block"></p>
				</div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtApellido" class="col-lg-2 control-label">Apellidos*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtApellido" required class="form-control" id="txtApellido" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un apellido válido"  placeholder="Apellidos" onkeypress="return vNom(event,this)" required>
					<p class="help-block"></p>
				</div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtSexo" class="col-lg-2 control-label">Sexo*</label>
		    <div class="col-md-6 controls">
					<select class="form-control" name="txtSexo" required>
						<option value="">--SELECCIONE--</option>
						<option>Hombre</option>
						<option>Mujer</option>
					</select>
		    </div>
		  </div>
			<div class="form-group control-group">
		    <label for="txtEsstadoCivil" class="col-lg-2 control-label">Estado Civil*</label>
		    <div class="col-md-6 controls">
		      <select class="form-control" name="txtEstadoCivil" required>
						<option value="">--SELECCIONE--</option>
						<option value="Soltero/a">Soltero/a</option>
						<option value="Casado/a">Casado/a</option>
						<option value="Acompañado/a">Acompañado/a</option>
		      </select>
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtFechaNacimiento" class="col-lg-2 control-label">Fecha De Nacimiento</label>
				<div class="col-md-6 controls">
					<div class='input-group date' id='datetimepicker1'>
						<input type="text" name="txtFechaNacimiento" id="birth" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" required/>
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
					<p class="help-block"></p>
				</div>
			</div>
		  <div class="form-group control-group">
		    <label for="txtNivelAcademico" class="col-lg-2 control-label">Nivel Académico*</label>
		    <div class="col-md-6 controls">
					<input type="text" class="form-control" name="txtNivelAcademico" id="txtNivelAcademico" placeholder="Nivel Académico Alcanzado" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{2,50}" data-validation-regex-message="Introduzca datos v&aacute;lidos" maxlength="50" required>
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtDepartamento" class="col-lg-2 control-label">Departamento*</label>
				<div class="col-md-6 controls">
					<select class="form-control selectpickerX" id="departamento" name="txtDepartamento" data-live-search="true" data-size="5" required>
						<option value="">--SELECCIONE--</option>
						<?php $deptos = DireccionData::getAllDeptos(); ?>
						<?php foreach ($deptos as $dep): ?>
							<option value="<?php echo $dep->id; ?>"><?php echo $dep->nombreDepto; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		  <div class="form-group control-group">
		    <label for="txtMunicipio" class="col-lg-2 control-label">Municipio*</label>
		    <div class="col-md-6 controls">
					<select disabled class="form-control selectpickerX" id="municipio" name="txtMunicipio" data-live-search="true" data-size="5" required>
						<option value="">--SELECCIONE--</option>
					</select>
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
				<div class="col-md-6 controls">
					<textarea maxlength="200" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n" required data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,100}" data-validation-regex-message="Introduzca una dirección válida"></textarea>
					<p class="help-block"></p>
				</div>
			</div>
		  <div class="form-group control-group">
		    <label for="txtTelefono" class="col-lg-2 control-label">Teléfono*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtTelefono" class="form-control" id="txtTelefono" placeholder="Número De Tel&eacute;fono" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9">
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtEspecialidad" class="col-lg-2 control-label">Especialidad*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtEspecialidad" class="form-control" id="txtEspecialidad" placeholder="Área En La Que Se Desempeña Mejor" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{2,50}" data-validation-regex-message="Introduzca datos v&aacute;lidos" maxlength="50" required>
		    </div>
			</div>
		  <p class="alert alert-info">* Campos obligatorios</p>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary">Agregar Empleado</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
