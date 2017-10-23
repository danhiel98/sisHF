<?php

	if (!isset($_COOKIE["traspaso"])){
		$productos = array("idProducto"=>$_POST['idProd'],"cantidad"=>$_POST["cant"]);
		$_SESSION["productos"] = array($productos);
		print_r($_SESSION["productos"]);
		$prods = $_SESSION["productos"];
		setcookie("traspaso", "true");
	}else{
		?>
		<script type="text/javascript">
			$("#<?php echo $_POST['idProd']; ?>").
		</script>
		<?php
		/*
		$prods = $_SESSION["productos"];
		foreach ($prods as $p) {
			if ($p["idProducto"] == $_POST["idProducto"]) {

			}
		}
		*/
	}

?>
