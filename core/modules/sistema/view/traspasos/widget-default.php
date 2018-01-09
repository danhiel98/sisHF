<?php
	$idSuc = $_SESSION["usr_suc"];
	$sucs = false;
	$sucursales = SucursalData::getAll();
	$prodSuc = ProductoSucursalData::getAllForSell($idSuc);
	if (count($sucursales)>1) {
		$sucs = true;
	}
	$traspasos = TraspasoData::getAllBySuc($idSuc);
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<?php if ($sucs && count($prodSuc)>0): ?>
			<a href="index.php?view=newtraspaso" class="btn btn-default"><i class="fa fa-exchange"></i> Registrar Traspaso</a>
			<?php endif; ?>
			<?php if (count($traspasos)>0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/traspasos.php">Excel (.xlsx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Traspasos Realizados</h1>
		<?php
			if(count($traspasos)>0){
		?>
		<div class="clearfix"></div>
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
			$paginas = floor(count($traspasos)/$limit);
			$spaginas = count($traspasos)%$limit;
			if($spaginas>0){$paginas++;}
			$traspasos = TraspasoData::getAllBySucPage($idSuc,$start,$limit);
		?>
			<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<th></th>
					<th>No.</th>
					<th>Origen</th>
					<th>Destino</th>
					<th>Fecha</th>
					<th>Registrado Por</th>
				</thead>
				<?php foreach($traspasos as $trasp):?>
					<tr>
						<td style="width:30px;">
							<a href="index.php?view=tradex&id=<?php echo $trasp->id; ?>" title="Detalles de traspaso" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
						</td>
						<td><?php echo $trasp->id; ?></td>
						<td>
							<?php echo $trasp->getSucursalO()->nombre; ?>
						</td>
						<td>
							<?php echo $trasp->getSucursalD()->nombre; ?>
						</td>
						<td><?php echo $trasp->fecha; ?></td>
						<td><?php echo $trasp->getUser()->name." ".$trasp->getUser()->lastname; ?></td>
					</tr>
				<?php endforeach;?>
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
						<li class="previous"><a href="index.php?view=traspasos<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=traspasos&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=traspasos<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
			<?php
			}else{
			?>
			<div class="jumbotron">
				<div class="container">
					<?php if ($sucs): ?>
						<h2>No se han registrado traspasos</h2>
						<?php if(count($prodSuc) > 0): ?>
						Puede registrar uno dando click en el boton <b>"Registrar Traspaso"</b>
						<?php else: ?>
						No hay productos disponobles para realizar el traspaso.
						<?php endif; ?>
					<?php else: ?>
						<h2>No se puede registrar traspasos</h2>
						Para ello debe haber m&aacute;s de una sucursal registrada.
						<a href="index.php?view=sucursal">Ir a sucursales</a>
					<?php endif; ?>
				</div>
			</div>
		<?php
		}
		?>
		<br><br><br><br><br><br><br><br>
	</div>
</div>
