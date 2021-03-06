<?php
	include 'modals/agregar.php';
	include 'modals/editar.php';
	$banco = BancoData::getAll();
?>
<script src="ajax/bancos/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Banco </a>
			<?php if(count($banco) > 0): ?>
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="report/banco.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		<h1>Bancos Registrados</h1>
		<div class="container-fluid">
			<?php if (isset($_COOKIE["errorBanco"]) && !empty($_COOKIE["errorBanco"])): ?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorBanco"]; ?></p>
				</div>
			<?php setcookie("errorBanco","",time()-18600); endif; ?>
			<?php if (isset($_COOKIE["okBanco"]) && !empty($_COOKIE["okBanco"])): ?>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okBanco"]; ?></p>
				</div>
			<?php setcookie("okBanco","",time()-18600); endif;?>
		</div>
		<?php
		if(count($banco)>0):
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
			$paginas = floor(count($banco)/$limit);
			$spaginas = count($banco)%$limit;
			if($spaginas>0){$paginas++;}
			$banco = BancoData::getByPage($start,$limit);
			$num = $start;
		?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nombre</th>
							<th>Direcci&oacute;n</th>
							<th>Tel&eacute;fono</th>
							<th>Número de cuenta</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($banco  as $bac): ?>
						<tr>
							<td style="width: 60px;"><?php echo $num++; ?></td>
							<td><?php echo $bac->nombre; ?></td>
							<td><?php echo $bac->direccion; ?></td>
							<td><?php echo $bac->telefono; ?></td>
							<td><?php echo $bac->numCuenta; ?></td>
							<td style="width: 80px;">
								
								<a title="Editar" id="<?php echo $bac->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit"><i class="fa fa-edit fa-fw"></i></a>
								<a title="¿Eliminar?" href="index.php?view=delbanco&id=<?php echo $bac->id;?>" class="btn btn-danger btn-xs"
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
						<li class="previous"><a href="index.php?view=banco<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=banco&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
							</li>
							<?php endfor; ?>
						<?php if($start != $anterior): ?>
						<?php 
							$next = "#";
							if($start != $anterior){
								$next = "&start=".($start + $limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=banco<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		<?php else: ?>
			<p class='alert alert-warning'>No hay bancos registrados</p>
		<?php endif; ?>
	</div>
</div>