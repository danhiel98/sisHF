<?php
	$sucursal = SucursalData::getAll();
	$empleados = EmpleadoData::getAll();
	if (isset($_SESSION["usr_suc"]) && !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllBySucId($_SESSION["usr_suc"]);
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a href="index.php?view=newemploy" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Empleado</a>
			<?php if(count($empleados) > 0 ): ?>
				<div class="btn-group pull-right">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				    <i class="fa fa-download"></i> Descargar Todos <span class="caret"></span>
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
			<?php if (count($sucursal)>1): ?>
				<li><a href="#suc">Por Sucursal</a></li>
			<?php endif; ?>
		</ul>
		<br>
		<div class="tab-content">
			<div id="all" class="tab-pane fade in active">
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
</script>
