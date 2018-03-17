<?php

	include 'loader.php';
	if(isset($_POST['addProduct'])){
		$product = new ProductData();
		$product->mantenimiento = 0;
		if (isset($_POST["mantto"])) {
			$product->mantenimiento = 1;
			$product->mesesmantto = $_POST["mesesMantto"];
		}
		$product->idcategoria = $_POST["category"];
		$product->nombre = $_POST["nombre"];
		$product->descripcion = $_POST["descripcion"];
		$product->preciocosteo = $_POST["preciocosteo"];
		$product->precioventa = $_POST["precioventa"];
		$product->existencias = $_POST["inicial"];
		$product->idusuario = Session::getUID();

		if(isset($_FILES["imagen"])){
			$imagen = new Upload($_FILES["imagen"]);
			if($imagen->uploaded){
				$imagen->Process("storage/products/");
				if($imagen->processed){
					$product->imagen = $imagen->file_dst_name;
					$r = $product->add_with_image();
				}
			}else{
				$r = $product->add();
			}
		}else{
			$r = $product->add();
		}
		
		$prodSuc = new ProductoSucursalData();
		$prodSuc->idproducto = $r[1];
		$sucursales = SucursalData::getAll();
		foreach ($sucursales as $sc){
			$prodSuc->idsucursal = $sc->id;
			$prodSuc->minimo = 5;
			if ($sc->id == 1) {
				$prodSuc->minimo = $_POST["minimo"];
			}
			$prodSuc->cantidad = 0;
			if ($sc->id == 1) {
				$prodSuc->cantidad = $product->existencias;
			}
			$prodSuc->add();
		}
	}
	@header("location: index.php?view=products");
?>
