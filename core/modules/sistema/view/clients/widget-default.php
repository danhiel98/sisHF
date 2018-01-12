<?php $clientes = ClientData::getAll(); ?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a href="index.php?view=newclient" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Cliente</a>
			<?php if(count($clientes) > 0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/clientes.php">Excel(.xlsx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Directorio de Clientes</h1>
		<?php
		if(count($clientes)>0):
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
			$paginas = floor(count($clientes)/$limit);
			$spaginas = count($clientes)%$limit;
			if($spaginas>0){$paginas++;}
			$clientes = ClientData::getByPage($start,$limit);
		?>
	
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<th>No.</th>
					<th>DUI</th>
					<th>NIT</th>
					<th>NRC</th>
					<th>Nombre</th>
					<th>Correo Electr&oacute;nico</th>
					<th>Tel&eacute;fono</th>
					<th></th>
				</thead>
				<?php
				foreach($clientes as $user){
					?>
				<tr>
					<td><?php echo $user->id; ?></td>
					<td><?php echo $user->dui; ?></td>
					<td><?php echo $user->nit; ?></td>
					<td><?php echo $user->nrc;?></td>
					<td><?php echo $user->name; ?></td>
					<td><?php echo $user->email; ?></td>
					<?php
						if ($user->birth != "") {
							$fecha = array_reverse(preg_split("[-]",$user->birth));
							$user->birth = $fecha[0]."/".$fecha[1]."/".$fecha[2];
						}
					?>
					<td><?php echo $user->phone; ?></td>
					<td style="width:40px;">
						<a href="index.php?view=editclient&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
					</td>
				</tr>
				<?php
				}
				?>
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
					<li class="previous"><a href="index.php?view=clients<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=clients&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
					<li class="previous"><a href="index.php?view=clients<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php
		else:
		?>
			<p class='alert alert-info'>No hay clientes registrados</p>
		<?php
		endif;
		?>
	</div>
</div>
