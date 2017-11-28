<?php
	$clientes = ClientData::getAll();
	$prods = ProductData::getAll();
?>
<script type="text/javascript" src="ajax/pedidos/ajax.js"></script>
<div class="row">
  <div class="col-md-12">
    <?php if (count($prods)>0 && count($clientes)>0): ?>
		<div class="btn-group  pull-right">
			<a href="index.php?view=newpedido" class="btn btn-default"><i class="fa fa-list-alt"></i> Registrar Pedido</a>
		</div>
  	<?php endif; ?>
    <h1>Pedidos</h1>
    <div id="resultado">
    </div>
  </div>
</div>
