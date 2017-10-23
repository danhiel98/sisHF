<?php
  $product = ProductData::getById($_GET["id"]);
  if($product != null):
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
          <?php if($product->imagen != ""):?>
          <br>
          <img src="storage/products/<?php echo $product->imagen;?>" class="img-responsive">
          <?php endif;?>
        </div>
      </div>

      <div class="form-group">
        <label for="nombre" class="col-lg-3 control-label">Nombre*</label>
        <div class="col-md-8">
          <input type="text" name="nombre" class="form-control" id="nombre" value="<?php echo $product->nombre; ?>" placeholder="Nombre del Producto">
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
        </div>
      </div>

      <div class="form-group">
        <label for="descripcion" class="col-lg-3 control-label">Descripci&oacute;n</label>
        <div class="col-md-8">
          <textarea name="descripcion" class="form-control" id="descripcion" placeholder="Descripcion del Producto"><?php echo $product->descripcion;?></textarea>
        </div>
      </div>

      <div class="form-group">
        <label for="preciocosteo" class="col-lg-3 control-label">Precio de Costeo*</label>
        <div class="col-md-8">
          <input type="text" name="preciocosteo" class="form-control" value="<?php echo $product->preciocosteo; ?>" id="preciocosteo" placeholder="Precio de entrada">
        </div>
      </div>

      <div class="form-group">
        <label for="precioventa" class="col-lg-3 control-label">Precio de Venta*</label>
        <div class="col-md-8">
          <input type="text" name="precioventa" class="form-control" id="precioventa" value="<?php echo $product->precioventa; ?>" placeholder="Precio de salida">
        </div>
      </div>

      <div class="form-group">
        <label for="minimo" class="col-lg-3 control-label">Mínima en inventario:</label>
        <div class="col-md-8">
          <input type="text" name="minimo" class="form-control" value="<?php echo ProductoSucursalData::getBySucursalProducto(1,$product->id)->minimo;?>" id="minimo" placeholder="M&iacute;nima en Inventario">
        </div>
      </div>

      <div class="form-group">
				<label for="mantto" class="col-lg-3 control-label">Requiere Mantenimiento</label>
				<div class="col-md-6">
					<input type="checkbox" name="mantto" id="mantto" <?php if($product->mantenimiento){ echo "checked";}?>>
				</div>
			</div>

      <div class="form-group">
        <label for="is_active" class="col-lg-3 control-label" >Est&aacute; activo</label>
        <div class="col-md-8">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="is_active" <?php if($product->estado){ echo "checked";}?>>
            </label>
          </div>
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
<?php endif; ?>
