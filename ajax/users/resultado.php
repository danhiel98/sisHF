<?php
	session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/EmpleadoData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");

	if (isset($_POST["sucursal"]) && !empty($_POST["sucursal"])):
		$users = UserData::getAll();
		if (count($users) > 0):
			$usuarios = array();
			foreach($users as $user){
				if ($user->getEmpleado()->getSucursal()->id == $_POST["sucursal"]){
					array_push($usuarios,$user);
				}
			}
			if (count($usuarios)>0):
		?>
			<table class="table table-bordered table-hover">
					<thead>
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>Usuario</th>
						<th>Correo Electr&oacute;nico</th>
						<th>Sucursal</th>
						<th style="text-align:center;">Estado</th>
						<th style="text-align:center;">Tipo</th>
					</thead>
					<?php foreach($usuarios as $user): ?>
						<?php if((isset($_SESSION["usr_suc"]) && ($user->getEmpleado()->getSucursal()->id == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])): ?>
						<tr>
							<td><?php echo $user->getEmpleado()->nombre; ?></td>
							<td><?php echo $user->getEmpleado()->apellido; ?></td>
							<td><?php echo $user->username; ?></td>
							<td><?php echo $user->email; ?></td>
							<td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
							<td class="estado" style="text-align:center;">
								<a href="#" id="estado" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->activo; ?>" data-source="ajax/users/estados.php" title="Estado"></a>
							</td>
							<td class="tipo" style="text-align:center;">
								<a href="#" id="tipo" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->tipo; ?>" data-source="ajax/users/tipos.php" title="Tipo"></a>
							</td>
						</tr>
					<?php
						endif;
					endforeach;
					?>
				</table>
			<?php
			else:
		?>
				<div class="alert alert-info">
					<strong>Vaya! </strong> No hay usuarios registrados en la sucursal seleccionada.
				</div>
		<?php
			endif;
		endif;
	else:
?>
		<div class="alert alert-info">
			Seleccione una sucursal.
		</div>
<?php
	endif;
?>

<script>
	//Obtener los script necesarios para que funcione x-editable
	$.when(
		//Se supone que era para cargar varios scripts, pero al final solamente se necesita uno
		$.getScript( "res/x-editable/bootstrap3-editable/js/bootstrap-editable.js" ),
		$.Deferred(function( deferred ){    // esperar a que el DOM esté listo
			$( deferred.resolve );
		})
	).done(function(){
		console.log("Script cargados correctamente!");
	}).fail(function(){
		console.log("Algo salió mal");
	});

	$(function(){
		$('.estado a').editable({
			showbuttons: false,
			url: 'ajax/users/procesos.php' 
		});

		$('.tipo a').editable({
			showbuttons: false,
			url: 'ajax/users/procesos.php'
		});
	});
</script>