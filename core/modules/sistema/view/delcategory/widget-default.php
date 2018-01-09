<?php

	$category = new Categorydata();
	if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($category->getById($_GET["id"]))){
		$category = $category->getById($_GET["id"]);
		$products = ProductData::getAllByCategory($category->id);
		if (count($products) <= 0){
			$category->del();
			setcookie("okCategory","¡Se eliminó la información correctamente!");
		}else{
			setcookie("errorCategory","No se puede eliminar la categoría porque hay productos que dependen de ella.");
		}
	}else{
		setcookie("errorCategory","!Vaya! Parece que no se ha podido eliminar la categoría. Por favor, inténtelo nuevamente.");
	}
	Core::redir("./index.php?view=categories");

?>