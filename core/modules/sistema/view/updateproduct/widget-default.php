<?php

	include 'loader.php';
	if(count($_POST)>0){
		$product = ProductData::getById($_POST["product_id"]);
		$product->idcategoria = $_POST["category"];
		$product->nombre = $_POST["nombre"];
		$product->preciocosteo = $_POST["preciocosteo"];
		$product->precioventa = $_POST["precioventa"];
	  $product->descripcion = $_POST["descripcion"];
		$product->estado = 0;
		$product->mantenimiento = 0;
		if (isset($_POST["is_active"])) {
			$product->estado = 1;
		}
		if (isset($_POST["mantto"])) {
			$product->mantenimiento = 1;
		}

		#$product->minimo = $_POST["minimo"];
		$product->update();

		if(isset($_FILES["imagen"])){
			$imagen = new Upload($_FILES["imagen"]);
			if($imagen->uploaded){
				$imagen->Process("storage/products/");
				if($imagen->processed){
					$product->imagen = $imagen->file_dst_name;
					$product->update_image();
				}
			}
		}
		setcookie("prdupd","true");
	}

?>
<script>window.location='index.php?view=editproduct&id=<?php echo $_POST["product_id"]; ?>'</script>
