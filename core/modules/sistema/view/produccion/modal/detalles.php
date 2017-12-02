<div class="modal fade" id="detalles" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class='fa fa-list'></i> Detalles</h4>
      </div>
      <div class="modal-body" id="modal-body">
          <div>
              <p class="alert alert-warning">No se puede terminar la producción debido a que hay insuficiente <a target="_blank" href="index.php?view=inventarymp">materia prima.</a></p>
          </div>
          <div class="list-group">
              <?php if (isset($_SESSION["detalleError"])): ?>
              <?php foreach($_SESSION["detalleError"] as $mp): ?>
              <div class="list-group-item">
                <?php echo $mp->getMateriaPrima()->nombre; ?>
                <div class="pull-right">
                  <span data-toggle="tooltip" title="Existentes" class="label label-danger"><?php echo $mp->getMateriaPrima()->existencias; ?></span>
                  <span data-toggle="tooltip" title="Necesarios" class="label label-primary"><?php echo $mp->cantidad; ?></span>
                </div>
              </div>
              <?php endforeach; ?>
              <?Php endif; ?>
          </div>
      </div>
      <div class="modal-footer" id="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
