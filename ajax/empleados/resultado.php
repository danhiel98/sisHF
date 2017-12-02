<?php
	@session_start();
	include ("../../core/autoload.php");
	#include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/EmpleadoData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");

	$emps = EmpleadoData::getAll();
	$sucursal = $_POST["sucursal"];
	
	if (count($emps) > 0):
		
		if($sucursal != "" && $sucursal != null):

			$empleados = array();
			
			foreach($emps as $e){
				if ($e->getSucursal()->id == $sucursal){
					array_push($empleados,$e);
				}
			}
			
			if (count($empleados)>0):
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
						<th></th>
					</thead>
				<?php foreach($empleados as $emp): ?>
					<?php if ($emp->getSucursal()->id == $_POST["sucursal"]): ?>
					<tr>
						<td><?php echo $emp->dui; ?></td>
						<td><?php echo $emp->nit; ?></td>
						<td><?php echo $emp->apellido; ?></td>
						<td><?php echo $emp->nombre; ?></td>
						<td><?php echo $emp->sexo; ?></td>
						<td><?php echo $emp->telefono; ?></td>
						<td><?php echo $emp->area; ?></td>
						<td style="width:40px;">
							<a href="index.php?view=editemploy&id=<?php echo $emp->id;?>" class="btn btn-warning btn-xs">Editar</a>
						</td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
				</table>
			</div>
			<?php else: ?>
				<div class="alert alert-warning">
					Vaya! No hay datos en la sucursal selecionada.
				</div>
	<?php
			endif;
		else:
			?>
			<div class="alert alert-info">
				Seleccione una ubicación.
			</div>
			<?php
		endif;
	endif;
?>
