<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ReabastecimientoData.php");
	include ("../../core/modules/sistema/model/ReabastecimientoMPData.php");

	setlocale(LC_MONETARY, 'en_US');

	$prod = false;

	$matPrim = MateriaPrimaData::getAll();

	if(isset($_POST['producto'])){
		$prod = true;
		$matPrim = MateriaPrimaData::getLike($_POST['producto']);
	}
?>
	<?php if (count($matPrim)>0): ?>
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<th style="width:40px;">ID</th>
				<th>Nombre</th>
				<th>Descripci&oacute;n</th>
				<th>En Inventario</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th style="width:50px;"></th>
			</thead>
			<?php	foreach ($matPrim as $mp): ?>
			<tr>
				<td><?php echo $mp->id; ?></td>
				<td style="max-width: 120px;"><?php echo $mp->nombre; ?></td>
				<td style="max-width: 250px;"><?php echo $mp->descripcion; ?></td>
				<td style="width: 50px; text-align: center;"><?php echo $mp->existencias; ?></td>
				<?php
					$found = false;
					if (isset($_SESSION["reabastecerMP"])){
						foreach ($_SESSION["reabastecerMP"] as $rb){
							if ($rb["idMateriaPrima"] == $mp->id){
								$found = true;
								$cn = $rb["cantidad"];
								$pr = $rb["precio"];
							}
						}
					}
				?>
				<td style="width: 50px; max-width: 60px;">
					<form onsubmit="return false;" class="frmDtos" data-id="<?php echo $mp->id; ?>" action="ajax/buy/addtore.php" method="post">
						<div class="control-group">
							<div class="controls">
								<input <?php if($found){echo "disabled";} ?> type="text" class="form-control cmpCant cmpValid" data-id="<?php echo $mp->id; ?>" name="cantidad" placeholder="Cantidad" pattern="[0-9]*" data-validation-pattern-message="Cantidad inv&aacute;lida." maxlength="6" min="1"  value="<?php if($found){echo $cn;} ?>" required>
							</div>
						</div>
					</form>
				</td>
				<td style="width: 140px;">
					<form onsubmit="return false;" class="frmDtos" data-id="<?php echo $mp->id; ?>" action="ajax/buy/addtore.php" method="post">
						<div class="control-group">
							<div class="controls">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-dollar"></i>
									</span>
									<input <?php if($found){echo "disabled";} ?> style="font-size: 0.9em;" type="text" class="form-control cmpPrec cmpValid" data-id="<?php echo $mp->id; ?>" name="precio" placeholder="Precio Unitario" min="0.01" data-validation-regex-regex="([+-]?\d+(\.\d*)?([eE][+-]?[0-9]+)?)?" data-validation-regex-message="Cantidad inv&aacute;lida" value="<?php if($found){echo number_format ($pr,2,".",",");} ?>" required>
	              				</div>
							</div>
						</div>
					</form>
				</td>
				<td style="width:50px;">
					<?php if (!$found): ?>
						<button disabled type="button" class="btn btn-success btn-sm btnEnviar" data-id="<?php echo $mp->id; ?>"><i class="fa fa-cart-plus"></i></button>
					<?php else: ?>
						<button type="button" class="btn btn-danger btn-sm btnQuitar" data-id="<?php echo $mp->id; ?>"><i class="fa fa-times"></i></button>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<script type="text/javascript">
			$(function(){
				$.getScript("ajax/buy/funciones.js",function(data, textStatus, jqxhr){
					//Acciones a realizar
				});
			});
		</script>
	<?php	else: ?>
		<div class="alert alert-danger">
		<?php if ($prod): ?>
				No se encontraron coincidencias con sus criterios de búsqueda.
		<?php else: ?>
				No hay productos disponibles en esta sucursal.
		<?php endif; ?>
		</div>
	<?php endif; ?>
