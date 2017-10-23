<div class="row">
	<div class="col-md-12">
<div class="btn-group pull-right">
	<a href="index.php?view=newdevolucion" class="btn btn-default"><i class='fa fa-smile-o'></i> Nueva Devoluci&oacute;n</a>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-download"></i> Descargar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="report/clients-word.php">Word 2007 (.docx)</a></li>
  </ul>
</div>
</div>
		<h1>Directorio de Devoluciones</h1>
<br>
		<?php

		$users = PersonData::getClients();
		if(count($users)>0){
			// si hay usuarios
			?>

			<table class="table table-bordered table-hover">
			<thead>
			<th>Cliente</th>
			<th>Producto</th>
			<th>Motivo</th>
			<th>Fecha</th>
			<th>Opciones</th>
			</thead>
			<?php
			foreach($users as $user){
				?>
				<tr>
				<td><?php echo $user->name." ".$user->lastname; ?></td>
				<td><?php echo $user->address1; ?></td>
				<td><?php echo $user->email1; ?></td>
				<td><?php echo $user->phone1; ?></td>
				<td style="width:130px;">
				<a href="index.php?view=editdevolucion&id=<?php echo $user->id;?>" class="btn btn-warning btn-xs">Editar</a>
				<a href="index.php?view=deldevolucion&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a>
				</td>
				</tr>
				<?php

			}



		}else{
			echo "<p class='alert alert-danger'>No hay clientes</p>";
		}


		?>


	</div>
</div>