<?php
	$pedidos = PedidoData::getAll();
	$clientes = ClientData::getAll();
	$productos = ProductData::getAll();
?>
<script type="text/javascript" src="js/bootstrap-confirmation.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<?php if (count($clientes)>0 && count($productos)>0): ?>
				<a href="index.php?view=newpedido" class="btn btn-default"><i class="fa fa-list-alt"></i> Registrar Pedido</a>
			<?php endif; ?>
			<?php if (count($pedidos)>0): ?>
				<div class="btn-group pull-right">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-download"></i> Descargar <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="report/products-word.php">Word 2007 (.docx)</a></li>
					</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Lista de Pedidos</h1>
		<div class="clearfix"></div>
		<?php
		$page = 1;
		if(isset($_GET["page"])){
			$page=$_GET["page"];
		}
		$limit=10;
		if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
			$limit=$_GET["limit"];
		}
			if(count($pedidos)>0){
				if($page==1){
					$pedidos_act = PedidoData::getAllByPage($pedidos[0]->id,$limit);
				}else{
					$pedidos_act = PedidoData::getAllByPage($pedidos[($page-1)*$limit]->id,$limit);
				}
				$npaginas = floor(count($pedidos)/$limit);
 				$spaginas = count($pedidos)%$limit;
				if($spaginas>0){ $npaginas++;
				}
			?>
			<h3>P&aacute;gina <?php echo $page." de ".$npaginas; ?></h3>
			<div class="btn-group pull-right">
			<?php
				$px=$page-1;
				if($px>0):
			?>
				<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=pedidos&limit=$limit&page=".($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atr&aacute;s </a>
			<?php endif; ?>
			<?php
				$px=$page+1;
				if($px<=$npaginas):
			?>
				<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=pedidos&limit=$limit&page=".($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
			<?php endif; ?>
			</div>
			<div class="clearfix"></div>
			<br>
			<table class="table table-bordered table-hover">
				<thead>
					<th style="width: 45px;"></th>
					<th>No.</th>
					<th>Cliente</th>
					<th>Fecha de Solicitud</th>
					<th>Fecha de Entrega</th>
					<th style="width: 50px;"></th>
				</thead>
				<?php foreach($pedidos_act as $pdo):?>
				<tr>
					<td><a href="index.php?view=detallepedido&id=<?php echo $pdo->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
					<td><?php echo $pdo->id; ?></td>
					<td><?php echo $pdo->getClient()->name; ?></td>
					<td><?php echo $pdo->fechapedido; ?></td>
					<td><?php echo $pdo->fechaentrega; ?></td>
					<td>
						<a title="Finalizar" href="#" class="btn btn-sm btn-success finalizar" id="<?php echo $pdo->id; ?>"
							data-toggle="confirmation-popout" data-popout="true" data-placement="left"
							data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
							data-btn-ok-class="btn-success btn-xs"
							data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
							data-btn-cancel-class="btn-danger btn-xs"
							data-title="¿Finalizar?">
							<i class="fa fa-check"></i>
						</a>
						<!--<a title="Cancelar" href="#" class="btn btn-sm btn-danger cancelar" id="<?php echo $pdo->id; ?>"
							data-toggle="confirmation-popout" data-popout="true" data-placement="left"
							data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
							data-btn-ok-class="btn-success btn-xs"
							data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
							data-btn-cancel-class="btn-danger btn-xs"
							data-title="¿Cancelar?">
							<i class="fa fa-times"></i>
						</a>-->
					</td>
				</tr>
				<?php endforeach;?>
			</table>
			<div class="btn-group pull-right">
			<?php
			for($i=0;$i<$npaginas;$i++){
				echo "<a href='index.php?view=pedidos&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
			}
			?>
			</div>
			<form class="form-inline">
				<label for="limit">L&iacute;mite</label>
				<input type="hidden" name="view" value="products">
				<input type="number" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control">
			</form>
			<div class="clearfix"></div>
	<?php
	}else{
	?>
		<div class="col-md-12">
			<h2>No hay pedidos</h2>
			<div class="alert alert-danger">
				No se han registrado pedidos.
			</div>
			<?php if (count($clientes)<=0 && count($productos)<=0): ?>
				<div class="alert alert-info">
					Para poder registrar pedidos, debe haber clientes y productos en el sistema.
				</div>
			<?php elseif(count($clientes)<=0): ?>
				<div class="alert alert-info">
					Para poder registrar pedidos, debe haber clientes en el sistema. <a href="index.php?view=clients">Ir a Clientes.</a>
				</div>
			<?php elseif(count($productos)<=0): ?>
				<div class="alert alert-info">
					Para poder registrar pedidos, debe haber productos en el sistema. <a href="index.php?view=products">Ir a Productos.</a>
				</div>
			<?php endif; ?>
		</div>
	<?php
	}
	?>
		<br>
	</div>
</div>
<script type="text/javascript">
	$('[data-toggle=confirmation]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
		container: 'body'});
	$('[data-toggle=confirmation-singleton]').confirmation({
		rootSelector: '[data-toggle=confirmation-singleton]',
		container: 'body'});
	$('[data-toggle=confirmation-popout]').confirmation({
		rootSelector: '[data-toggle=confirmation-popout]',
		container: 'body'});
	$('#confirmation-delegate').confirmation({
		selector: 'button'
	});
</script>
