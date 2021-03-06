<?php
	if (isset($_GET["view"])) {
		$vista = $_GET["view"];
		switch ($vista) {
			case $vista != 'configuration':
				if (isset($_SESSION["user_temp"])) {
				unset($_SESSION["user_temp"]);
				}
				break;
			case $vista != 'inventarymp':
				if (isset($_SESSION["mp_temp"])) {
				unset($_SESSION["mp_temp"]);
				}
				break;
			case $vista != "sucursal":
				if (isset($_SESSION["suc_temp"])) {
				unset($_SESSION["suc_temp"]);
				}
			default:
				break;
		}
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="storage/icon.png">

		<title>Hierro Forjado</title>

		<!-- Bootstrap core CSS -->
		<link href="res/initializr/css/bootstrap.min.css" rel="stylesheet">
		<link href="res/initializr/css/normalize.css" rel="stylesheet">
		<!-- Add custom CSS here -->
		<link href="css/sb-admin.css" rel="stylesheet">
		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="icomoon/style.css">
		<link rel="stylesheet" href="css/bootstrap-datetime.css">
		<link rel="stylesheet" href="res/select/css/bootstrap-select.css">

		<script src="res/initializr/js/vendor/jquery-1.11.2.min.js"></script>
		<script src="res/initializr/js/vendor/bootstrap.min.js"></script>
		<script src="res/initializr/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		<script src="res/initializr/js/main.js"></script>
		<script src="js/moment.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/jqBootstrapValidation.js"></script>
		<script src="res/select/js/bootstrap-select.js"></script>
		<script src="js/bootstrap-confirmation.js"></script>
		<script src="js/validaciones.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<!-- Sidebar -->
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<?php if (Session::getUID() != ""): ?>
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php endif; ?>
					<a class="navbar-brand" href="./"><i class="fa fa-github"></i> Hierro Forjado</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<?php
					$u=null;
					if(Session::getUID() != "" && UserData::getById(Session::getUID())):
						$idSuc = $_SESSION["usr_suc"];
						$u = UserData::getById(Session::getUID());
					?>
				
					<ul class="nav navbar-nav side-nav">
						<li><a href="index.php?view=home"><i class="fa fa-home"></i> Inicio</a></li>
						<?php if ($u->tipo == 1): ?>
						<li><a href="index.php?view=sucursal"><i class="icon-office"></i> Sucursales</a></li>
						<?php endif;?>
						<?php if($u->tipo == 1 || $u->tipo == 2): ?>
						<li><a href="index.php?view=empleados"><i class="icon-users"></i> Empleados </a></li>
						<li><a href="index.php?view=users"><i class="fa fa-users"></i> Usuarios </a></li>
						<?php endif; ?>
						<?php if($idSuc == 1 && $u->tipo != 3): ?>
						<li><a href="index.php?view=providers"><i class="fa fa-truck"></i> Proveedores </a></li>
						<?php endif; ?>
						<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 3): ?>
						<li><a href="index.php?view=clients"><i class="fa fa-user-o"></i> Clientes</a></li>
						<?php endif; ?>
						<div class="clearfix"></div>
						<?php if($idSuc == 1): ?> <!-- Solamente se pueden registrar envíos de dinero desde la sucursal principal -->
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bank"></i> Bancos<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="index.php?view=banco"><i class="fa fa-bank"></i> Bancos</a></li>
								<li><a href="index.php?view=envios"><i class="fa fa-send-o"></i> Env&iacute;os</a></li>
							</ul>
						</li>
						<?php endif;?>
						<?php if($idSuc == 1): ?> <!-- Solamente se pueden registrar gastos en la sucursal principal -->
							<li><a href="index.php?view=gastos"><i class="fa fa-usd"></i> Gastos</a></li>       
							<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
								<li><a href="index.php?view=categories"><i class="fa fa-th-list"></i> Categor&iacute;as </a></li>
							<?php endif; ?>
						<?php endif;?>
						<li><a href="index.php?view=services"><i class="fa fa-th"></i> Servicios</a></li>
						<li><a href="index.php?view=products"><i class="fa fa-glass"></i> Productos </a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-area-chart"></i> Inventario <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php if($idSuc == 1): ?>
								<li><a href="index.php?view=inventarymp"><i class="fa fa-area-chart"></i> Materia Prima</a></li>
								<?php endif; ?>
								<li><a href="index.php?view=inventaryprod"><i class="fa fa-area-chart"></i> Productos</a></li>
							</ul>
						</li>
						<?php if ($_SESSION["usr_suc"] == 1): ?>
							<li><a href="index.php?view=res"><i class="fa fa-th-list"></i> Compras</a></li>
							<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
								<li><a href="index.php?view=produccion"><i class="fa fa-glass"></i> Producci&oacute;n</a></li>
							<?php endif; ?>
						<?php endif; ?>
						<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 4): ?>
							<li><a href="index.php?view=traspasos"><i class="fa fa-exchange"></i> Traspasos</a></li>
						<?php endif; ?>
						<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 3): ?>
							<li><a href="index.php?view=pedidos"><i class="fa fa-list-alt"></i> Pedidos</a></li>
							<li><a href="index.php?view=pagos"><i class="fa fa-credit-card"></i> Pagos</a></li>
							<li><a href="index.php?view=sells"><i class="fa fa-shopping-cart"></i> Ventas</a></li>
							<li><a href="index.php?view=box"><i class="fa fa-archive"></i> Caja</a></li>
						<?php endif; ?>
						<?php if($u->tipo == 1 || $u->tipo == 2 || $u->tipo == 3): ?>            
							<li><a href="index.php?view=devolucion"><i class="fa fa-reply"></i> Devoluciones</a></li>
						<?php endif; ?>
						<?php if($idSuc == 1): ?>
							<li><a href="index.php?view=sbox"><i class="fa fa-archive"></i> Caja Chica </a></li>
						<?php endif; ?>
						<div class="clearfix"></div>
						<br><br>
					</ul>
					<?php
					
						if ($u->idempleado == null || $u->idempleado == ""){
						$nombreUsuario = $u->name." ".$u->lastname;
						}else{
						$nombre = preg_split("[ ]", $u->getEmpleado()->nombre);
						$apellido = preg_split("[ ]",$u->getEmpleado()->apellido);
						$nombreUsuario = $nombre[0]." ".$apellido[0];
						}
					
					?>
					<ul class="nav navbar-nav navbar-right ">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-user fa-fw"></i>
								<?php echo $nombreUsuario; ?> <b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="index.php?view=configuration"><i class="fa fa-cog fa-fw"></i> Configuraci&oacute;n</a></li>
								<li><a target="_blank" href="about"><i class="fa fa-info fa-fw"></i> Acerca de</a></li>
								<li><a href="logout.php"><i class="fa icon-exit fa-fw"></i> Salir</a></li>
							</ul>
						</li>
					</ul>
					<?php
						// if($idSuc == 1){
							include "alertas.php";
						// }
					?>
					<?php 
					else:
						Session::unsetUID();
					?>
					<?php endif; ?>
				</div><!-- /.navbar-collapse -->
			</nav>
			<div id="page-wrapper">
				<?php
				if (isset($_GET["view"]) && Session::getUID() == "") {
					@header("location: index.php");
				}
				
				View::load("login");
				
				?>
			</div><!-- /#page-wrapper -->
		</div><!-- /#wrapper -->
	</body>
</html>