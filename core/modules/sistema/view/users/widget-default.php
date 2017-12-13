<?php
	
	$nemp = false; #Para validar si hay empleados disponibles para crearles cuenta de usuario
	$empleados = EmpleadoData::getAllForUser();
	
	if (isset($_SESSION["usr_suc"]) &&  !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllForUserBySucId($_SESSION["usr_suc"]);
	}

	$u = UserData::getById(Session::getUID());
	$sucursal = SucursalData::getAll();
	
	#Si el usuario NO es administrador:
	if (!$u->tipo == 1 || !$u->tipo == 2):
?>
		<script type="text/javascript">
			window.location = "index.php?view=home";
		</script>
<?php
	endif;
?>
<!-- x-editable (bootstrap 3) -->
<link href="res/x-editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="res/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="ajax/users/ajax.js"></script>
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
		
		<?php	
		$users = UserData::getAll();
		if(count($users)>0):
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
				<table class="table table-bordered table-hover">
					<thead>
						<th>Nombres</th>
						<th>Apellidos</th>
						<th>Usuario</th>
						<th>Correo Electr&oacute;nico</th>
						<th>Sucursal</th>
						<th style="text-align:center;">Estado</th>
						<th style="text-align:center;">Tipo</th>
					</thead>
					<?php foreach($users as $user): ?>
						<?php if((isset($_SESSION["usr_suc"]) && ($user->getEmpleado()->getSucursal()->id == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])): ?>
						<tr>
							<td><?php echo $user->getEmpleado()->nombre; ?></td>
							<td><?php echo $user->getEmpleado()->apellido; ?></td>
							<td><?php echo $user->username; ?></td>
							<td><?php echo $user->email; ?></td>
							<td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
							<td class="estado" style="text-align:center;">
								<a href="#" id="estado" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->activo; ?>" data-source="ajax/users/estados.php" title="Estado"></a>
							</td>
							<td class="tipo" style="text-align:center;">
								<a href="#" id="tipo" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->tipo; ?>" data-source="ajax/users/tipos.php" title="Tipo"></a>
							</td>
						</tr>
					<?php
						endif;
					endforeach;
					?>
				</table>
			</div>
			<div id="suc" class="tab-pane fade in">
				<div class="row">
					<div class="form-group form-horizontal">
						<label for="sucursal" class="col-md-1 control-label">Sucursal</label>
						<div class="col-md-6">
							<select class="form-control" name="sucursal" id="sucursal">
								<option value="">--SELECCIONE--</option>
								<?php foreach ($sucursal as $s): ?>
									<option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="btn-group pull-right">
							<div>
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<i class="fa fa-download"></i> Descargar <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a id="reporteEPS" target="_blank">Excel (.xlsx)</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div id="resultadoSucursal"></div>
			</div>
		</div>
		<?php
		else:
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
		endif;
		?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			var id = $("#sucursal").val();
			obtenerDatosDeSucursal(id);
			$(this).tab('show');
		});

		//Para enviar el id de la sucursal al hacer el cambio de sucursal
		$("#sucursal").on("change",function(){
			var valor = $(this).val();
			if (valor >= 1){
				$("#reporteEPS").attr("href","report/usuario.php?idSuc="+ valor);
			}else{
				$("#reporteEPS").attr("href","#");
			}
		});
	});
  
	$(function(){
		$('.estado a').editable({
			showbuttons: false,
			url: 'ajax/users/procesos.php' 
		});

		$('.tipo a').editable({
			showbuttons: false,
			url: 'ajax/users/procesos.php'
		});
	});

</script>
