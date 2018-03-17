<?php
	
	if (isset($_GET["delAll"])){
		unset($_SESSION["productn"]);
		unset($_SESSION["produccion"]);
		print "<script>window.location='index.php?view=newproducn';</script>";
	}
	$products = ProductData::getAll();
?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form action="index.php?view=processprod" id="frmProduccion" class="form-horizontal" method="post">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Producci&oacute;n</h4>
				</div>
				<div class="modal-body">
					<div class="form-group col-md-3">
						<label for="producto" class="col-md-12 control-label">Producto</label>
					</div>
					<div class="form-group col-md-9">
						<div class="col-md-12">
							<select class="form-control selectpicker" data-live-search="true" data-size="5" name="producto" id="producto" required>
								<option value="">--SELECCIONE--</option>
								<?php foreach ($products as $prod): ?>
								<option value="<?php echo $prod->id; ?>"><?php echo $prod->nombre; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="form-group col-md-3">
						<label for="existencias" class="col-md-12 control-label">Existencias</label>
					</div>
					<div class="form-group control-group col-md-3">
						<div class="col-md-12 controls">
							<input type="text" class="form-control" name="existencias" id="existencias" placeholder="Existencias en la sucursal actual" data-validation-regex-regex="[0-9]{1,3}" data-validation-regex-message="Introduzca un número" required readonly>
							<p class="help-block"></p>
						</div>
					</div>

					<div class="form-group col-md-3">
						<label for="cantidad" class="col-md-12 control-label">Cantidad A Producir</label>
					</div>
					<div class="form-group control-group col-md-3">
						<div class="col-md-12 controls">
							<input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad de productos" data-validation-regex-regex="[0-9]{1,3}" data-validation-regex-message="Introduzca un número" min="1" maxlength="3" onkeypress="return soloNumeros(event);" required>
							<p class="help-block"></p>
						</div>
					</div>

					<div class="clearfix"></div>

					<div class="form-group col-md-3">
						<label for="inicio" class="col-md-12 control-label">Fecha De Inicio</label>
					</div>
					<div class="form-group control-group col-md-3">
						<div class="col-md-12 controls">
							<div class='input-group date' id='dtpInicio'>
								<input type="text" name="inicio" id="inicio" class="form-control" required data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
							<p class="help-block"></p>
						</div>
					</div>

					<div class="form-group col-md-3">
						<label for="fin" class="col-md-12 control-label">Fecha L&iacute;mite</label>
					</div>
					<div class="form-group control-group col-md-3">
						<div class="col-md-12 controls">
							<div class='input-group date' id='dtpFin'>
								<input type="text" name="fin" id="fin" class="form-control" required data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" />
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
							</div>
							<p class="help-block"></p>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="resultadoResumen"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-ok" data-dismiss="modal">Cerrar</button>
					<a href="index.php?view=newproducn&delAll" class="btn btn-danger btn-ok">Cancelar</a>
					<button type="submit" class="btn btn-md btn-success btn-ok" name="addProducn" title="Registrar Producci&oacute;n" ><span class="fa fa-save"></span> Guardar</button>
					<button class="btn btn-success" id="btnInfo">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">

	function existencias(idProducto){
		id = idProducto;
		$.ajax({
			url: "ajax/produccion/existencias.php",
			type: "POST",
			data: {idProducto: id},
			success: function(res){
				$("#existencias").val(res);
			}
		});
	}

	$("#producto").on("change", function(){
		id = $(this).val();
		existencias(id);
	});

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

	//Para que no se ejecute la función ajax al enviar los datos de formulario
	btn = false;
	$("#btnInfo").on("click", function(){
		btn = true;
		$("#frmProduccion").submit(function(event){
			if (btn){
				event.preventDefault();
				$.ajax({
					url: "ajax/produccion/info.php",
					type: "POST",
					data: $(this).serialize(),
					beforeSend: function(){
						btn = false;
					},
					success: function(){
						$("#resumen").modal("hide");
					}
				});
			}
		});
	});

	$('#resumen').on('show.bs.modal', function () {
		datosResumen();
	});

</script>
<?php if (isset($_SESSION["produccion"])): $prd = $_SESSION["produccion"]; ?>
	<script type="text/javascript">
		$(function(){
			$("#producto").val(<?php echo $prd["idProducto"] ?>);
			$("#cantidad").val(<?php echo $prd["cantidad"] ?>);
			$("#inicio").val('<?php echo $prd["inicio"] ?>');
			$("#fin").val('<?php echo $prd["fin"] ?>');
			existencias($("#producto").val());
		});
	</script>
<?php endif; ?>