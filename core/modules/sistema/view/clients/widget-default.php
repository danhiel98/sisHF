<?php $users = ClientData::getAll(); ?>
<?php
	#include 'modal/addclient.php';
	#include 'modal/editclient.php';
?>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right">
			<!--
			<a data-toggle="modal" data-target="#newclient" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Cliente</a>
			-->
			<a href="index.php?view=newclient" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Cliente</a>
			<?php if(count($users) > 0): ?>
				<div class="btn-group pull-right">
	  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
	    			<i class="fa fa-download"></i> Descargar <span class="caret"></span>
	  			</button>
	  			<ul class="dropdown-menu" role="menu">
	    			<li><a href="report/clientes.php">Excel(.xmlx)</a></li>
	  			</ul>
				</div>
			<?php endif; ?>
		</div>
		<h1>Directorio de Clientes</h1>
		<br>
		<?php
		if(count($users)>0){
			// si hay usuarios
			?>
		<table class="table table-bordered table-hover">
			<thead>
				<th>No.</th>
				<th>DUI</th>
				<th>NIT</th>
				<th>NRC</th>
				<th>Apellidos</th>
				<th>Nombres</th>
				<th>Sexo</th>
				<th>Correo Electr&oacute;nico</th>
				<!--<th>Fecha Nacimiento</th>-->
				<th>Tel&eacute;fono</th>
				<th></th>
			</thead>
			<?php
			foreach($users as $user){
				?>
			<tr>
				<td><?php echo $user->id; ?></td>
				<td><?php echo $user->dui; ?></td>
				<td><?php echo $user->nit; ?></td>
				<td><?php echo $user->nrc;?></td>
				<td><?php echo $user->lastname; ?></td>
				<td><?php echo $user->name; ?></td>
				<td><?php echo $user->sexo; ?></td>
				<td><?php echo $user->email; ?></td>
				<?php
					if ($user->birth != "") {
						$fecha = array_reverse(preg_split("[-]",$user->birth));
						$user->birth = $fecha[0]."/".$fecha[1]."/".$fecha[2];
					}
				?>
				<!--<td><?php #echo $user->birth; ?></td>-->
				<td><?php echo $user->phone; ?></td>
				<td style="width:40px;">
					<a href="index.php?view=editclient&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
		}else{
			echo "<p class='alert alert-info'>No hay clientes registrados</p>";
		}
		?>
	</div>
</div>
