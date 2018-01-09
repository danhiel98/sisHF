<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ServiceData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
	include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	
	
	$idSuc = $_SESSION["usr_suc"];
	
	$fact = FacturaData::getSellsBySuc($idSuc);
    $prods = ProductoSucursalData::getAllForSell($idSuc);
    $clients = ClientData::getAll();
	$servs = ServiceData::getAll();

	$ventas = false;
    $clientes = false;
	$products = false;
	$services = false;

    $prodsMsg = "<a href='index.php?view=inventaryprod'>productos</a> o <a href='index.php?view=services'>servicios</a> disponibles";
    $clientsMsg = "<a href='index.php?view=clients'>clientes</a> registrados";

	if (count($fact)>0){$ventas = true;}

    if (count($clients)>0){$clientes = true;}

	if (count($prods)>0){$products = true;}
	
	if (count($servs)>0){$services = true;}
  
?>
  <?php if ($ventas): ?>
	
	<?php

		$start = 1; $limit = 10;
		if(isset($_REQUEST["start"]) && isset($_REQUEST["limit"])){
			$start = $_REQUEST["start"];
			$limit = $_REQUEST["limit"];
			#Para evitar que se muestre un error, se valida que los valores enviados no sean negativos
			if ($start <= 0 ){
				$start = 1;
			}
			if ($limit <= 0 ){
				$limit = 1;
			}
		}
		$paginas = floor(count($fact)/$limit);
		$spaginas = count($fact)%$limit;
		if($spaginas>0){$paginas++;}
		$fact = FacturaData::getSellsBySucPage($idSuc,$start,$limit);
		$count = $start;
	?>

    <div class="tab-content">
      <div id="process" class="tab-pane fade in active">
        <div class="clearfix"></div>

        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th></th>
			  <th>No.</th>
              <th>No. Comprobante</th>
              <th>Tipo De Comprobante</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Fecha</th>
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
									<td><?php echo $count++; ?></td>
                  <td><?php echo $fa->numerofactura; ?></td>
                  <td><?php echo $fa->getComprobante()->nombre; ?></td>
                  <td><?php echo $fa->getClient()->fullname; ?></td>
                  <td><?php echo $fa->getUser()->name." ".$fa->getUser()->lastname; ?></td>
                  <td><?php echo $fa->fecha; ?></td>
                  <td>
                    <?php
                      $total=0;
                      foreach($prodsx as $p){
                        $total += $p->total;
                      }
                      foreach ($servsx as $s) {
                        $total += $s->total;
                      }
                      echo "<b>$ ".number_format($total,2,'.',',')."</b>";
                    ?>
                  </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
		<div class="pull-right">
			<ul class="pagination">
				<?php if($start != 1):?>
				<?php
					$prev = "#";
					if($start != 1){
						$prev = "?start=".($start-$limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/busquedafecha/todo.php<?php echo $prev; ?>">&laquo;</a></li>
				<?php endif; ?>
				<?php 
					$anterior = 1;
					for($i=1; $i<=$paginas; $i++):
						$inicio = 1;
						if ($i != 1){
							$inicio = $limit + $anterior;
							$anterior = $inicio;
						}
					?>
					<li <?php if($start == $inicio){echo "class='active'";} ?>>
						<a class="pag" href="ajax/busquedafecha/todo.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
					</li>
					<?php
					endfor;
				?>
				<?php if($start != $anterior): ?>
				<?php 
					$next = "#";
					if($start != $anterior){
						$next = "?start=".($start + $limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/busquedafecha/todo.php<?php echo $next; ?>">&raquo;</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<script>
			$(".pag").on("click", function(){
				$.ajax({
					url: $(this).attr("href"),
					type: "GET",
					data: {sucursal: <?php echo $idSuc; ?>},
					success: function(res){
						$("#agrega-registros").html(res);
					}
				});
				return false;
			});
		</script>
        <?php else: ?>
          <div class="clearfix"></div>
                
				<div class="alert alert-warning">
                    ¡Vaya! Aún no se han registrado ventas.
                </div>
                
                <?php if ((!$services && !$products) || !$clientes): ?>
                <div class="alert alert-warning">
                    <p>Para poder realizar ventas debe haber <?php if(!$products && !$services){echo $prodsMsg;} if(!$products && !$clientes){echo " y ";} if(!$clientes){echo $clientsMsg;} ?> en el sistema.</p>
                </div>
                <?php endif; ?>

        <?php endif; ?>
      </div>
	