<?php
	$usr = UserData::getById(Session::getUID());

	//Si es vendedor se va a mstrar un mensaje de error
	if ($usr->tipo != 1 && $usr->tipo != 2 && $usr->tipo != 4){
		error();
	}

	$provs =  false;
	include("modals/agregar.php");
	$providers = ProviderData::getAll();
	if (count($providers) > 0) {
		$provs = true;
		include("modals/editar.php");
	}
	$providers = ProviderData::getAll();
?>
<script src="ajax/providers/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-truck'></i> Registrar Proveedor</a>
			<?php if($provs): ?>
				<div class="btn-group pull-right">
					<a class="btn btn-default" target="_blank" href="report/proveedores.php "><i class="fa fa-download"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		<h1>Directorio de Proveedores</h1>
		<?php
		if($provs):
			
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
			$paginas = floor(count($providers)/$limit);
			$spaginas = count($providers)%$limit;
			if($spaginas>0){$paginas++;}
			$providers = ProviderData::getByPage($start,$limit);
			$num = $start;
		?>
		
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nombre</th>
						<th>Provee</th>
						<th>Direcci&oacute;n</th>
						<th>Tel&eacute;fono</th>
						<th>Correo Electr&oacute;nico</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($providers as $prov): ?>
					<tr>
						<td style="width: 30px;"><?php echo $num++; ?></td>
						<td><?php echo $prov->nombre; ?></td>
						<td><?php echo $prov->tipoprovee; ?></td>
						<td><?php echo $prov->direccion; ?></td>
						<td style="width:90px;"><?php echo $prov->telefono; ?></td>
						<td><?php echo $prov->correo; ?></td>
						<td style="width:40px;">
							<a id="<?php echo $prov->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit"><i class="fa fa-edit"></i> </a>
						</td>
					</tr>
				</tbody>
				<?php endforeach; ?>
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
					<li class="previous"><a href="index.php?view=providers<?php echo $prev; ?>">&laquo;</a></li>
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
							<a href="index.php?view=providers&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
						</li>
						<?php endfor; ?>
					<?php if($start != $anterior): ?>
					<?php 
						$next = "#";
						if($start != $anterior){
							$next = "&start=".($start + $limit)."&limit=".$limit;
						}
					?>
					<li class="previous"><a href="index.php?view=providers<?php echo $next; ?>">&raquo;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<?php else: ?>
			<p class='alert alert-warning'>No hay proveedores registrados</p>
		<?php endif; ?>
	</div>
</div>
