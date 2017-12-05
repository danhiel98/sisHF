<?php
  @session_start();
  include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ProviderData.php");
  include ("../../core/modules/sistema/model/MateriaPrimaData.php");
  $proveedores = ProviderData::getAll();
  $found = false;
?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="index.php?view=processre" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Compra</h4>
        </div>
        <div class="modal-body">
          <?php if(isset($_SESSION["reabastecerMP"]) && !empty($_SESSION["reabastecerMP"])):
            $found = true;
        		$total = 0;
        	?>
          <div class="col-md-12">
            <div class="form-group control-group">
              <label for="tipo" class="col-sm-4 control-label">Proveedor</label>
              <div class="controls col-sm-8">
                <select name="proveedor" class="form-control" required>
      		    		<option value="">-- NINGUNO --</option>
      		    		<?php foreach($proveedores as $prov):?>
      		    		<option value="<?php echo $prov->id;?>"><?php echo $prov->nombre;?></option>
      		    		<?php endforeach;?>
      		    	</select>
              </div>
            </div>
            <div class="form-group control-group">
              <label for="tipo" class="col-sm-4 control-label">Comprobante</label>
              <div class="controls col-sm-8">
                <select class="form-control" name="tipo" id="tipo" required>
                  <option value="">--SELECCIONE--</option>
                  <option value="1">Factura</option>
                  <option value="2">Cr&eacute;dito Fiscal</option>
                </select>
              </div>
            </div>
            <div class="form-group control-group">
              <label for="numero" class="col-sm-4 control-label">No. Comprobante</label>
              <div class="controls col-sm-8">
                <input type="text" class="form-control" name="numero" pattern="[0-9]{2,8}" data-validation-pattern-message="Introduzca un valor válido" maxlength="8" required>
              </div>
            </div>
          </div>

          <table class="table table-bordered table-responsive">
            <thead>
              <th style="width: 50px;">C&oacute;digo</th>
        			<th>Producto</th>
        			<th>Cantidad</th>
        			<th>Precio Unitario</th>
        			<th>Total</th>
            </thead>
            <?php foreach($_SESSION["reabastecerMP"] as $p):
        			$product = MateriaPrimaData::getById($p["idMateriaPrima"]);
        			$total += $p["precio"]*$p["cantidad"];
        		?>
        		<tr>
        			<td style="width: 50px; text-align: center;"><?php echo $product->id; ?></td>
        			<td><?php echo $product->nombre; ?></td>
        			<td><?php echo $p["cantidad"]; ?></td>
        		  <td>$<?php echo number_format($p["precio"], 2); ?></td>
        			<td>$<?php echo number_format($p["precio"]*$p["cantidad"], 2); ?></td>
        		</tr>
        		<?php endforeach; ?>
          </table>
          
          <h2>Total a pagar: <strong>$ <?php echo number_format($total,2,".",","); ?></strong></h2>
        <?php else: ?>
          <p class="alert alert-warning">No ha agregado productos.</p>
        <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <?php if ($found): ?>
            <a href="index.php?view=clearre" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
