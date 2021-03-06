<?php
	
	$u = UserData::getById(Session::getUID());
	#Si el usuario NO es administrador:
	if ($u->tipo != 1 && $u->tipo != 2){
		error();
	}
	$emps = false; #Para validar si hay empleados disponibles para crearles cuenta de usuario
	if ($u->tipo == 1){
		$empleados = EmpleadoData::getAllForUser();
	}elseif($u->tipo == 2){
		$empleados = EmpleadoData::getAllForUserBySucId($u->getEmpleado()->idsucursal);
	}

	if (count($empleados) > 0) {
		$emps = true; #Sí hay empleados disponibles
	}

	$usrSuc = false;
	
	if (isset($_SESSION["usr_suc"]) && !isset($_SESSION["adm"])) {
		$empleados = EmpleadoData::getAllForUserBySucId($_SESSION["usr_suc"]);
		$usrSuc = true;
	}


	$sucursal = SucursalData::getAll();
	$users = UserData::getAll();

	include "modals/changePassword.php";
	include "modals/confirm.php";
?>
<!-- x-editable (bootstrap 3) -->
<link href="res/x-editable/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="res/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="ajax/users/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<?php if($emps): ?>
			<a class="btn btn-default" href="index.php?view=newuser"><i class="icon-user-plus"></i> Nuevo Usuario</a>
			<?php endif; ?>
			<?php if (count($users) > 0): ?>
				<a class="btn btn-default" target="_blank" href="report/users.php "><i class="fa fa-download"></i> Descargar</a>
			<?php endif; ?>
		</div>

		<h1>Lista de Usuarios</h1>
		<?php
		if(count($users)>0):
			if(isset($_COOKIE['password_updated'])):?>
			<div class="alert alert-success alert-dimissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<p><i class='fa fa-info'></i> <?php echo $_COOKIE['password_updated']; ?></p>
			</div>
			<?php
			setcookie("password_updated","",time()-18600);
			endif;
			?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#all">Todos</a></li>
			<?php if (count($sucursal)>1 && !$usrSuc): ?>
				<li><a href="#suc" id="tabSuc">Por Sucursal</a></li>
			<?php endif; ?>
		</ul>
		<br>
		<div class="tab-content">
			<div id="all" class="tab-pane fade in active">
				<?php
				$start = 1; $limit = 10;
				if(isset($_REQUEST["start"]) && isset($_REQUEST["limit"])){
					$start = $_REQUEST["start"];
					$limit = $_REQUEST["limit"];
					#Para evitar que se muestre un error, se valida que los valores enviados no sean negativos
					if ($start <= 0 ){
						$start = 1;
					}
					if ($limit <= 0 ){
						$limit = 1;
					}
				}
				$paginas = floor(count($users)/$limit);
				$spaginas = count($users)%$limit;
				if($spaginas>0){$paginas++;}
				$users = UserData::getAllByPage($start,$limit);
				$num = $start;
				?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Usuario</th>
								<th>Correo Electr&oacute;nico</th>
								<th>Sucursal</th>
								<th style="text-align:center;">Estado</th>
								<th style="text-align:center;">Tipo</th>
								<?php if($u->id == 1): ?>
								<th style="width:20px;"></th>
								<?php endif; ?>
							</tr>
						</thead>
						<?php foreach($users as $user): ?>
							<?php 
							$idSuc = $user->getEmpleado()->getSucursal()->id;
							//Si los datos que se solicitan son de la sucursal en la que nos encontramos o si es el administrdor principal quien solicita los datos
							if((isset($_SESSION["usr_suc"]) && ($idSuc == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])):
							?>
							<tr>
								<td style="width: 30px;"><?php echo $num++; ?></td>
								<td><?php echo $user->getEmpleado()->nombre; ?></td>
								<td><?php echo $user->getEmpleado()->apellido; ?></td>
								<td><?php echo $user->username; ?></td>
								<td><?php echo $user->email; ?></td>
								<td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
								<td class="estado" style="text-align:center;">
									<?php if($u->id != $user->id): ?>
										<a href="#" id="estado" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->activo; ?>" data-source="ajax/users/estados.php" title="Estado"></a>
									<?php else: ?>
										<span class="notready"><?php if($user->activo){echo "Activo";}else{echo "Inactivo";} ?></span>
									<?php endif; ?>
								</td>
								<td class="tipo" style="text-align:center;">
									<?php if($u->id != $user->id): ?>
										<a href="#" id="tipo" data-type="select" data-pk="<?php echo $user->id; ?>" data-value="<?php echo $user->tipo; ?>" data-source="ajax/users/tipos.php<?php if($idSuc != 1){echo "?X";} ?>" title="Tipo"></a>
									<?php else: ?>
										<span class="notready"><?php echo $user->getUserType()->nombre; ?></span>
									<?php endif; ?>
								</td>
								<?php if($u->id == 1): ?>
								<td><a class="btn btn-xs btn-warning btn-passwd" data-id="<?php echo $user->id; ?>" data-toggle="modal" data-target="#confirm" title="Nueva contraseña"><i class="fa fa-cog fa-fw"></i></a></td>
								<?php endif; ?>
							</tr>
						<?php
							endif;
						endforeach;
						?>
					</table>
				</div>
				<div class="pull-right">
					<ul class="pagination">
						<?php if($start != 1):?>
						<?php
							$prev = "#";
							if($start != 1){
								$prev = "&start=".($start-$limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=users<?php echo $prev; ?>">&laquo;</a></li>
						<?php endif; ?>
						<?php 
							$anterior = 1;
							for($i=1; $i<=$paginas; $i++):
								$inicio = 1;
								if ($i != 1){
									$inicio = $limit + $anterior;
									$anterior = $inicio;
								}
							?>
							<li <?php if($start == $inicio){echo "class='active'";} ?>>
								<a href="index.php?view=users&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
							</li>
							<?php
							endfor;
						?>
						<?php if($start != $anterior): ?>
						<?php 
							$next = "#";
							if($start != $anterior){
								$next = "&start=".($start + $limit)."&limit=".$limit;
							}
						?>
						<li class="previous"><a href="index.php?view=users<?php echo $next; ?>">&raquo;</a></li>
						<?php endif; ?>
					</ul>
				</div>
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
								<a class="btn btn-default" id="reporteEPS" target="_blank"><i class="fa fa-download"></i> Descargar</a>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div id="resultadoSucursal"></div>
			</div>
		</div>
		<script>
			$(".btn-passwd").on("click",function(){
				id = $(this).data("id");
				$.ajax({
					url: "ajax/usuario/resultadoID.php",
					type: "POST",
					data: {
						id: id
					},
					success: function(data){
						oDato = JSON.parse(data);
						$("#usr").text(oDato.username);
						$("#idUsr").val(oDato.id);
					}
				});
			});
		</script>
		<?php
		else:
		?>
			<div class="alert alert-warning">
				No se han registrado usuarios.
			</div>
			<?php if ($emps): ?>
				<div class="alert alert-warning">
					Para ello debe dar clic en <strong>"Nuevo Usuario".</strong>
				</div>
			<?php else: ?>
				<div class="alert alert-warning">
					Para ello primero debe registrar un empleado. <a href="index.php?view=empleados">Ir a empleados</a>
				</div>
			<?php endif; ?>
			
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

	vHash = document.location.hash;
	if (vHash == "#suc"){
		$("#tabSuc").tab("show");
	}

</script>
