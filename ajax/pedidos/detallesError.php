<!-- Este modal se mostrará en caso que no haya suficiente materia prima para finalizar la producción -->
<div class="modal fade" id="detalles" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class='fa fa-list'></i> Detalles</h4>
      </div>
      <div class="modal-body" id="modal-body">
        <div>
            <p class="alert alert-warning">No se puede marcar como entregado el pedido porque no hay suficientes <a target="_blank" href="index.php?view=inventarymp">productos.</a></p>
        </div>
        <div id="detallesProd">
          <!-- En este div se va a cargar los datos de la materia prima insuficiente -->
        </div>
      </div>
      <div class="modal-footer" id="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
