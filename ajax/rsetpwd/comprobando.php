<?php

	//incluye el archivo conectar
	include('../conectar.php');

	$bd = new Conexion();
	//Tomando Valores
	$usuario = $bd->real_escape_string($_POST["usuario"]);
	$correo = $bd->real_escape_string($_POST["correo"]);
	$preg = false;

	if($usuario<>"" && $correo<>""){
		try {

			$sql = $bd->query("SELECT * from usuario where usuario=\"$usuario\" and email=\"$correo\"");

			if($bd->rows($sql) > 0) {
				while ($consulta = $bd->recorrer($sql)) {
					$idpregunta = $consulta['idPreguntaSecreta'];
					if ($idpregunta != null) {
						$preg = true;
					}
				}

				if ($preg){
					?>
					<br>
					<label for="Respuesta"> <?php $bd->mostrarValor("pregunta", "preguntaSecreta", "idPreguntaSecreta",$idpregunta); ?> </label>
					<div class="form-group">
						<input type="password" id="Respuesta" name="txtrespuesta"  placeholder="Respuesta" required />
					</div>
					<button type="submit" name="accion">Generar Contrase&ntilde;a</button>
					<?php
				}else{
					?>
						<center><p class='alert alert-danger'><b> Lo Sentimos!</b> El usuario especificado no tiene asignado un m&eacute;todo de recuperaci&oacute;n de contrase&ntilde;a</p></center>
					<?php
				}
			}else{
				?>
				<div class='alert alert-danger'><b> Lo Sentimos!</b> Los datos no coindicen. Vefirifique los datos</div>
				<?php
			}
		} catch (Exception $e) {
			echo 	'<script>
						alert("Lo sentimos,\nExiste un problema,\nPor: " + '.$e->getMessage().');
					</script>';
		}
	}

?>
