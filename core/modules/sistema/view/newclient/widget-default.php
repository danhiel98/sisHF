<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="index.php?view=clients"><i class="fa fa-arrow-left"></i> Regresar</a>
    <h1>Registrar Nuevo Cliente</h1>
    <br>
		<form class="form-horizontal" method="post" id="addclient" action="index.php?view=addclient" role="form" name="frmcliente">
			<div class="form-group control-group">
		    <label for="txtDui" class="col-lg-2 control-label">DUI*</label>
		    <div class="col-md-6">
		      <input autofocus type="text" name="txtDui" class="form-control" id="txtDui" maxlength="10" required data-validation-regex-regex="[0-9]{8}-[0-9]{1}" data-validation-regex-message="Introduzca un DUI válido" placeholder="DUI" onkeyup="fnc(this,'-',dui,true)" onpaste="return false" onkeypress="return soloNumeros(event)">
					<p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtNit" class="col-lg-2 control-label">NIT</label>
		    <div class="col-md-6">
		      <input type="text" name="txtNit" class="form-control" id="txtNit" maxlength="17" data-validation-regex-regex="[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}" data-validation-regex-message="Introduzca un NIT válido" placeholder="N&uacute;mero De NIT" onkeyup="fnc(this,'-',nit,true)" onpaste="return false" onKeyPress="return soloNumeros(event)">
					<p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtNrc" class="col-lg-2 control-label">NRC</label>
		    <div class="col-md-6">
		      <input type="text" name="txtNrc" maxlength="8" class="form-control" id="txtNrc" placeholder="N&uacute;mero De Registro De Contribuyente" onkeyup="fnc(this,'-',nrc,true)" onpaste="return false" onkeypress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{6}-[0-9]{1}" data-validation-regex-message="Introduzca un NCR válido" placeholder="N&uacute;mero De NCR">
		      <p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtNombre" class="col-lg-2 control-label">Nombres*</label>
		    <div class="col-md-6 controls">
		      <input type="text" name="txtNombre" class="form-control" id="txtNombre" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" placeholder="Nombres" onkeypress="return vNom(event,this)" required>
					<p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtApellido" class="col-lg-2 control-label">Apellidos</label>
		    <div class="col-md-6">
		      <input type="text" name="txtApellido" class="form-control" id="txtApellido" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un apellido válido"  placeholder="Apellidos" onkeypress="return vNom(event,this)">
					<p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="txtSexo" class="col-lg-2 control-label">Sexo</label>
		    <div class="col-md-6">
		        <select class="form-control" name="txtSexo">
							<option value="">--SELECCIONE--</option>
							<option value="Hombre">Hombre</option>
		          <option value="Mujer">Mujer</option>
		        </select>
		    </div>
		  </div>
		  <div class="form-group control-group">
				<label for="txtFechaNacimiento" class="col-lg-2 control-label">Fecha De Nacimiento</label>
		    <div class="col-md-6 controls">
        	<div class='input-group date' id='datetimepicker1'>
          	<input type="text" name="txtFechaNacimiento" id="birth" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido"/>
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
		      <textarea maxlength="150" name="txtDireccion" class="form-control" id="txtDireccion" placeholder="Direcci&oacute;n" required data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,}" data-validation-regex-message="Introduzca una dirección válida"></textarea>
          <p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="email" class="col-lg-2 control-label">Email</label>
		    <div class="col-md-6 controls">
		      <input type="email" name="email" class="form-control" id="email" placeholder="Email" maxlength="100">
					<p class="help-block"></p>
		    </div>
		  </div>
		  <div class="form-group control-group">
		    <label for="txtPhone" class="col-lg-2 control-label">Tel&eacute;fono*</label>
		    <div class="col-md-6">
		     <input type="text" name="txtPhone" class="form-control" id="txtPhone" placeholder="Telefono" onkeyup="fnc(this,'-',tel,true)" onpaste="return false" required onKeyPress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{4}-[0-9]{4}" data-validation-regex-message="Introduzca un número de teléfono válido" maxlength="9">
        <p class="help-block"></p>
		    </div>
		  </div>
		  <p class="alert alert-info">* Campos obligatorios</p>
		  <div class="form-group">
		    <div class="col-lg-offset-2 col-lg-10">
		      <button type="submit" class="btn btn-primary" >Agregar Cliente</button>
		    </div>
		  </div>
		</form>
	</div>
</div>
