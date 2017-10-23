<?php
	$envio = EnvioData::getById($_GET["id"]);
	$bancos = BancoData::getAll();
?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Datos De Env&iacute;o</h1>
	<br>
	<form class="form-horizontal" method="post" id="updateenvio" action="index.php?view=updateenvio" role="form">
		<div class="form-group">
			<label for="banco" class="col-lg-2 control-label">Banco*</label>
			<div class="col-md-6">
				<select name="banco" class="form-control" id="banco" required>
					<option value="<?php echo $envio->getBanco()->id; ?>"><?php echo $envio->getBanco()->nombre; ?></option>
					<?php foreach($bancos as $banc):?>
						<option value="<?php echo $banc->id; ?>"><?php echo $banc->nombre;?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="cantidad" class="col-lg-2 control-label">Cantidad*</label>
			<div class="col-md-6">
				<input type="text" name="cantidad" class="form-control" id="cantidad" placeholder="Cantidad De Dinero A Enviar" value="<?php echo $envio->cantidad; ?>">
			</div>
		</div>
		<p class="alert alert-info">* Campos obligatorios</p>
		<input type="hidden" name="idEnvio" value="<?php echo $envio->id; ?>">
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10">
				<button type="submit" class="btn btn-primary">Modificar Env&iacute;o</button>
			</div>
		</div>
	</form>
</div>
		</div>
		 <script type="text/javascript">
		  function validar(){
		    var nombre, apellido, correo, usuario, clave, telefono, dui, nie;
		    nombre = document.getElementById("nombre").value;
		    apellido = document.getElementById("apellido").value;
		    correo = document.getElementById("correo").value;
		    usuario = document.getElementById("usuario").value;
		    clave = document.getElementById("clave").value;
		    telefono = document.getElementById("telefono").value;
		    dui = document.getElementById("dui").value;
		    nie = document.getElementById("nie").value;

		    if(nombre === ""){
		        alert(" el campo esta vacio");
		        return =false;
		    }
		}
		</script>
