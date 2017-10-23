<div class="row">
	<div class="col-md-12">
		<a class="btn btn-default" href="index.php?view=inventarymp"><i class="fa fa-arrow-left"></i> Regresar</a>
		<h1>Compra De Materia Prima</h1>
		<form>
			<div class="row">
				<div class="col-md-6">
					<input type="hidden" name="view" value="re">
					<input type="text" name="product" class="form-control" placeholder="Ingrese el ID o nombre del producto">
				</div>
				<div class="col-md-3">
					<button type="submit" class="btn btn-primary"><i class="fa fa-search fa-fw"></i> Buscar</button>
				</div>
			</div>
		</form>
	</div>
	<?php if(isset($_GET["product"])):?>
	<?php
		$products = MateriaPrimaData::getLike($_GET["product"]);
		if(count($products)>0){
	?>
	<hr>
	<div class="col-md-12">
		<h3>Resultados de la B&uacute;squeda</h3>
		<table class="table table-bordered table-hover">
			<thead>
				<th>C&oacute;digo</th>
				<th>Nombre</th>
				<th>Descripci&oacute;n</th>
				<th>En Inventario</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th style="width:100px;"></th>
			</thead>
			<?php foreach($products as $matPrim):?>
			<form method="post" action="index.php?view=addtore">
				<tr>
					<td style="width:80px;"><?php echo $matPrim->id; ?></td>
					<td><?php echo $matPrim->nombre; ?></td>
					<td><?php echo $matPrim->descripcion; ?></td>
					<td><?php echo $matPrim->existencias; ?></td>
					<td>
						<input type="number" class="form-control" required name="cantidadMP" placeholder="Cantidad ..." min="1">
					</td>
					<td>
						<input type="number" step="0.01" class="form-control" required name="precioMP" placeholder="Precio Unitario" min="0.01">
					</td>
					<td style="width:100px;">
						<input type="hidden" name="idMP" value="<?php echo $matPrim->id; ?>">
						<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i> Agregar</button>
					</td>
				</tr>
			</form>
			<?php endforeach;?>
		</table>
	</div>
	<?php
		}
	?>
	<br><hr>
	<hr><br>
<?php endif; ?>
<?php if(isset($_SESSION["errors"])):?>
	<h2>Errores</h2>
	<p></p>
	<table class="table table-bordered table-hover">
		<tr class="danger">
			<th>Codigo</th>
			<th>Producto</th>
			<th>Mensaje</th>
		</tr>
		<?php foreach ($_SESSION["errors"]  as $error):
			$product = MateriaPrimaData::getById($error["idMP"]);
		?>
		<tr class="danger">
			<td><?php echo $product->id; ?></td>
			<td><?php echo $product->nombre; ?></td>
			<td><b><?php echo $error["message"]; ?></b></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php
		unset($_SESSION["errors"]);
		endif; ?>
	<?php if(isset($_SESSION["reabastecerMP"])):
		$total = 0;
	?>
	<div class="col-md-12">
		<h2>Lista de Reabastecimiento</h2>
		<table class="table table-bordered table-hover">
			<thead>
				<th>C&oacute;digo</th>
				<th>Producto</th>
				<th>Existencias</th>
				<th>Cantidad</th>
				<th>Precio Unitario</th>
				<th>Total</th>
				<th></th>
			</thead>
			<?php foreach($_SESSION["reabastecerMP"] as $p):
				$product = MateriaPrimaData::getById($p["idMateriaPrima"]);
				$total += $p["precio"]*$p["cantidad"];
			?>
			<tr>
				<td><?php echo $product->id; ?></td>
				<td><?php echo $product->nombre; ?></td>
				<td><?php echo $product->existencias; ?></td>
				<td><?php echo $p["cantidad"]; ?></td>
				<td>$<?php echo number_format($p["precio"], 2); ?></td>
				<td>$<?php echo number_format($p["precio"]*$p["cantidad"], 2); ?></td>
				<td style="width:30px;"><a href="index.php?view=clearre&idMP=<?php echo $product->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Cancelar</a></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<form method="post" class="form-horizontal" id="processre" action="index.php?view=processre">
			<h2>Resumen</h2>
			<div class="form-group">
		    <label for="idProveedor" class="col-lg-2 control-label">Proveedor</label>
		    <div class="col-lg-10">
		    <?php
					$proveedor = ProviderData::getAll();
		    ?>
		    	<select name="idProveedor" class="form-control" required>
		    		<option value="">-- NINGUNO --</option>
		    		<?php foreach($proveedor as $prov):?>
		    		<option value="<?php echo $prov->id;?>"><?php echo $prov->nombre;?></option>
		    		<?php endforeach;?>
		    	</select>
		    </div>
		  </div>
			<div class="form-group">
		    <label for="money" class="col-lg-2 control-label">Efectivo</label>
		    <div class="col-lg-10">
		      <input type="number" step="0.01" name="money" required class="form-control" id="money" placeholder="Efectivo">
		    </div>
		  </div>

		  <div class="row">
				<div class="col-md-6 col-md-offset-6">
					<table class="table table-bordered">
						<tr>
							<td><p>Subtotal</p></td>
							<td><p><b>$ <?php echo number_format($total, 2); ?></b></p></td>
						</tr>
						<tr>
							<td><p>IVA</p></td>
							<td><p><b>$ <?php echo number_format($total*.15, 2); ?></b></p></td>
						</tr>
						<tr>
							<td><p>Total</p></td>
							<td><p><b>$ <?php echo number_format($total*1.15, 2); ?></b></p></td>
						</tr>
					</table>
		  		<div class="form-group">
		    		<div class="col-lg-offset-2 col-lg-10">
		     			<div class="checkbox">
		      			<input name="is_oficial" type="hidden" value="1">
								<a href="index.php?view=clearre" class="btn btn-lg btn-danger"><i class="fa fa-times fa-fw"></i> Cancelar</a>
			       		<button class="btn btn-lg btn-primary"><i class="fa fa-refresh fa-spin"></i> Procesar Reabastecimiento</button>
		      		</div>
		    		</div>
		  		</div>
				</div>
			</div>
		</form>
	</div>
		<script>
			$("#processsell").submit(function(e){
				money = $("#money").val();
				if(money < <?php echo $total;?>){
					alert("No se puede efectuar la operacion");
					e.preventDefault();
				}else{
					go = confirm("Cambio: $"+(money-<?php echo $total;?>));
					if(go){}
						else{e.preventDefault();}
				}
			});
		</script>

		<br><br><br><br><br>
		<?php endif; ?>
</div>
