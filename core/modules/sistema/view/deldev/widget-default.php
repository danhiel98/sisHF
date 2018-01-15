<?php

    $idSuc = $_SESSION["usr_suc"];
    $dev = new DevolucionData();
	$prodSuc = new ProductoSucursalData();
	$id = $_GET["id"];
	
	if ((isset($_GET["id"]) && is_numeric($_GET["id"])) && !is_null($dev->getById($_GET["id"]))){
		$dvolucion = $dev->getById($id);
		$prodsD = $dev->getProdsByDev($id);

		$error = false;
		foreach ($prodsD as $prod){
			$prodSuc = $prodSuc->getBySucursalProducto($idSuc,$prod->idproducto);
			$prodSuc->cantidad -= $prod->cantidad;
			if($prodSuc->cantidad < 0){
				$error = true;
				break;
			}
		}
		
		if(!$error){
			foreach ($prodsD as $prod){
				$prodSuc = $prodSuc->getBySucursalProducto($idSuc,$prod->idproducto);
				$prodSuc->cantidad -= $prod->cantidad;
				$prodSuc->updateEx();
			}	
			$dvolucion->del();
			setcookie("okDevolucion","¡Se eliminó la información correctamente!");
		}else{
			setcookie("errorDevolucion","!Vaya! Parece que no se ha podido eliminar la información porque el producto ya no se encuentra en inventario.");
		}
        

	}else{
		setcookie("errorDevolucion","!Vaya! Parece que no se ha podido eliminar la información. Por favor, inténtelo nuevamente.");
	}

   Core::redir("./index.php?view=devolucion");

?>