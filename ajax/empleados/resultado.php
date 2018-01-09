<?php
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/EmpleadoData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");

	$empleados = array();
	if (isset($_REQUEST["sucursal"]) && $_REQUEST["sucursal"] != ""):
		$idSuc = $_REQUEST["sucursal"];
		$empleados = EmpleadoData::getAllBySucId($idSuc);
		
		if (count($empleados)>0):
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
			$paginas = floor(count($empleados)/$limit);
			$spaginas = count($empleados)%$limit;
			if($spaginas>0){$paginas++;}
			$empleados = EmpleadoData::getAllBySucPage($idSuc,$start,$limit);
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
				<?php if ($emp->getSucursal()->id == $_REQUEST["sucursal"]): ?>
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
		<div class="pull-right">
			<ul class="pagination">
				<?php if($start != 1):?>
				<?php
					$prev = "#";
					if($start != 1){
						$prev = "?start=".($start-$limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/empleados/resultado.php<?php echo $prev; ?>">&laquo;</a></li>
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
						<a class="pag" href="ajax/empleados/resultado.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
				<li class="previous"><a class="pag" href="ajax/empleados/resultado.php<?php echo $next; ?>">&raquo;</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<script>
			$(".pag").on("click", function(){
				$.ajax({
					url: $(this).attr("href"),
					type: "GET",
					data: {sucursal: <?php echo $idSuc; ?>},
					success: function(res){
						$("#tabla_resultado").html(res);
					}
				});
				return false;
			});
		</script>
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
	<?php endif; ?>