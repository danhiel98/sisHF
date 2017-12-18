<?php
	$sucursal = SucursalData::getAll();
	$empleados = EmpleadoData::getAll();
	$usrSuc = false;
	if (isset($_SESSION["usr_suc"]) && !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllBySucId($_SESSION["usr_suc"]);
		$usrSuc = true;
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a href="index.php?view=newemploy" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Empleado</a>
			<?php if(count($empleados) > 0 ): ?>
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><a href="report/empleadosAll.php">Excel(.xlsx)</a></li>
				  </ul>
				</div>
			<?php endif; ?>
		</div>
	<h1>Lista De Empleados</h1>
	<br>
	<?php if(count($empleados)>0): ?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#all">Todos</a></li>
			<?php if (count($sucursal)>1 && !$usrSuc): ?>
				<li><a href="#suc">Por Sucursal</a></li>
			<?php endif; ?>
		</ul>
		<br>
		<div class="tab-content">
			<div id="all" class="tab-pane fade in active">
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
				$paginas = floor(count($empleados)/$limit);
				$spaginas = count($empleados)%$limit;
				if($spaginas>0){$paginas++;}
				$empleados = EmpleadoData::getAllByPage($start,$limit);
				?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<th>DUI</th>
							<th>NIT</th>
							<th>Apellidos</th>
							<th>Nombres</th>
							<th>Sexo</th>
							<th>Tel&eacute;fono</th>
							<th>&Aacute;rea</th>
							<th>Sucursal</th>
							<th></th>
						</thead>
						<?php
						foreach($empleados as $empleado):
							?>
							<tr>
								<td><?php echo $empleado->dui; ?></td>
								<td><?php echo $empleado->nit; ?></td>
								<td><?php echo $empleado->apellido; ?></td>
								<td><?php echo $empleado->nombre; ?></td>
								<td><?php echo $empleado->sexo; ?></td>
								<td><?php echo $empleado->telefono; ?></td>
								<td><?php echo $empleado->area; ?></td>
								<td><?php echo $empleado->getSucursal()->nombre; ?></td>
								<td style="width:40px;">
									<a href="index.php?view=editemploy&id=<?php echo $empleado->id;?>" class="btn btn-warning btn-xs">Editar</a>
									<!--<a onclick="return confirm('¿Seguro que desea eliminar el registro?');" href="index.php?view=delemploy&id=<?php echo $empleado->id;?>" class="btn btn-danger btn-xs">Eliminar</a>-->
								</td>
							</tr>
							<?php
						endforeach;
						?>
					</table>
				</div>
				<div class="pull-right">
					<ul class="pagination">
						<?php if($start != 1):?>
						<?php
							$prev = "#";
							if($start != 1){
								$prev = "&start=".($start-$limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=empleados<?php echo $prev; ?>">&laquo;</a></li>
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
								<a href="index.php?view=empleados&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
						<li class="previous"><a href="index.php?view=empleados<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>

			<?php if (count($sucursal)>1): ?>
			
			<script type="text/javascript" src="ajax/empleados/ajax.js"></script>
			
			<div id="suc" class="tab-pane fade">
				<div class="form-group form-horizontal">
					<label for="sucursal" class="col-md-1 control-label">Sucursal</label>
					<div class="col-md-6">
						<select class="form-control" name="sucursal" id="sucursal">
							<option value="">--SELECCIONE--</option>
							<?php foreach ($sucursal as $s): ?>
								<option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="btn-group pull-right">
					<div>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-download"></i> Descargar <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a id="reporteEPS" target="_blank">Excel (.xlsx)</a></li>
						</ul>
					</div>
				</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<section id="tabla_resultado"></section>
			</div>
			
			<?php endif; ?>
		</div>
		<?php else: ?>
			<p class='alert alert-danger'>No hay empleados registrados</p>
		<?php endif; ?>
	</div>
</div>
<script>
	$(document).ready(function(){
	    $(".nav-tabs a").click(function(){
	        $(this).tab('show');
	    });
	});
	$(function(){
		$("#sucursal").on("change",function(){
			var valor = $(this).val();
			if (valor >= 1){
				$("#reporteEPS").attr("href","report/empleados.php?idEmple="+valor);
			}else{
			}
		});
	});
</script>
