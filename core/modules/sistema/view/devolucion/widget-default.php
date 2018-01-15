<?php
	$idSuc = $_SESSION["usr_suc"];
	$devs = DevolucionData::getAllBySuc($idSuc);
	$sells = FacturaData:: getSellsBySuc($idSuc);
	$sucursales = SucursalData::getAll();
	$user = UserData::getById(Session::getUID());
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
        
		<?php if(count($sucursales) > 1 && $user->id == 1): ?>

		<div class="container-fluid">
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
						url: "ajax/devolucion/sucursalDevs.php",
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
			<div class="clearfix"></div>
			<br>
		</div>
		<?php endif; ?>

		<div class="container-fluid">
			<?php
			if (isset($_COOKIE["errorDevolucion"]) && !empty($_COOKIE["errorDevolucion"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorDevolucion"]; ?></p>
				</div>
			<?php
				setcookie("errorDevolucion","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okDevolucion"]) && !empty($_COOKIE["okDevolucion"])):
			?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okDevolucion"]; ?></p>
				</div>
			<?php
				setcookie("okDevolucion","",time()-18600);
			endif;
			?>
		</div>
        <div id="resultado">
		<?php if (count($devs) > 0): ?>
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
				$paginas = floor(count($devs)/$limit);
				$spaginas = count($devs)%$limit;
				if($spaginas>0){$paginas++;}
				$devs = DevolucionData::getByPage($idSuc,$start,$limit);
				$count = $start;
            ?>
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th></th>
								<th>No.</th>
								<th style="width: 140px;">No. Comprobante</th>
								<th>Motivo</th>
								<th>Fecha</th>
								<th>Reembolso</th>
								<th>Registrado Por</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($devs as $dev): ?>
								<tr>
									<td style="width: 40px;"><a class="btn btn-default btn-xs" href="index.php?view=detalledev&id=<?php echo $dev->id."&num=".$count; ?>"><i class="fa fa-eye"></i></a></td>
									<td><?php echo $count++; ?></td>
									<td><?php echo $dev->getFactura()->numerofactura; ?></td>
									<td><?php echo $dev->getCausa()->descripcion; ?></td>
									<td><?php echo $dev->fecha; ?></td>
									<td>$ <?php echo $dev->reembolso; ?></td>
									<td><?php echo $dev->getUser()->name." ".$dev->getUser()->lastname; ?></td>
									<td style="width:40px;">
										<a title="¿Eliminar?" href="index.php?view=deldev&id=<?php echo $dev->id;?>" class="btn btn-danger btn-xs"
										data-toggle="confirmation-popout" data-popout="true" data-placement="left"
										data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
										data-btn-ok-class="btn-success btn-xs"
										data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
										data-btn-cancel-class="btn-danger btn-xs"
										>
											<i class="fa fa-trash fa-fw"></i>
										</a>
									</td>
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
			<?php if (count($sells) <= 0): ?>
			<div class="alert alert-warning">
				Para registrar una devolución debe haber <a href="index.php?view=sells">ventas</a> registradas.
			</div>
			<?php endif; ?>
		<?php endif; ?>
		</div>
    </div>
</div>