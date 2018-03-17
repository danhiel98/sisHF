<?php
	$idSuc = $_SESSION["usr_suc"];
	
	$user = UserData::getById(Session::getUID());
	$sucursales = SucursalData::getAll();
	$clientes = ClientData::getAll();
	$prods = ProductData::getAll();
	$servs = ServiceData::getAll();
?>
<script type="text/javascript" src="ajax/pedidos/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<?php if ((count($prods)>0 || count($servs)>0) && count($clientes)>0): ?>
			<div class="btn-group  pull-right">
				<a href="index.php?view=newpedido" class="btn btn-default"><i class="fa fa-list-alt"></i> Registrar Pedido</a>
			</div>
		<?php endif; ?>
		<h1>Pedidos</h1>
		<?php if (count($sucursales) > 1 && $user->id == 1): ?>
			<div class="form-horizontal">
				<div class="form-group">
					<label for="sucursal" class="col-md-2 col-sm-2 col-xs-2 control-label">Sucursal</label>
					<div class="col-md-4 col-sm-6 col-xs-8">
						<select name="sucursal" id="sucursal" class="form-control">
							<?php foreach($sucursales as $suc): ?>
								<option <?php if($suc->id == $idSuc){echo 'selected';} ?> value="<?php echo $suc->id; ?>"><?php echo $suc->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<script>
				$("#sucursal").on("change", function(){
					$.ajax({
						url: "ajax/pedidos/consulta.php",
						type: "POST",
						data: {
							sucursal: $(this).val()
						},
						dataType: "html",
						success: function(res){
							$("#resultado").html(res);
						}
					});
				});
			</script>
		<?php endif; ?>
		<div id="resultado"></div>
	</div>
</div>
