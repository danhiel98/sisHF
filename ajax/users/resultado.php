<?php
	session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/EmpleadoData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");

	if (isset($_POST["sucursal"]) && !empty($_POST["sucursal"])){
		$users = UserData::getAll();
		if (count($users) > 0){
			$usuarios = array();
			foreach($users as $user){
				if ($user->getEmpleado()->getSucursal()->id == $_POST["sucursal"]){
					array_push($usuarios,$user);
				}
			}
			if (count($usuarios)>0) {
		?>
			<table class="table table-bordered table-hover">
				<thead>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Usuario</th>
					<th>Correo Electr&oacute;nico</th>
					<th>Sucursal</th>
					<th>Activo</th>
					<th>Admin</th>
					<th></th>
				</thead>
			<?php
				foreach($usuarios as $user){
			?>
				<?php if ($user->getEmpleado()->getSucursal()->id == $_POST["sucursal"]): ?>
				<tr>
					<td><?php echo $user->getEmpleado()->nombre; ?></td>
					<td><?php echo $user->getEmpleado()->apellido; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
					<td>
					<?php if($user->activo):?>
						<i class="glyphicon glyphicon-ok"></i>
					<?php endif; ?>
					</td>
					<td>
					<?php if($user->isAdmin):?>
						<i class="glyphicon glyphicon-ok"></i>
					<?php endif; ?>
					</td>
					<?php
					$emp = "";
					if ($user->idempleado != null) {
						$emp = "&emp=$user->idempleado";
					}?>
					<td width=110px>
						<div class="btn-group">
							<button class="btn btn-default btn-sm">
								Opci&oacute;n
							</button>
							<button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a href="#" class="estado" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
										data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
										data-btn-ok-class="btn-success btn-xs"
										data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
										data-btn-cancel-class="btn-danger btn-xs"
										data-title="Está seguro?">
										<?php if($user->activo):?>
										Desactivar
										<?php else: ?>
										Activar
										<?php endif; ?>
									</a>
								</li>
								<li>
									<a href="#" class="admin" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
										data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
										data-btn-ok-class="btn-success btn-xs"
										data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
										data-btn-cancel-class="btn-danger btn-xs"
										data-title="Está seguro?">
										<?php if($user->isAdmin):?>
										Usuario Normal
										<?php else: ?>
										Administrador
										<?php endif; ?>
									</a>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<?php endif; ?>
				<?php
					}
				?>
			</table>
			<?php
			}else{
		?>
			<div class="container">
				<div class="alert alert-warning">
					<strong>Vaya! </strong> No hay usuarios registrados en la sucursal seleccionada.
				</div>
			</div>
		<?php
			}
		}
	}
	if (isset($_POST["users"])) {
		$users = UserData::getAll();
		?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>Nombres</th>
				<th>Apellidos</th>
				<th>Usuario</th>
				<th>Correo Electr&oacute;nico</th>
				<th>Sucursal</th>
				<th style="text-align:center;">Activo</th>
				<th style="text-align:center;">Admin</th>
				<th></th>
			</thead>
			<?php foreach($users as $user): ?>
				<?php if((isset($_SESSION["usr_suc"]) && ($user->getEmpleado()->getSucursal()->id == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])): ?>
				<tr>
					<td><?php echo $user->getEmpleado()->nombre; ?></td>
					<td><?php echo $user->getEmpleado()->apellido; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
					<td style="text-align:center;">
					<?php if($user->activo):?>
						<i class="glyphicon glyphicon-ok"></i>
					<?php endif; ?>
					</td>
					<td style="text-align:center;">
					<?php if($user->isAdmin):?>
						<i class="glyphicon glyphicon-ok"></i>
					<?php endif; ?>
					</td>
					<td width=110px>
						<div class="btn-group">
							<button class="btn btn-default btn-sm">
								Opci&oacute;n
							</button>
							<button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a href="#" class="estado" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
										data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
										data-btn-ok-class="btn-success btn-xs"
										data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
										data-btn-cancel-class="btn-danger btn-xs"
										data-title="Está seguro?">
										<?php if($user->activo):?>
										Desactivar
										<?php else: ?>
										Activar
										<?php endif; ?>
									</a>
								</li>
								<li>
									<a href="#" class="admin" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
										data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
										data-btn-ok-class="btn-success btn-xs"
										data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
										data-btn-cancel-class="btn-danger btn-xs"
										data-title="Está seguro?">
										<?php if($user->isAdmin):?>
										Usuario Normal
										<?php else: ?>
										Administrador
										<?php endif; ?>
									</a>
								</li>
							</ul>
						</div>
					</td>
					<?php
						$emp = "";
						if ($user->idempleado != null) {
							$emp = "&emp=$user->idempleado";
						}?>
				</tr>
			<?php
				endif;
			endforeach;
			?>
		</table>
		<?php
	}
?>
<script>
	$(".estado").on("confirmed.bs.confirmation",function(){
		var id = this.id;
		alert("Ha ejecutado la función acualizarEstado y ha enviado el id " + id);
		actualizarEstado(id);
		var idSuc = $('#sucursal').val();
		obtenerDatosDeSucursal(idSuc);
	});
	
	$(".admin").on("confirmed.bs.confirmation",function(){
		var id = this.id;
		alert("Ha ejecutado la función acualizarTipo y ha enviado el id " + id);
		actualizarTipo(id);
		var idSuc = $('#sucursal').val();
		obtenerDatosDeSucursal(idSuc);
	});
</script>
