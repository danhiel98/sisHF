<?php
	$products = ProductData::getAll();
?>
	<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<form action="index.php?view=processprod" class="form-horizontal" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Producci&oacute;n</h4>
					</div>
					<div class="modal-body">
						<div class="col-md-12">
							<div class="form-group">
								<label class="col-lg-3 control-label">Producto</label>
								<div class="col-lg-7">
									<select class="form-control selectpicker" data-live-search="true" data-size="5" name="producto" required>
										<option value="">--SELECCIONE--</option>
										<?php foreach ($products as $prod): ?>
										<option value="<?php echo $prod->id; ?>"><?php echo $prod->nombre; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group control-group">
								<label for="cantidad" class="col-lg-3 control-label">Cantidad A Producir</label>
								<div class="col-lg-7 controls">
									<input type="text" class="form-control" name="cantidad" data-validation-regex-regex="[0-9]" required>
									<p class="help-block"></p>
								</div>
							</div>
							<div class="form-group control-group">
								<label for="inicio" class="col-lg-3 control-label">Fecha De Inicio</label>
								<div class="col-lg-7 controls">
									<div class='input-group date' id='dtpInicio'>
										<input type="text" name="inicio" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido"/>
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
									<p class="help-block"></p>
								</div>
							</div>
							<div class="form-group control-group">
								<label for="fin" class="col-lg-3 control-label">Fecha L&iacute;mite</label>
								<div class="col-lg-7 controls">
									<div class='input-group date' id='dtpFin'>
										<input type="text" name="fin" class="form-control" data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido"/>
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
									<p class="help-block"></p>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function () {
			$('#dtpInicio').datetimepicker({
				format: "DD/MM/YYYY",
				locale: "es",
				minDate: new Date()
			});
			$('#dtpFin').datetimepicker({
				format: "DD/MM/YYYY",
				locale: "es",
				minDate: new Date()
				//useCurrent: false //Important! See issue #1075
			});
			$("#dtpInicio").on("dp.change", function (e) {
				$('#dtpFin').data("DateTimePicker").minDate(e.date);
			});
			$("#dtpFin").on("dp.change", function (e) {
				$('#dtpInicio').data("DateTimePicker").maxDate(e.date);
			});
		});
	</script>
