<?php
	$bancos = BancoData::getAll();
	if (count($bancos) > 0) {
		include 'modals/agregar.php';
		include 'modals/editar.php';
		$envio = EnvioData::getAll();
		$bnc = true;
	}else{
		$bnc = false;
	}
?>
<script src="ajax/envios/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<?php if ($bnc): ?>
			<div class="btn-group pull-right">
				<a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-send'></i> Registrar Env&iacute;o</a>
				<?php if(count($envio) > 0): ?>
					<div class="btn-group pull-right">
		  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
		  			</button>
		  			<ul class="dropdown-menu" role="menu">
		    			<li><a href="report/envios.php">Excel (.xlsx)</a></li>
		  			</ul>
					</div>
				<?php endif; ?>
			</div>
		<h1>Env&iacute;os De Dinero Realizados</h1>
		<br>
		<?php
			if(count($envio)>0){
		?>
			<table class="table table-bordered table-hover">
			<thead>
				<th>Banco</th>
				<th>No. Cuenta</th>
				<th>Cantidad</th>
				<th>No. Comprobante</th>
				<th>Fecha</th>
				<th>Registrado por</th>
				<th></th>
			</thead>
			<?php
			foreach($envio as $env){
			?>
				<tr>
					<td><?php echo $env->getBanco()->nombre; ?></td>
					<td><?php echo $env->getBanco()->numCuenta; ?></td>
					<td>$ <?php echo number_format($env->cantidad,2,'.',','); ?></td>
					<td><?php echo $env->comprobante; ?></td>
					<td><?php echo $env->fecha; ?></td>
					<td><?php echo $env->getUsuario()->name." ".$env->getUsuario()->lastname; ?></td>
					<td style="width:60px;">
						<a id="<?php echo $env->id;?>" data-toggle="modal" data-target="#editar" class="btn btn-warning btn-xs btn-edit">Editar</a>
						<!--<a onclick="return confirm('¿Seguro que desea eliminar el registro?')" href="index.php?view=delenvio&id=<?php #echo $env->id;?>" class="btn btn-danger btn-xs">Eliminar</a>-->
					</td>
				</tr>
				<?php

			}
		}else{
			echo "<p class='alert alert-danger'>A&uacute;n no se ha realizado ning&uacute;n env&iacute;o</p>";
		}
		?>
		<?php else: ?>
			<h1>No se pueden realizar env&iacute;os</h1>
			<p class="alert alert-danger">Debe registrar un banco para poder realizar env&iacute;os! <a href="index.php?view=banco">Ir a bancos</a></p>
		<?php endif; ?>

	</div>
</div>
