    <?php 
$categories = CategoryData::getAll();
    ?>
<div class="row">
  	<div class="col-md-12">
    	   <h1>Nueva Devoluci&oacute;n</h1>
      <br>
      <form class="form-horizontal" method="post" enctype="multipart/form-data" id="adddevolucion" action="index.php?view=adddevolucion" role="form">
           <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Cliente</label>
          <div class="col-md-6">
            <select name="category_id" class="form-control">
              <option value="">-- NINGUNO --</option>
                <?php foreach($categories as $category):?>
              <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                <?php endforeach;?>
              </select>    
            </div>
        </div>

         <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Producto</label>
          <div class="col-md-6">
            <select name="category_id" class="form-control">
              <option value="">-- NINGUNA --</option>
                <?php foreach($categories as $category):?>
              <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
                <?php endforeach;?>
              </select>    
            </div>
        </div>
        
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Motivo</label>
          <div class="col-md-6">
            <select class="form-control">
              <option>Entrega Tard&iacute;a</option>
              <option>Mala atencion al cliente</option>
              <option>Producto Dañado de Fabrica</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail1" class="col-lg-2 control-label">Fecha</label>
          <div class="col-md-6">
            <input type="date" name="fecha" class="form-control" id="fecha">
          </div>
        </div>
        
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <button type="submit" class="btn btn-primary">Registrar Devoluci&oacute;</button>
            </div>
          </div>
    </form>

  </div>
</div>