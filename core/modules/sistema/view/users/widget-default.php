<?php
	$nemp = false; #Para validar si hay empleados disponibles para crearles cuenta de usuario
	$empleados = EmpleadoData::getAllForUser();
	if (isset($_SESSION["usr_suc"]) &&  !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllForUserBySucId($_SESSION["usr_suc"]);
	}
	$u = UserData::getById(Session::getUID());
	$sucursal = SucursalData::getAll();
	if (!$u->isAdmin) {
		?>
		<script type="text/javascript">
			window.location = "index.php?view=home";
		</script>
		<?php
	}
 ?>
<script type="text/javascript" src="ajax/users/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<a class="btn btn-default" <?php if (count($empleados)<=0){echo "disabled onclick='return false'"; $nemp = true;} ?> href="<?php if($nemp){echo "#";}elseif($_SESSION["user_id"]==1){echo 'index.php?view=newuser';}else{echo 'index.php?view=newuser&emp=true';} ?>"><i class="icon-user-plus"></i> Nuevo Usuario</a>
		</div>
		<h1>Lista de Usuarios</h1>
		<br>
		<?php
		$users = UserData::getAll();
		if(count($users)>0){
			#print_r($users);
		?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#all">Todos</a></li>
			<?php if (count($sucursal)>1): ?>
			<li><a href="#suc">Por Sucursal</a></li>
			<?php endif; ?>
		</ul>
		<br>
		<div class="tab-content">
			<div id="all" class="tab-pane fade in active">
			</div>
			<?php if (count($sucursal)>1): ?>
			<script type="text/javascript" src="ajax/users/ajax.js"></script>
			<div id="suc" class="tab-pane fade">
				<div class="">
					<div class="form-group">
						<label for="sucursal" class="col-md-1 control-label">Sucursal</label>
						<div class="col-md-6">
							<select class="form-control" name="sucursal" id="sucursal">
								<option value="">--SELECCIONE--</option>
								<?php foreach ($sucursal as $s): ?>
									<option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<section id="tabla_resultado">
				</section>
			</div>
			<?php endif; ?>
		</div>
			<?php
		}else{
			?>
			<div class="jumbotron">
				<div class="container">
					<?php if ($nemp): ?>
						<h2>No se han registrado usuarios. Para ello debe haber empleados registrados y después dar clic en <strong>"Nuevo Usuario".</strong></h2>
					<?php else: ?>
						<h2>No se han registrado usuarios. Para ello debe dar clic en <strong>"Nuevo Usuario".</strong></h2>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			var idSuc = $("#sucursal").val();
			obtenerDatosDeSucursal(idSuc);
			obtenerUsuarios("x");
			$(this).tab('show');
		});
	});
</script>
