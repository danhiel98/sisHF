<?php
	
	$nemp = false; #Para validar si hay empleados disponibles para crearles cuenta de usuario
	$empleados = EmpleadoData::getAllForUser();
	
	if (isset($_SESSION["usr_suc"]) &&  !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllForUserBySucId($_SESSION["usr_suc"]);
	}

	$u = UserData::getById(Session::getUID());
	$sucursal = SucursalData::getAll();
	
	#Si el usuario NO es administrador:
	if (!$u->isAdmin):
?>
		<script type="text/javascript">
			window.location = "index.php?view=home";
		</script>
<?php
	endif;
?>

<script type="text/javascript" src="ajax/users/ajax.js"></script>

<div class="row">
	<div class="col-md-12">
		
		<div class="btn-group pull-right">
			<a class="btn btn-default" <?php 
			if (count($empleados)<=0){
				echo "disabled onclick='return false'"; $nemp = true;
			} ?> 
			href="<?php if($nemp){echo "#";}else{
					echo 'index.php?view=newuser&emp=true';} ?>"><i class="icon-user-plus"></i> Nuevo Usuario</a>
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    					<i class="fa fa-download"></i> Descargar <span class="caret"></span>
  					</button>
  					<ul class="dropdown-menu" role="menu">
    					<li><a href="report/users.php ">Excel (.xlsx)</a></li>
  					</ul>
		</div>

		<h1>Lista de Usuarios</h1>
		<br>
		<div id="resultado"></div>
	</div>
</div>
