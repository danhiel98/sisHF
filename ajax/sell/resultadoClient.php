<?php
	//Establecer la conexión a la Base de Datos
	$host = 'localhost';
	$basededatos = 'sistemaHierroForjado';
	$usuario = 'root';
	$contrasena = '';

	$conexion = new mysqli($host, $usuario,$contrasena, $basededatos);
	if ($conexion->connect_errno){
		die("Falló la conexión:(".$conexion->mysqli_connect_errno().")".$conexion->mysqli_connect_error());
	}

	$ccf = false;
	if (isset($_POST["tipo"]) && $_POST["tipo"] == "CCF") {
		$query="SELECT * FROM cliente where estado = 1 AND nrc IS NOT NULL AND nrc != ''";
		$ccf = true;
	}else{
		$query="SELECT * FROM cliente where estado = 1";
	}

	$result = $conexion->query($query);
	#if (count($clientes)>0) {
		echo '<option value="">--NINGUNO--</option>';
		while ($cli = mysqli_fetch_assoc($result)) {
			?>
			<option value="<?php echo $cli['idCliente']; ?>"><?php echo $cli['nombre']." ".$cli['apellido']; ?></option>
			<script type="text/javascript">
				$(function(){
					$('.selectpicker').selectpicker('refresh');
				});
			</script>
			<?php
		}
	#}
	?>
	<script type="text/javascript">
		$(function(){
			$('.selectpicker').selectpicker('refresh');
		});
	</script>
	<?php if ($ccf): ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").attr("required","true");
			});
		</script>
	<?php else: ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").removeAttr("required","true");
			});
		</script>
	<?php endif; ?>
