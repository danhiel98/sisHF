<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ServiceData.php");

	$services = ServiceData::getAll();

	if (count($services)>0):?>
		<table class="table table-bordered table-hover table-responsive">
			<thead>
				<th style="width:45px;"></th>
				<th>Servicio</th>
				<th>Precio</th>
				<th style="width: 140px;"></th>
			</thead>
			<tbody>
			<?php foreach ($services as $srv): $found = false;?>
				<tr>
					<td></td>
					<td><?php echo $srv->nombre; ?></td>
					<td>$ <?php echo $srv->precio; ?></td>
					<td>
						<?php if(isset($_SESSION["cart"])){ foreach ($_SESSION["cart"] as $c) { if($c["service_id"] == $srv->id){ $found=true; break; }}} ?>
						<?php if ($found): ?>
							<a data-toggle="modal" data-target="#resumen" class="btn btn-info"><i class="fa fa-check fa-fw"></i>Agregado</a>
						<?php else: ?>
							<form class="form-inline enviar" method="post" action="ajax/sell/addxsell.php">
								<input type="hidden" name="service_id" value="<?php echo $srv->id; ?>">
								<input type="hidden" name="product_id" value="" required>
								<div class="form-group control-group">
									<div class="controls">
										<input type="text" class="form-control input-sm" name="cantidad" value="1" style="width:85px;" min="1" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required>
										<button type="submit" class="btn btn-sm btn-primary"><i class="icon-cart"></i></button>
										<p class="help-block"></p>
									</div>
		  					</div>
							</form>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<script type="text/javascript">
			$(document).ready(function(){
				$("form.enviar").submit(function(){
					$.ajax({
						url: $(this).attr("action"),
						type: "POST",
						data: $(this).serialize(),
						success: function(){
							datosModal();
							datosResumen();
							obtenerServ();
						}
					});
					return false;
				});
			});
		</script>
	<?php else: ?>
		<div class="alert alert-danger">
			No se encontraron servicios
		</div>
	<?php endif; ?>
