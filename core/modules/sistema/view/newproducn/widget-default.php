<?php
	include("modals/resumen.php");
	$prods = ProductData::getAll();
	$matp = MateriaPrimaData::getAll();
?>
<?php if(isset($_SESSION["productn"]) && count($_SESSION["productn"])>0 && isset($_GET["x"])):?>
	<script type="text/javascript">
		$(function(){
			$("#btnResumen").click();
		});
	</script>
<?php endif; ?>
<script src="ajax/produccion/ajax.js"></script>
<a class="btn btn-default" href="<?php if(isset($_SERVER['HTTP_REFERER'])){echo $_SERVER['HTTP_REFERER'];}else{echo "index.php?view=produccion";} ?>"><i class="fa fa-arrow-left"></i>Regresar</a>
<div class="row">
<?php if (count($prods)>0): ?>
	<h1>Registrar Producci&oacute;n De Productos</h1>
	<?php if (count($matp)>0): ?>
	<div class="col-md-12">
		<p><b>Buscar Materia Prima:</b></p>
  		<form>
			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-10">
					<div class="input-group">
						<input type="text" name="product" id="busqueda" placeholder="Nombre o descripci&oacute;n" class="form-control" autofocus>
						<span class="input-group-addon"><i class="fa fa-search fa-fw"></i>Buscar</span>
					</div>
				</div>
				<div class="btn-group pull-right">
					<button type="button" id="btnResumen" class="btn btn-default" data-toggle="modal" data-target="#resumen">
						<i class="fa fa-list"></i> Ver Resumen</span>
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-12">
		<section id="tabla_resultado">
		</section>
	</div>
	<?php else: ?>
		<div class="col-md-12">
			<div class="clearfix"></div>
			<br>
			<div class="alert alert-warning">No se pueden registrar la producci&oacute;n.</div>
			<div class="alert alert-info">
				Para registrar una producci&oacute;n debe haber <a href="index.php?view=inventarymp">materia prima.</a>
			</div>
		</div>
	<?php endif; ?>
<?php else: ?>
	<div class="col-md-12">
		<div class="clearfix"></div>
		<br>
		<div class="alert alert-warning">No se puede registrar la producci&oacute;n.</div>
		<div class="alert alert-info">
			Para registrar una producción debe tener productos registrados en el sistema.
			<a href="index.php?view=products">Ir a productos.</a>
		</div>
	</div>
<?php endif; ?>
</div>
<?php if (!isset($_SESSION["productn"])): ?>
	<script type="text/javascript">
		$(function(){
			$("#resumen").modal("show");
		});
	</script>
<?php endif; ?>
