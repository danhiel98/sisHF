<?php
	include("loader.php");
	if (isset($_POST["addSucursal"])) {
    $sucursal = new SucursalData();
  	$sucursal->nombre = $_POST["nombre"];
  	$sucursal->direccion = $_POST["direccion"];
  	$sucursal->telefono = $_POST["telefono"];
  	$r = $sucursal->add();

    $products = ProductData::getAll();
    if (count($products)>0) {
      $ps = new ProductoSucursalData();
      $ps->idsucursal = $r[1];
      $ps->cantidad = 0;
			$ps->minimo = 5;
      foreach ($products as $p) {
        $ps->idproducto = $p->id;
        $ps->add();
      }
    }
  }
	@header("location: index.php?view=sucursal");
?>
