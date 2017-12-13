<?php

  $found = false;
  if (isset($_GET["delAll"])){
    unset($_SESSION["cart"]);
    print "<script>window.location='index.php?view=sell';</script>";
  }
  $products = ProductData::getAll();
?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="index.php?view=processsell" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Venta</h4>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
        <div class="modal-footer" id="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>
