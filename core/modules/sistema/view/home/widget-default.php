<?php
	$idSuc = $_SESSION["usr_suc"];
	#Obtener los elementos registrados en el sistema para saber cuantos hay registrados
	$categorias = CategoryData::getAll();
	$servicios = ServiceData::getAll();
	$productos = ProductData::getAll();
	$materiaPrima = MateriaPrimaData::getAll();
	$produccion = ProduccionData::getActive();
	$compras = ReabastecimientoData::getAll();
	$traspasos = TraspasoData::getAllBySuc($idSuc);
	$pedidos = PedidoData::getPendienteBySuc($idSuc);
	$ventas = FacturaData::getSellsBySuc($idSuc);
	$caja = FacturaData::getSellsUnBoxedBySuc($idSuc);
	$u = UserData::getById(Session::getUID());
?>
<h1 class="page-header">
   	Hierro Forjado
</h1>
<div>
	<!--
	<h2>No hay alertas</h2>
	<p>Por el momento no hay alertas de inventario, estas se muestran cuando el inventario ha alcanzado el nivel m&iacute;nimo.</p>
	-->
	<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-green-2">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-th-list fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($categorias); ?></div>
						<div>Categorías</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=categories">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<?php endif; ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-purple">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-th fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($servicios); ?></div>
						<div>Servicios</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=services">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-lightBlue">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-glass fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($productos); ?></div>
						<div>Productos</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=products">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<?php if($idSuc == 1): ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-azulGris">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-area-chart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($materiaPrima); ?></div>
						<div>Materia Prima</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=inventarymp">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	
		<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
			<div class="panel panel-green-2">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-glass fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" style="font-size: 2.4em;"><?php echo count($produccion); ?></div>
							<div>Producción</div>
						</div>
					</div>
				</div>
				<a href="index.php?view=produccion">
					<div class="panel-footer">
						<span class="pull-left">Detalles</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<?php endif; ?>

	
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
			<div class="panel panel-purple">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-th-list fa-5x"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="huge" style="font-size: 2.4em;"><?php echo count($compras); ?></div>
							<div>Compras</div>
						</div>
					</div>
				</div>
				<a href="index.php?view=res">
					<div class="panel-footer">
						<span class="pull-left">Detalles</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-lightBlue">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-exchange fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($traspasos); ?></div>
						<div>Traspasos</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=traspasos">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<?php endif; ?>
	<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 3): ?>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-azulGris">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-list-alt fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($pedidos); ?></div>
						<div>Pedidos</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=pedidos">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-green-2">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-shopping-cart fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($ventas); ?></div>
						<div>Ventas</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=sells">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-purple">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-archive fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge" style="font-size: 2.4em;"><?php echo count($caja); ?></div>
						<div>Caja</div>
					</div>
				</div>
			</div>
			<a href="index.php?view=box">
				<div class="panel-footer">
					<span class="pull-left">Detalles</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<?php endif; ?>
</div>