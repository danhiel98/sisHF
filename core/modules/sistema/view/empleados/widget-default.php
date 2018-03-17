<?php
	$idSuc = $_SESSION["usr_suc"];
	$sucursales = SucursalData::getAll();
	$empleados = EmpleadoData::getAll();
	$admin = true;
	if (!isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllBySucId($idSuc);
		$admin = false;
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a href="index.php?view=newemploy" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Empleado</a>
			<?php if(count($empleados) > 0 ): ?>
				<div class="btn-group pull-right">
					<a class="btn btn-default" target="_blank" href="report/empleadosAll.php"><i class="fa fa-download"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		<h1>Lista De Empleados</h1>
		
		<?php if(count($empleados)>0): ?>
			<ul class="nav nav-tabs">
				<li class="active"><a href="#all">Todos</a></li>
				<?php if (count($sucursales)>1 && $admin): ?>
				<li><a href="#suc">Por Sucursal</a></li>
				<?php endif; ?>
			</ul>
			<br>
			<div class="tab-content">
				<div id="all" class="tab-pane fade in active">
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
					$idSuc = $_SESSION["usr_suc"];
					$paginas = floor(count($empleados)/$limit);
					$spaginas = count($empleados)%$limit;
					if($spaginas>0){$paginas++;}
					if ($admin){
						$empleados = EmpleadoData::getAllByPage($start,$limit);
					}else{
						$empleados = EmpleadoData::getAllBySucPage($idSuc,$start,$limit);
					}
					$num = $start;
				?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>DUI</th>
								<th>NIT</th>
								<th>Apellidos</th>
								<th>Nombres</th>
								<!-- <th>Sexo</th> -->
								<th>Tel&eacute;fono</th>
								<th>&Aacute;rea</th>
								<?php if ($idSuc == 1): ?>
								<th>Sucursal</th>
								<?php endif; ?>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($empleados as $empleado): ?>
								<tr>
									<td style="width: 30px;"><?php echo $num++; ?></td>
									<td><?php echo $empleado->dui; ?></td>
									<td><?php echo $empleado->nit; ?></td>
									<td><?php echo $empleado->apellido; ?></td>
									<td><?php echo $empleado->nombre; ?></td>
									<!-- <td><?php #echo $empleado->sexo; ?></td> -->
									<td><?php echo $empleado->telefono; ?></td>
									<td><?php echo $empleado->area; ?></td>
									<?php if ($idSuc == 1): ?>
									<td><?php echo $empleado->getSucursal()->nombre; ?></td>
									<?php endif; ?>
									<td style="width:40px;">
										<a href="index.php?view=editemploy&id=<?php echo $empleado->id;?>" class="btn btn-warning btn-xs">Editar</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
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

			<?php if (count($sucursales) > 1): ?>
			
			<script type="text/javascript" src="ajax/empleados/ajax.js"></script>
			
			<div id="suc" class="tab-pane fade">
				<div class="form-group form-horizontal">
					<label for="sucursal" class="col-md-1 control-label">Sucursal</label>
					<div class="col-md-6">
						<select class="form-control" name="sucursal" id="sucursal">
							<option value="">--SELECCIONE--</option>
							<?php foreach ($sucursales as $s): ?>
								<option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="btn-group pull-right">
					<div>
						<a class="btn btn-default" id="reporteEPS" target="_blank"><i class="fa fa-download"></i> Descargar</a>
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
			<p class='alert alert-warning'>No hay empleados registrados</p>
		<?php endif; ?>
	</div>
</div>
<script>
	// $(document).ready(function(){
	//     $(".nav-tabs a").click(function(){
	//         $(this).tab('show');
	//     });
	// });
	// $(function(){
	// 	$("#sucursal").on("change",function(){
	// 		var valor = $(this).val();
	// 		if (valor >= 1){
				
	// 		}else{
	// 			$("#reporteEPS").removeAttr("href");
	// 		}
	// 	});
	// });
</script>
