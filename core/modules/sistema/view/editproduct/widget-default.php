<?php

	$idSuc = $_SESSION["usr_suc"];
	$product = null;
	
	if(isset($_GET["id"]) && is_numeric($_GET["id"])){
		$id = $_GET["id"];
		$product = ProductData::getById($id);
	}

	if(is_null($product) || $idSuc != 1){
		error();
	}
	
?>
<a href="index.php?view=products" class="btn btn-default"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="row">
	<div class="col-md-8">
	  <h1><?php echo $product->nombre ?> <small>Editar Producto</small></h1>
    <?php if(isset($_COOKIE["prdupd"])):?>
    <p class="alert alert-info">La información del producto se ha actualizado exitosamente.</p>
    <?php setcookie("prdupd","",time()-18600); endif; ?>
	  <br><br>
		<form class="form-horizontal" method="post" id="update" enctype="multipart/form-data" action="index.php?view=updateproduct" role="form">
			<div class="form-group">
				<label for="imagen" class="col-lg-3 control-label">Imagen*</label>
				<div class="col-md-8">
					<input type="file" name="imagen" id="imagen" placeholder="">
					<?php if($product->imagen != "" && file_exists("storage/products/".$product->imagen)):?>
					<br>
					<img src="storage/products/<?php echo $product->imagen;?>" class="img-responsive">
					<?php endif;?>
				</div>
				<p class="help-block"></p>
			</div>

			<div class="form-group control-group">
				<label for="nombre" class="col-lg-3 control-label">Nombre*</label>
				<div class="col-md-8">
					<input type="text" maxlength="30" data-validation-regex-regex="[A-Za-zÁ-Úá-ú ]{3,}" data-validation-regex-message="Introduzca un nombre válido" placeholder="Nombres" onkeypress="return vNom(event,this)" name="nombre" class="form-control" id="nombre" value="<?php echo $product->nombre; ?>" placeholder="Nombre del Producto" required>
					<p class="help-block"></p> 
				</div>
          	</div>

			<div class="form-group control-group">
				<label for="category" class="col-lg-3 control-label">Categor&iacute;a</label>
				<div class="col-md-8 controls">
					<select name="category" class="form-control" required>
						<?php $categorias = CategoryData::getAll(); ?>
						<?php foreach($categorias as $category):?>
							<?php if ($product->idcategoria == $category->id): ?>
							<option selected value="<?php echo $category->id;?>"><?php echo $category->nombre;?></option>
							<?php else: ?>
							<option value="<?php echo $category->id;?>"><?php echo $category->nombre;?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
					<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="descripcion" class="col-lg-3 control-label">Descripci&oacute;n</label>
				<div class="col-md-8 controls">
				<textarea name="descripcion" class="form-control" id="descripcion" data-validation-regex-regex="[0-9A-Za-zÁ-Úá-ú#°/,. ]{3,100}" data-validation-regex-message="Introduzca una descripción válida"  placeholder="Descripcion del Producto" required><?php echo $product->descripcion;?></textarea>
				<p class="help-block"></p>
				</div>
        	</div>

			<div class="form-group control-group">
				<label for="preciocosteo" class="col-lg-3 control-label">Precio de Costeo*</label>
				<div class="col-md-8 controls">
				<input type="text" name="preciocosteo" class="form-control" value="<?php echo $product->preciocosteo; ?>" id="preciocosteo" placeholder="Precio de entrada" onkeypress="return precio(event)" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required>
				<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="precioventa" class="col-lg-3 control-label">Precio de Venta*</label>
				<div class="col-md-8 controls">
				<input type="text" name="precioventa" onkeypress="return precio(event)" class="form-control" id="precioventa" value="<?php echo $product->precioventa; ?>" placeholder="Precio de salida" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Introduzca una cantidad v&aacute;lida" maxlength="9" min="1" required>
				<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="minimo" class="col-lg-3 control-label">Mínima en inventario:</label>
				<div class="col-md-8 controls">
				<input type="text" name="minimo" onkeypress="return soloNumeros(event)" data-validation-regex-regex="[0-9]{1,9}" data-validation-regex-message="Introduzca un M&iacute;nima en Inventario válido" onpaste="return false"  maxlength="9" min="1" class="form-control" value="<?php echo ProductoSucursalData::getBySucursalProducto(1,$product->id)->minimo;?>" id="minimo" placeholder="M&iacute;nima en Inventario" required>
				<p class="help-block"></p>
				</div>
			</div>

			<div class="form-group control-group">
				<label for="mantto" class="col-lg-3 control-label">Requiere Mantenimiento</label>
				<div class="col-md-6 controls">
					<input type="checkbox" name="mantto" id="mantto" <?php if($product->mantenimiento){ echo "checked";}?>>
				</div>
			</div>

			<div class="form-group control-group" id="mesesMantto-group" <?php if(!$product->mantenimiento){ echo "style='display: none;'";} ?>>
				<label for="mesesMantto" class="col-lg-3 control-label">Meses para Mantenimiento</label>
				<div class="col-md-6 controls">
					<input type="text" name="mesesMantto" id="mesesMantto" class="form-control" placeholder="Meses de espera para dar el mantenimiento" data-validation-regex-regex="[0-9]{1,3}" data-validation-regex-message="Cantidad de meses no válida" maxlength="3" minlength="1" min="1" value="<?php echo $product->mesesmantto;?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-3 col-lg-8">
				<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
				<button type="submit" class="btn btn-success">Actualizar Datos</button>
				</div>
			</div>
    	</form>
    	<br>
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
