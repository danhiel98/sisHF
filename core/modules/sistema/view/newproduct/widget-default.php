<?php

	$idSuc = $_SESSION["usr_suc"];

	if ($idSuc != 1){
		error();
	}

?>

<a href="index.php?view=products" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="row">
	<div class="col-md-12">
		<h1>Nuevo Producto</h1>
		<br>
		<form class="form-horizontal" method="post" enctype="multipart/form-data" id="addproduct" action="index.php?view=addproduct" role="form">
			<div class="form-group">
				<label for="imagen" class="col-lg-2 control-label">Imagen</label>
				<div class="col-md-6">
					<input type="file" name="imagen" id="imagen" placeholder="">
				</div>
			</div>
			<div class="form-group control-group">
				<label for="nombre" class="col-lg-2 control-label">Nombre*</label>
				<div class="col-md-6 controls">
					<input type="text" name="nombre" required class="form-control" id="nombre" placeholder="Nombre del Producto"  maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" placeholder="Nombres" onkeypress="return vNom(event,this)">
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="category" class="col-lg-2 control-label">Categor&iacute;a</label>
				<div class="col-md-6 controls">
				<select name="category" class="form-control" required>
								<?php $categorias = CategoryData::getAll(); ?>
					<option value="">--SELECCIONE--</option>
					<?php foreach($categorias as $category):?>
					<option value="<?php echo $category->id;?>"><?php echo $category->nombre;?></option>
					<?php endforeach; ?>
				</select>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="descripcion" class="col-lg-2 control-label">Descripci&oacute;n</label>
				<div class="col-md-6 controls">
					<textarea maxlength="200" name="descripcion" class="form-control" id="descripcion" placeholder="Descripci&oacute;n del Producto" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,200}" data-validation-regex-message="Introduzca una descripción válida" required></textarea>
					<p class="help-block"></p>
				</div>
			</div>
			<div class="form-group control-group">
				<label for="preciocosteo" class="col-lg-2 control-label">Precio de Costeo*</label>
				<div class="col-md-6 controls">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-fw fa-dollar"></i>
						</span>
						<input type="text" name="preciocosteo" onkeypress="return precio(event)" required class="form-control" id="preciocosteo" placeholder="Precio de entrada" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required>
			
					</div>
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="precioventa" class="col-lg-2 control-label">Precio de Venta*</label>
				<div class="col-md-6 controls">
					<div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-fw fa-dollar"></i>
						</span>
						<input type="text" name="precioventa" onkeypress="return precio(event)" required class="form-control" id="precioventa" placeholder="Precio de salida" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required>
					</div>
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="minimo" class="col-lg-2 control-label">M&iacute;nima en Inventario*</label>
				<div class="col-md-6 controls">
				<input type="text" name="minimo" onkeypress="return soloNumeros(event)" class="form-control" id="minimo" placeholder="Cantidad m&iacute;nima en inventario" data-validation-regex-regex="[0-9]{1,9}" data-validation-regex-message="Introduzca un M&iacute;nima en Inventario válido" onpaste="return false" maxlength="9" min="1" required>
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="inicial" class="col-lg-2 control-label">Inventario Inicial</label>
				<div class="col-md-6 controls">
				<input type="text" name="inicial" class="form-control" id="inicial" onkeypress="return soloNumeros(event)" placeholder="Inventario Inicial" data-validation-regex-regex="[0-9]{1,9}" data-validation-regex-message="Introduzca un Inventario Inicial válido" onpaste="return false" maxlength="9" min="0" required>
					<p class="help-block"></p>
				</div>
			</div>
			
			<div class="form-group control-group">
				<label for="mantto" class="col-lg-2 control-label">Requiere Mantenimiento</label>
				<div class="col-md-6 controls">
					<input type="checkbox" name="mantto" id="mantto">
				</div>
			</div>

			<div class="form-group control-group" id="mesesMantto-group" style="display: none;">
				<label for="mesesMantto" class="col-lg-2 control-label">Meses para Mantenimiento</label>
				<div class="col-md-6 controls">
					<input type="text" name="mesesMantto" id="mesesMantto" class="form-control" placeholder="Meses de espera para dar el mantenimiento" data-validation-regex-regex="[0-9]{1,3}" data-validation-regex-message="Cantidad de meses no válida" maxlength="3" minlength="1" min="1">
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button name="addProduct" type="submit" class="btn btn-primary">Agregar Producto</button>
				</div>
			</div>
    	</form>
  	</div>
</div>
<script>
	grupo = $("#mesesMantto-group");
	input = grupo.find("#mesesMantto");
	$("#mantto").on("change", function(){
		if(this.checked){
			input.attr("required","required");
			grupo.show();
		}else{
			input.removeAttr("required");
			input.val("");
			grupo.hide();
		}
	});
</script>