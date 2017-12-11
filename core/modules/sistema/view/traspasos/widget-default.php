<?php

	$sucs = false;
	$sucursales = SucursalData::getAll();
	$prodSuc = ProductoSucursalData::getAllBySucId($_SESSION["usr_suc"]);
	if (count($sucursales)>1) {
		$sucs = true;
	}
	$traspasos = TraspasoData::getAll();
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group  pull-right">
			<?php if ($sucs && count($prodSuc)>0): ?>
			<a href="index.php?view=newtraspaso" class="btn btn-default"><i class="fa fa-exchange"></i> Registrar Traspaso</a>
			<?php endif; ?>
			<?php if (count($traspasos)>0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/traspasos.php">Excel (.xlsx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Traspasos Realizados</h1>
		<?php
			if(count($traspasos)>0){
		?>
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
			if($page==1){
				$curr_traspasos = TraspasoData::getAllByPage($traspasos[0]->id,$limit);
			}else{
				$curr_traspasos = TraspasoData::getAllByPage($traspasos[($page-1)*$limit]->id,$limit);
			}
			$npaginas = floor(count($traspasos)/$limit);
 			$spaginas = count($traspasos)%$limit;
			if($spaginas>0){ $npaginas++;}
		?>
			<h3>P&aacute;gina <?php echo $page." de ".$npaginas; ?></h3>
			<div class="btn-group pull-right">
			<?php
				$px=$page-1;
				if($px>0):
			?>
				<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=traspasos&limit=$limit&page=".($px); ?>"><i class="glyphicon glyphicon-chevron-left"></i> Atr&aacute;s </a>
				<?php endif; ?>
				<?php
				$px=$page+1;
				if($px<=$npaginas):
				?>
					<a class="btn btn-sm btn-default" href="<?php echo "index.php?view=traspasos&limit=$limit&page=".($px); ?>">Adelante <i class="glyphicon glyphicon-chevron-right"></i></a>
				<?php endif; ?>
			</div>
			<div class="clearfix"></div>
			<br>
			<table class="table table-bordered table-hover">
				<thead>
					<th></th>
					<th>No.</th>
					<th>Origen</th>
					<th>Destino</th>
					<th>Fecha</th>
					<th>Registrado Por</th>
				</thead>
				<?php foreach($curr_traspasos as $trasp):?>
					<tr>
						<td style="width:30px;">
							<a href="index.php?view=tradex&id=<?php echo $trasp->id; ?>" title="Detalles de traspaso" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
						</td>
						<td><?php echo $trasp->id; ?></td>
						<td>
							<?php echo $trasp->getSucursalO()->nombre; ?>
						</td>
						<td>
							<?php echo $trasp->getSucursalD()->nombre; ?>
						</td>
						<td><?php echo $trasp->fecha; ?></td>
						<td><?php echo $trasp->getUser()->name." ".$trasp->getUser()->lastname; ?></td>
						<!--<td style="width:70px;">
							<a href="index.php?view=editproduct&id=<?php #echo $trasp->id; ?>" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
							<a onclick="return confirm('¿Seguro que desea eliminar el registro?');" href="index.php?view=delproduct&id=<?php echo $trasp->id; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
							</td>
						-->
					</tr>
				<?php endforeach;?>
				</table>
				<div class="btn-group pull-right">
				<?php
				for($i=0;$i<$npaginas;$i++){
					echo "<a href='index.php?view=traspasos&limit=$limit&page=".($i+1)."' class='btn btn-default btn-sm'>".($i+1)."</a> ";
				}
				?>
				</div>
				<form class="form-inline control-group">
					<div class="controls">
						<label for="limit">L&iacute;mite</label>
						<input type="hidden" name="view" value="traspasos">
						<input type="number" value=<?php echo $limit?> name="limit" style="width:60px;" class="form-control" min="1" maxlength="6" onkeypress="return soloNumeros(event);">
					</div>
				</form>
				<div class="clearfix"></div>
			<?php
			}else{
			?>
			<div class="jumbotron">
				<div class="container">
					<?php if ($sucs): ?>
						<h2>No se han registrado traspasos</h2>
						Puede registrar uno dando click en el boton <b>"Registrar Traspaso"</b>
					<?php else: ?>
						<h2>No se puede registrar traspasos</h2>
						Para ello debe haber m&aacute;s de una sucursal registrada.
						<a href="index.php?view=sucursal">Ir a sucursales</a>
					<?php endif; ?>
				</div>
			</div>
		<?php
		}
		?>
		<br><br><br><br><br><br><br><br>
	</div>
</div>
