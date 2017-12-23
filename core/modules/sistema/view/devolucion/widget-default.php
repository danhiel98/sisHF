<?php
	$devs = DevolucionData::getAll();
	$sells = FacturaData::getFacturas();
    include 'modals/add.php';
?>
<div class="row">
    <div class="col-md-12">
        <div class="btn-group pull-right">
			<?php if (count($sells)>0): ?>
            <a class="btn btn-default" data-toggle="modal" data-target="#add"><i class="fa fa-reply"></i> Registrar Devolución</a>
			<?php endif; ?>
        </div>
        <h1>Devoluciones</h1>
        
        <?php if (count($devs) > 0): ?>
            <?php
                $start = 1; $limit = 5;
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
				$paginas = floor(count($devs)/$limit);
				$spaginas = count($devs)%$limit;
				if($spaginas>0){$paginas++;}
				$devs = DevolucionData::getByPage($start,$limit);
            ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <th></th>
                        <th>No.</th>
                        <th style="width: 140px;">No. Comprobante</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Reembolso</th>
                        <th>Registrado Por</th>
                    </thead>
                    <tbody>
                        <?php foreach ($devs as $dev): ?>
                            <tr>
                                <td style="width: 40px;"><a class="btn btn-default btn-xs" href="index.php?view=detalledev&id=<?php echo $dev->id; ?>"><i class="fa fa-eye"></i></a></td>
                                <td><?php echo $dev->id; ?></td>
                                <td><?php echo $dev->getFactura()->numerofactura; ?></td>
                                <td><?php echo $dev->getCausa()->descripcion; ?></td>
                                <td><?php echo $dev->fecha; ?></td>
                                <td>$ <?php echo $dev->reembolso; ?></td>
                                <td><?php echo $dev->getUser()->name." ".$dev->getUser()->lastname; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
						<li class="previous"><a href="index.php?view=devolucion<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=devolucion&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=devolucion<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
        <?php else: ?>
            <div class="alert alert-warning">
                No hay devoluciones.
            </div>
        <?php endif; ?>

    </div>
</div>