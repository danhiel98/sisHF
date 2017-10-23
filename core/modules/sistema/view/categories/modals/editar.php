<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=updatecategory" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Categor&iacute;a</h4>
        </div>
        <div class="modal-body">
          <div class="form-group control-group">
            <input type="hidden" name="eid" id="eid">
            <label for="nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-8 controls">
              <input type="text" class="form-control" name="ename" id="ename" placeholder="Nombre de la categor&iacute;a">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button name="updateCategory" type="submit" class="btn btn-md btn-primary" title="Registrar Categor&iacute;a" ><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
