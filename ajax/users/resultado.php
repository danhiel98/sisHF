<?php
	session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/EmpleadoData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");

	if (isset($_REQUEST["sucursal"]) && !empty($_REQUEST["sucursal"])):
		$id = $_REQUEST["sucursal"];
		$usuarios = UserData::getAllBySucId($id);
		if (count($usuarios)>0):
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
			$paginas = floor(count($usuarios)/$limit);
			$spaginas = count($usuarios)%$limit;
			if($spaginas>0){$paginas++;}
			$usuarios = UserData::getAllBySucPage($id,$start,$limit);
	?>
		<div class="table-responsive">
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
		</div>
		<div class="pull-right">
			<ul class="pagination">
				<?php if($start != 1):?>
				<?php
					$prev = "#";
					if($start != 1){
						$prev = "?start=".($start-$limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/users/resultado.php<?php echo $prev; ?>">&laquo;</a></li>
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
						<a class="pag" href="ajax/users/resultado.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
					</li>
					<?php
					endfor;
				?>
				<?php if($start != $anterior): ?>
				<?php 
					$next = "#";
					if($start != $anterior){
						$next = "?start=".($start + $limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/users/resultado.php<?php echo $next; ?>">&raquo;</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<script>
			$(".pag").on("click", function(){
				$.ajax({
					url: $(this).attr("href"),
					type: "GET",
					data: {sucursal: <?php echo $id; ?>},
					success: function(res){
						$("#resultadoSucursal").html(res);
					}
				});
				return false;
			});
		</script>
		<?php
		else:
		?>
			<div class="alert alert-info">
				<strong>Vaya! </strong> No hay usuarios registrados en la sucursal seleccionada.
			</div>
		<?php
		endif;
	else:
?>
	<div class="alert alert-warning">
		Seleccione una sucursal.
	</div>
<?php
	endif;
?>

<script>
	//Obtener los scripts necesarios para que funcione x-editable
	$.when(
		//Funciona para cargar varios scripts, pero solamente cargamos uno
		$.getScript( "res/x-editable/bootstrap3-editable/js/bootstrap-editable.js" ),
		$.Deferred(function( deferred ){ // esperar a que el DOM esté listo
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