<?php

	$idSuc = $_SESSION["usr_suc"];
	if($idSuc != 1){
		error();
	}

	#print_r($_SERVER);

?>
<script type="text/javascript" src="ajax/producciones/ajax.js"></script>
<div class="row">
	<div class="col-md-12">
		<div id="btnAdd"></div>
		<h1>Producci&oacute;n</h1>
		<div id="resultado">
			<!-- Aquí se cargan todos los datos de los pedidos -->
		</div>
	</div>
</div>