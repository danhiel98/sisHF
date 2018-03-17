<?php
	$idSuc = $_SESSION["usr_suc"];
	$sucs = false;
	$sucursales = SucursalData::getAll();
	$prodSuc = ProductoSucursalData::getAllForSell($idSuc);
	$trasp = new TraspasoData();

	$sucursalesDisponibles = array();
	foreach($sucursales as $suc){
		if($suc->id != 1){ //Si no es la principal
			$usuarios = UserData::getAllBySucId($suc->id);
			if(count($usuarios) > 0){//Solamente aparecerán las sucursales donde se hayan creado usuarios previamente
				array_push($sucursalesDisponibles,$suc); 
			}
		}
	}

	if (count($sucursalesDisponibles) > 0) {
		$sucs = true;
	}

	$traspasos = $trasp->getAllBySuc($idSuc);
?>
<script type="text/javascript" src="ajax/traspasos/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<?php if ($sucs && count($prodSuc)>0): ?>
			<a href="index.php?view=newtraspaso" class="btn btn-default"><i class="fa fa-exchange"></i> Registrar Traspaso</a>
			<?php endif; ?>
			<?php if (count($traspasos)>0): ?>
				<div class="btn-group pull-right">
					<a class="btn btn-default" href="report/traspasos.php"><i class="fa fa-download fa-fw"></i> Descargar</a>
				</div>
			<?php endif; ?>
		</div>
		<h1>Traspasos</h1>
		<div class="container-fluid">
			<?php if (isset($_COOKIE["errorTrasp"]) && !empty($_COOKIE["errorTrasp"])): ?>
				<div class="alert alert-warning alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-warning fa-fw'></i> <?php echo $_COOKIE["errorTrasp"]; ?></p>
				</div>
			<?php setcookie("errorTrasp","",time()-18600); endif; ?>
			<?php if (isset($_COOKIE["okTrasp"]) && !empty($_COOKIE["okTrasp"])): ?>
				<br>
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okTrasp"]; ?></p>
				</div>
			<?php setcookie("okTrasp","",time()-18600); endif; ?>
		</div>
		<div id="resultado"></div>
	</div>
</div>
