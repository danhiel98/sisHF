<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProduccionData.php");

  $prodxs = false;
  $prodxsA = false;
  $prodxsT = false;
  $prodxsC = false;
  $productns = ProduccionData::getAll();
  if (count($productns)>0) {
    $prodxs = true;
  }
  $productnsT = ProduccionData::getFinished();
  if (count($productnsT)>0) {
    $prodxsT = true;
  }
  $productnsA = ProduccionData::getActive();
  if (count($productnsA)>0) {
    $prodxsA = true;
  }
  $productnsC = ProduccionData::getCancel();
  if (count($productnsC)>0) {
    $prodxsC = true;
  }
  $matp = MateriaPrimaData::getAll();
	$prods = ProductData::getAll();
?>
	<script src="js/bootstrap-confirmation.js"></script>
  <?php if (count($matp)>0 && count($prods)>0): ?>
		<script type="text/javascript">
			var btn = '<div class="btn-group pull-right"><a href="index.php?view=newproducn" class="btn btn-default"><i class="icon-plus"></i> Agregar a producción</a></div>';
			$(function(){
				$("#btnAdd").html(btn);
			});
		</script>
  <?php endif; ?>
  <?php if ($prodxs): ?>
  	<ul class="nav nav-tabs">
      <li class="active"><a href="#process">En proceso</a></li>
      <li><a href="#end">Terminado</a></li>
    </ul>
    <div class="tab-content">
      <div id="process" class="tab-pane fade in active">
        <h2>Producciones en proceso</h2>
        <?php if ($prodxsA): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th></th>
              <th>No.</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th style="width: 50px;"></th>
            </thead>
            <tbody>
              <?php foreach ($productnsA as $pa): ?>
                <tr>
                  <td style="width:40px;"><a href="index.php?view=oneprod&id=<?php echo $pa->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" title="Detalles"></i></a></td>
                  <td><?php echo $pa->id; ?></td>
                  <td><?php echo $pa->getProduct()->nombre; ?></td>
                  <td><?php echo $pa->cantidad; ?></td>
                  <td><?php echo $pa->fechainicio; ?></td>
                  <td><?php echo $pa->fechafin; ?></td>
                  <td>
										<a title="Finalizar" href="#" class="btn btn-sm btn-success finalizar" id="<?php echo $pa->id; ?>"
											data-toggle="confirmation-popout" data-popout="true" data-placement="left"
											data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
											data-btn-ok-class="btn-success btn-xs"
											data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
											data-btn-cancel-class="btn-danger btn-xs"
											data-title="¿Finalizar?">
											<i class="fa fa-check"></i>
										</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
          Vaya! No hay producciones en proceso.
        </div>
        <?php endif; ?>
      </div>
      <div id="end" class="tab-pane fade">
        <h2>Producciones finalizadas</h2>
        <?php if ($prodxsT): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th></th>
              <th>No.</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th>Finalizado</th>
            </thead>
            <tbody>
              <?php foreach ($productnsT as $pt): ?>
                <tr>
                  <td style="width:40px;"><a href="index.php?view=oneprod&id=<?php echo $pt->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" title="Detalles"></i></a></td>
                  <td><?php echo $pt->id; ?></td>
                  <td><?php echo $pt->getProduct()->nombre; ?></td>
                  <td><?php echo $pt->cantidad; ?></td>
                  <td><?php echo $pt->fechainicio; ?></td>
                  <td><?php echo $pt->fechafin; ?></td>
                  <td><?php echo $pt->fechafinalizado; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
          No hay producciones terminadas.
        </div>
        <?php endif; ?>
      </div>
      <div id="cancel" class="tab-pane fade">
        <h2>Producciones canceladas</h2>
        <?php if ($prodxsC): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th></th>
              <th>No.</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Fecha Inicio</th>
              <th>Fecha Fin</th>
              <th>Cancelado</th>
            </thead>
            <tbody>
              <?php foreach ($productnsC as $pc): ?>
                <tr>
                  <td style="width:40px;"><a href="index.php?view=oneprod&id=<?php echo $pc->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" title="Detalles"></i></a></td>
                  <td><?php echo $pc->id; ?></td>
                  <td><?php echo $pc->getProduct()->nombre; ?></td>
                  <td><?php echo $pc->cantidad; ?></td>
                  <td><?php echo $pc->fechainicio; ?></td>
                  <td><?php echo $pc->fechafin; ?></td>
                  <td><?php echo $pc->fechafinalizado; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
          No hay producciones canceladas.
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php else: ?>
      <div class="alert alert-info" style="font-size: 1.2em;">
        No hay datos
      </div>
      <?php if (count($matp) <= 0 && count($prods) <= 0): ?>
        <div class="alert alert-warning">
          Para registrar una producci&oacute;n debe haber productos y materia prima en el sistema.
        </div>
			<?php elseif(count($matp) <= 0): ?>
				<div class="alert alert-warning">
          Para registrar una producci&oacute;n debe haber materia prima. <a href="index.php?view=inventarymp">Ir a materia prima.</a>
        </div>
			<?php elseif(count($prods) <= 0): ?>
				<div class="alert alert-warning">
          Para registrar una producci&oacute;n debe haber productos en el sistema. <a href="index.php?view=products">Ir a productos.</a>
        </div>
      <?php endif; ?>
    <?php endif; ?>
	<script>

		$(document).ready(function(){
	    $(".nav-tabs a").click(function(){
	      $(this).tab('show');
	    });
	  });

		$('[data-toggle=confirmation]').confirmation({
			rootSelector: '[data-toggle=confirmation]',
			container: 'body'});
		$('[data-toggle=confirmation-singleton]').confirmation({
			rootSelector: '[data-toggle=confirmation-singleton]',
			container: 'body'});
		$('[data-toggle=confirmation-popout]').confirmation({
			rootSelector: '[data-toggle=confirmation-popout]',
			container: 'body'});
		$('#confirmation-delegate').confirmation({
			selector: 'button'
		});

		function finalizar(id){
			$.ajax({
				url: "ajax/produccion/procesos.php",
				type: "POST",
				dataType: "html",
				data: {
					idFin: id
				}
			}).done(function(){
				producciones("end");
			});
		}

		function cancelar(id){
			$.ajax({
				url: "ajax/produccion/procesos.php",
				type: "POST",
				dataType: "html",
				data: {
					idCancel: id
				}
			}).done(function(){
				producciones("cancel");
			});
		}

		$(".finalizar").on("confirmed.bs.confirmation",function(){
			var id = this.id;
			finalizar(id);
		});
		$(".cancelar").on("confirmed.bs.confirmation",function(){
			var id = this.id;
			cancelar(id);
		});

	</script>
