<?php 

	$idSuc = $_SESSION["usr_suc"];
	$user = UserData::getById(Session::getUID());	
    $sucursales = SucursalData::getAll();

	$count = 0;
	$boxes = BoxData::getAllBySuc($idSuc);

?>
<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="<?php if(isset($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];}else{echo "index.php?view=box";} ?>"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
		<div class="btn-group pull-right">
			<?php if(count($boxes)>0): ?>
			<a class="btn btn-default" href="report/boxhistory.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
			<?php endif; ?>
		</div>
		<h1><i class='fa fa-archive'></i> Cortes de Caja</h1>
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
                    url: "ajax/box/sucursalBoxHistory.php",
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
		<div id="resultado">
			<?php if(count($boxes)>0): ?>
			<?php
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
				$paginas = floor(count($boxes)/$limit);
				$spaginas = count($boxes)%$limit;
				if($spaginas>0){$paginas++;}
				$boxes = BoxData::getBySucPage($idSuc,$start,$limit);
			?>
			
			<br>
			<div class="table-responsive">
				<table class="table table-bordered table-hover	">
					<thead>
						<tr>
							<th></th>
							<th>No.</th>
							<th>Total</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($boxes as $box):
							$facts = FacturaData::getByBoxId($box->id);
							$count++;
						?>
						<tr>
							<td style="width:30px;">
								<a href="./index.php?view=b&id=<?php echo $box->id."&no=".$count; ?>" class="btn btn-default btn-xs"><i class="fa fa-arrow-right"></i></a>
							</td>
							<td style="width:50px;"><?php echo $count; ?></td>
							<td>
							<?php
								$total=0;
								foreach($facts as $fc){
									$prodsx = FacturaData::getAllSellsByFactId($fc->id); #Productos vendidos en la factura
									$servsx = FacturaData::getAllServicesByFactId($fc->id); #Servicios vendidos en la factura
									foreach ($prodsx as $p) {
										$precio = $p->total;
										$total += $precio;
									}
									foreach ($servsx as $s) {
										$precio = $s->total;
										$total += $precio;
									}
								}
								$total_total += $total;
								echo "<b>$ ".number_format($total,2,".",",")."</b>";
							?>
							</td>
							<td><?php echo $box->fecha; ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
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
						<li class="previous"><a href="index.php?view=boxhistory<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=boxhistory&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=boxhistory<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<?php else: ?>
			<div class="clearfix"></div>
			<br>
			<div class="alert alert-info">
				No hay datos.
			</div>
			<div class="alert alert-warning">
				No se ha realizado ning&uacute;n corte de caja.
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
