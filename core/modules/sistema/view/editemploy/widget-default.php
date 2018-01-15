<?php

	$u = UserData::getById(Session::getUID());
	if (!$u->tipo == 1 || !$u->tipo == 2):
?>
		<script type="text/javascript">
			window.location = "index.php?view=home";
		</script>
<?php
	endif;
	$sc = false; #Para ver si se encentran más de 0 sucursales
	$empleado = EmpleadoData::getById($_GET["id"]);
	if (is_null($empleado)) {
		@header("location: index.php?view=empleados");
	}
	$sucursales = SucursalData::getAll();
	if (count($sucursales) > 0) {
		$sc = true;
	}
?>
<a href="index.php?view=empleados" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<script type="text/javascript" src="ajax/empleados/main.js"></script>
<div class="row">
	<div class="col-md-12">
		<h1>Actualizar Datos</h1>
		<br>
		<form class="form-horizontal" method="post" id="addemploy" action="index.php?view=updateemploy" role="form">
			<div class="form-group control-group">
 		    <label for="txtSucursal" class="col-lg-2 control-label">Sucursal*</label>
 		    <div class="col-md-6 controls">
 		    	<select name="txtSucursal" class="form-control" id="txtSucursal" required>
					<option value="">--SELECCIONE--</option>
					<?php if (isset($_SESSION["usr_suc"]) && !isset($_SESSION["adm"])): ?>
						<?php $suc = SucursalData::getById($_SESSION["usr_suc"]); ?>
						<option selected value="<?php echo $suc->id; ?>"><?php echo $suc->nombre;?></option>
					<?php else: ?>
						<?php if ($sc): ?>
						<?php foreach($sucursales as $sucursal):?>
						<option <?php if ($empleado->getSucursal()->id == $sucursal->id){echo 'selected';} ?> value="<?php echo $sucursal->id; ?>"><?php echo $sucursal->nombre;?></option>
						<?php endforeach;?>
						<?php endif; ?>
					<?php endif; ?>						
 		      </select>
 		    </div>
 		  </div>
			<div class="form-group control-group">
		    <label for="txtDui" class="col-lg-2 control-label">DUI*</label>
		    <div class="col-md-6 controls">
					<?php $_SESSION["emp_dui"] = $empleado->dui; ?>
		      <input autofocus type="text" name="txtDui" class="form-control" id="txtDui" placeholder="DUI" maxlength="10" data-validation-regex-regex="[0-9]{8}-[0-9]{1}" data-validation-regex-message="Introduzca un DUI válido" onkeyup="fnc(this,'-',dui,true)" onpaste="return false" onkeypress="return soloNumeros(event)" value="<?php echo $empleado->dui; ?>" data-validation-ajax-ajax="ajax/empleados/dui.php" required>
					<p class="help-block"></p>
				</div>
		  </div>
			<div class="form-group control-group">
				<label for="txtNit" class="col-lg-2 control-label">NIT*</label>
		    <div class="col-md-6 controls">
					<?php $_SESSION["emp_nit"] = $empleado->nit; ?>
		      <input type="text" name="txtNit" class="form-control" id="txtNit" maxlength="17" data-validation-regex-regex="[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}" data-validation-regex-message="Introduzca un NIT válido" placeholder="N&uacute;mero De NIT" onkeyup="fnc(this,'-',nit,true)" onpaste="return false" onKeyPress="return soloNumeros(event)" value="<?php echo $empleado->nit; ?>" data-validation-ajax-ajax="ajax/empleados/nit.php" required>
					<p class="help-block"></p>
				</div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtNombre" class="col-lg-2 control-label">Nombres*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtNombre" class="form-control" id="txtNombre" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" placeholder="Nombres" onkeypress="return vNom(event,this)" required value="<?php echo $empleado->nombre; ?>">
					<p class="help-block"></p>
				</div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtApellido" class="col-lg-2 control-label">Apellidos*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtApellido" required class="form-control" id="txtApellido" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un apellido válido"  placeholder="Apellidos" onkeypress="return vNom(event,this)" required value="<?php echo $empleado->apellido; ?>">
					<p class="help-block"></p>
				</div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtSexo" class="col-lg-2 control-label">Sexo*</label>
		    <div class="col-md-6 controls">
					<select class="form-control" name="txtSexo" required>
					<?php if ($empleado->sexo == "Hombre"): ?>
						<option selected>Hombre</option>
						<option>Mujer</option>
					<?php elseif($empleado->sexo == "Mujer"): ?>
						<option>Hombre</option>
			       <option selected>Mujer</option>
					<?php endif; ?>
					</select>
		    </div>
		  </div>
			<div class="form-group control-group">
		    <label for="txtEsstadoCivil" class="col-lg-2 control-label">Estado Civil*</label>
		    <div class="col-md-6 controls">
					<select class="form-control" name="txtEstadoCivil" required>
					<?php if ($empleado->estadocivil == "Soltero/a"): ?>
						<option selected value="Soltero/a">Soltero/a</option>
						<option value="Casado/a">Casado/a</option>
						<option value="Acompañado/a">Acompañado/a</option>
					<?php elseif($empleado->estadocivil == "Casado/a"): ?>
						<option value="Soltero/a">Soltero/a</option>
						<option selected value="Casado/a">Casado/a</option>
						<option value="Acompañado/a">Acompañado/a</option>
					<?php elseif($empleado->estadocivil == "Acompañado/a"): ?>
						<option value="Soltero/a">Soltero/a</option>
						<option selected value="Casado/a">Casado/a</option>
						<option selected="Acompañado/a">Acompañado/a</option>
					<?php endif; ?>
		      </select>
		    </div>
		  </div>
			<?php if ($empleado->fechanacimiento != null): ?>
			<?php
				$fecha = array_reverse(preg_split("[-]",$empleado->fechanacimiento));
				$empleado->fechanacimiento = $fecha[0]."/".$fecha[1]."/".$fecha[2];
			?>
			<script type="text/javascript">
				$(function () {
						$("#birth").val("<?php echo $empleado->fechanacimiento; ?>");
				});
			</script>
			<?php endif; ?>
			<div class="form-group control-group">
				<label for="txtFechaNacimiento" class="col-lg-2 control-label">Fecha De Nacimiento*</label>
				<div class="col-md-6 controls">
					<div class='input-group date' id='datetimepicker1'>
						<input type="text" name="txtFechaNacimiento" id="birth" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" required value="<?php echo $empleado->fechanacimiento; ?>"/>
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
					<input type="text" class="form-control" name="txtNivelAcademico" id="txtNivelAcademico" placeholder="Nivel Académico Alcanzado" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{2,50}" data-validation-regex-message="Introduzca datos v&aacute;lidos" maxlength="50" required value="<?php echo $empleado->nivelacademico; ?>">
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtDepartamento" class="col-lg-2 control-label">Departamento*</label>
				<div class="col-md-6 controls">
					<select class="form-control selectpickerX" id="departamento" name="txtDepartamento" data-live-search="true" data-size="5">
						<option value="">--SELECCIONE--</option>
						<?php $deptos = DireccionData::getAllDeptos(); ?>
						<?php foreach ($deptos as $dep): ?>
							<option value="<?php echo $dep->id;?>" <?php if($dep->id == $empleado->idDepto){echo " selected";} ?>><?php echo $dep->nombreDepto; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group control-group">
		    <label for="txtMunicipio" class="col-lg-2 control-label">Municipio*</label>
		    <div class="col-md-6 controls">
					<select class="form-control selectpickerX" id="municipio" name="txtMunicipio" data-live-search="true" data-size="5">
						<?php $munics = DireccionData::getMunicsByDeptoId($empleado->idDepto); ?>
						<?php foreach ($munics as $mun): ?>
							<option value="<?php echo $mun->id;?>" <?php if($mun->id == $empleado->idMunic){echo " selected";} ?>><?php echo $mun->nombreMunic; ?></option>
						<?php endforeach; ?>
					</select>
		    </div>
		  </div>
			<div class="form-group control-group">
				<label for="txtDireccion" class="col-lg-2 control-label">Direcci&oacute;n*</label>
				<div class="col-md-6 controls">
					<textarea maxlength="200" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n" required data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,100}" data-validation-regex-message="Introduzca una dirección válida"><?php echo $empleado->direccion; ?></textarea>
					<p class="help-block"></p>
				</div>
			</div>
		  <div class="form-group control-group">
		    <label for="txtTelefono" class="col-lg-2 control-label">Teléfono*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtTelefono" class="form-control" id="txtTelefono" placeholder="Número De Tel&eacute;fono" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9" value="<?php echo $empleado->telefono; ?>">
		    </div>
		  </div>
			<div class="form-group control-group">
		    <label for="txtEspecialidad" class="col-lg-2 control-label">Especialidad*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtEspecialidad" class="form-control" id="txtEspecialidad" placeholder="Área En La Que Se Desempeña Mejor" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{2,50}" data-validation-regex-message="Introduzca datos v&aacute;lidos" maxlength="50" required value="<?php echo $empleado->area; ?>">
		    </div>
		  </div>

			<p class="alert alert-info">* Campos obligatorios</p>
			<input type="hidden" name="idEmpleado" value="<?php echo $empleado->id; ?>">
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary">Actualizar Datos</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
