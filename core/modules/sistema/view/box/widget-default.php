<?php
	$idSuc = $_SESSION["usr_suc"];

    $user = UserData::getById(Session::getUID());
    $sucursales = SucursalData::getAll();
	$boxes = BoxData::getAllBySuc($idSuc);
	$caja = FacturaData::getSellsUnBoxedBySuc($idSuc);
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<?php if (count($boxes)>0): ?>
				<a href="index.php?view=boxhistory" class="btn btn-default "><i class="fa fa-clock-o"></i> Historial</a>
			<?php endif; ?>
			<?php if (count($caja)>0): ?>
				<a href="index.php?view=processbox" class="btn btn-primary">Procesar Datos <i class="fa fa-arrow-right"></i></a>
			<?php endif; ?>
		</div>
		<h1><i class='fa fa-archive'></i> Caja</h1>

		<?php if(count($sucursales) > 1 && $user->id == 1): ?>

        <div class="form-horizontal">
            <label for="sucursal" class="col-md-2 col-sm-2 col-xs-2 control-label">Sucursal</label>
            <div class="col-md-4 col-sm-6 col-xs-8">
                <select name="sucursal" id="sucursal" class="form-control">
                    <?php foreach($sucursales as $suc): ?>
                        <option <?php if($suc->id == $idSuc){echo 'selected';} ?> value="<?php echo $suc->id; ?>"><?php echo $suc->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <script>
            $("#sucursal").on("change", function(){
                $.ajax({
                    url: "ajax/box/sucursalBox.php",
                    type: "POST",
                    data: {
                        id: $(this).val()
                    },
                    dataType: "html",
                    success: function(res){
                        $("#resultado").html(res);
                    }
                });
            });
        </script>
        
        <?php endif; ?>

		<div class="clearfix"></div>
		<br>
		<div id="resultado">
			<?php
				if(count($caja)>0):
					$total_total = 0;

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
					$paginas = floor(count($caja)/$limit);
					$spaginas = count($caja)%$limit;
					if($spaginas>0){$paginas++;}
					$caja = FacturaData::getSellsUnBoxedBySucPage($idSuc,$start,$limit);
					$count = $start;
			?>
			<br>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th></th>
						<th>No.</th>
						<th>Cliente</th>
						<th>Fecha</th>
						<th>Tipo Comprobante</th>
						<th>Total</th>
					</thead>
					<?php foreach($caja as $sell):?>
					<tr>
						<td style="width:30px;">
							<a href="index.php?view=onesell&id=<?php echo $sell->id; ?>&b" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
						</td>
						<?php
							$prodsx = FacturaData::getAllSellsByFactId($sell->id); #Productos vendidos en la factura
							$servsx = FacturaData::getAllServicesByFactId($sell->id); #Servicios vendidos en la factura
						?>
						<td>
							<?php echo $count++; ?>
						</td>
						<td>
							<?php if($sell->idcliente != ""){echo $sell->getClient()->fullname;}else{echo "----";} ?>
						</td>
						<td><?php echo $sell->fecha; ?></td>
						<td><?php echo $sell->getComprobante()->nombre; ?></td>
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
								$total_total += $total;
								echo "<b>$ ".number_format($total,2,'.',',')."</b>";
							?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<h1>Total: <?php echo "$ ".number_format($total_total,2,".",","); ?></h1>
			<div class="container-fluid">
				<div class="pull-right">
					<ul class="pagination">
						<?php if($start != 1):?>
						<?php
							$prev = "#";
							if($start != 1){
								$prev = "&start=".($start-$limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=box<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=box&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
							</li>
							<?php
							endfor;
						?>
						<?php if($start != $anterior): ?>
						<?php 
							$next = "#";
							if($start != $anterior){
								$next = "&start=".($start + $limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=box<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<?php
				else:
			?>
				<div class="alert alert-warning">
					¡Vaya! No hay ventas para procesar.
				</div>
			<?php
				endif;
			?>
		</div>
		<br><br><br>
	</div>
</div>
