<?php
	
	$idSuc = $_SESSION["usr_suc"];

	if($idSuc != 1){
		error();
	}

	$regresar = "index.php?view=produccion";
	if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/sisHF/index.php?view=newproducn&delAll"){
		$regresar = $_SERVER['HTTP_REFERER'];
	}
	
	include("modals/resumen.php");
	
	$prods = ProductData::getAll();
	$matp = MateriaPrimaData::getAll();

	$ok = false;

	if(count($prods) > 0 && count($matp) > 0 ){
		$ok = true;
	}

?>
<?php if(isset($_SESSION["productn"]) && count($_SESSION["productn"])>0 && isset($_GET["x"])):?>
	<script type="text/javascript">
		$(function(){
			$("#btnResumen").click();
		});
	</script>
<?php endif; ?>
<script src="ajax/produccion/ajax.js"></script>
<a class="btn btn-default" href="<?php echo $regresar; ?>"><i class="fa fa-arrow-left"></i> Regresar</a>
<div class="row">
<?php if (count($prods)>0):
		if (count($matp)>0):
			if (!isset($_SESSION["productn"])): ?>
				<script type="text/javascript">
					$(function(){
						$("#resumen").modal("show");
					});
				</script>
			<?php endif; ?>
			<div class="col-md-12">
				<h1>Registrar Producci&oacute;n</h1>
				<section id="tabla_resultado"></section>
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
