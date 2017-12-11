<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
  include ("../../core/modules/sistema/model/ProductData.php");
  include ("../../core/modules/sistema/model/ServiceData.php");
  include ("../../core/modules/sistema/model/FacturaData.php");
  include ("../../core/modules/sistema/model/ComprobanteData.php");


  $desde = $_POST['fecInicio'];
  $hasta = $_POST['fecFin'];
      if ($desde == "") {
       echo "<h5 style= 'color:red; font-size:15px;'>Debe Rellenar El Campo De Fecha Inicio</h5>";
      }else{
        $fechaInicio = array_reverse(preg_split("[/]",$desde));
        $desde = $fechaInicio[0]."-".$fechaInicio[1]."-".$fechaInicio[2];
      }

      if ($hasta == "") {
        echo "<h5 style= 'color:red; font-size:15px;'>Debe Rellenar El Campo De Fecha Fin</h5>";
      }else{
        $fechaFin = array_reverse(preg_split("[/]",$hasta));
        $hasta = $fechaFin[0]."-".$fechaFin[1]."-".$fechaFin[2];
      }
  

  
  $fact = FacturaData::getBetweenDates($desde,$hasta);
 
?>
  <?php if (count($fact)>0): ?>
		<script type="text/javascript">
			var btn = '<div class="btn-group pull-right"><a href="index.php?view=sell" class="btn btn-default"><i class="icon-plus"></i> Vender</a></div>';
		</script>
  <?php endif; ?>
  <?php if ($fact): ?>
    <div class="tab-content">
      <div id="process" class="tab-pane fade in active">
        <div class="clearfix"></div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th></th>
              <th>No.</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Fecha</th>
              <th>Tipo De Documento</th>
              <th>Total</th>
            </thead>
            <tbody>
              <?php foreach ($fact as $fa): ?>
                <?php
                  $prodsx = FacturaData::getAllSellsByFactId($fa->id); #Productos vendidos en la factura
                  $servsx = FacturaData::getAllServicesByFactId($fa->id); #Servicios vendidos en la factura
                ?>
                <tr>
                  <td style="width:40px;"><a href="index.php?view=onesell&id=<?php echo $fa->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                  <td><?php echo $fa->numerofactura; ?></td>
                  <td><?php echo $fa->getClient()->name." ".$fa->getClient()->lastname; ?></td>
                  <td><?php echo $fa->getUser()->name." ".$fa->getUser()->lastname; ?></td>
                  <td><?php echo $fa->fecha; ?></td>
                  <td><?php echo $fa->getComprobante()->nombre; ?></td>
                  <td>
                    <?php
                      $total=0;
                      foreach($prodsx as $p){
                        $prd = $p->getProduct();
                        $total += $p->cantidad * $prd->precioventa;
                      }
                      foreach ($servsx as $s) {
                        $srv = $s->getService();
                        $total += $s->cantidad * $srv->precio;
                      }
                      echo "<b>$ ".number_format($total,2,'.',',')."</b>";
                    ?>
                  </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
          <div class="clearfix"></div>
        <div class="alert alert-info">
          Vaya! No no se encontro ningun registro entre esas fechas.
        </div>
        <?php endif; ?>
      </div>
	