<?php
	$bancos = BancoData::getAll();
	if (count($bancos) > 0) {
		include 'modals/agregar.php';
		include 'modals/editar.php';
		$envio = EnvioData::getAll();
		$bnc = true;
	}else{
		$bnc = false;
	}
?>
<script src="ajax/envios/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<?php if ($bnc): ?>
			<div class="btn-group pull-right">
				<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-send'></i> Registrar Env&iacute;o</a>
				<?php if(count($envio) > 0): ?>
					<div class="btn-group pull-right">
		  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  			</button>
		  			<ul class="dropdown-menu" role="menu">
		    			<li><a href="report/envios.php">Excel (.xlsx)</a></li>
		  			</ul>
					</div>
				<?php endif; ?>
			</div>
		<h1>Env&iacute;os De Dinero Realizados</h1>
		<div class="container-fluid">
			<?php
			if (isset($_COOKIE["errorEnvio"]) && !empty($_COOKIE["errorEnvio"])):
			?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorEnvio"]; ?></p>
				</div>
			<?php
				setcookie("errorEnvio","",time()-18600);
			endif;
			?>
			<?php
			if (isset($_COOKIE["okEnvio"]) && !empty($_COOKIE["okEnvio"])):
			?>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okEnvio"]; ?></p>
				</div>
			<?php
				setcookie("okEnvio","",time()-18600);
			endif;
			?>
		</div>
		<?php
			if(count($envio)>0):
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
				$paginas = floor(count($envio)/$limit);
				$spaginas = count($envio)%$limit;
				if($spaginas>0){$paginas++;}
				$envio = EnvioData::getByPage($start,$limit);
		?>
			
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<th>No.</th>
						<th>Banco</th>
						<th>No. Cuenta</th>
						<th>Cantidad</th>
						<th>No. Comprobante</th>
						<th>Fecha</th>
						<th>Registrado por</th>
						<th></th>
					</thead>
					<tbody>
						<?php
						foreach($envio as $env):
						?>
							<tr>
								<td><?php echo $env->id; ?></td>
								<td><?php echo $env->getBanco()->nombre; ?></td>
								<td><?php echo $env->getBanco()->numCuenta; ?></td>
								<td>$ <?php echo number_format($env->cantidad,2,'.',','); ?></td>
								<td><?php echo $env->comprobante; ?></td>
								<td><?php echo $env->fecha; ?></td>
								<td><?php echo $env->getUsuario()->name." ".$env->getUsuario()->lastname; ?></td>
								<td style="width: 80px;">
									<a id="<?php echo $env->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit"><i class="fa fa-edit fa-fw"></i></a>
									<a title="¿Eliminar?" href="index.php?view=delenvio&id=<?php echo $env->id;?>" class="btn btn-danger btn-xs"
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
						<?php
						endforeach;
						?>
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
						<li class="previous"><a href="index.php?view=envios<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=envios&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=envios<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

		<?php
		else:
		?>
			<p class='alert alert-warning'>A&uacute;n no se ha realizado ning&uacute;n env&iacute;o</p>
		<?php
		endif;
		?>
		<?php else: ?>
			<h1>No se pueden realizar env&iacute;os</h1>
			<p class="alert alert-warning">Debe registrar un banco para poder realizar env&iacute;os! <a href="index.php?view=banco">Ir a bancos</a></p>
		<?php endif; ?>

	</div>
</div>
