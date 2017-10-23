<?php

	include("loader.php");
	if(isset($_SESSION["trasp"])){
		$prods = $_SESSION["trasp"];

		if(count($prods)>0){
			$prodSuc = new ProductoSucursalData();
			$trsp = new TraspasoData();
			$trsp->idorigen = $_POST["origen"];
			$trsp->iddestino = $_POST["destino"];
			$prodSuc->idsucursal = $trsp->iddestino;
			$trsp->idusuario = Session::getUID();
			$r = $trsp->add();

			foreach($prods as $c){
				$trsp->idtraspaso = $r[1];
				$trsp->idproducto = $c["product_id"];
				$prodSuc->idproducto = $trsp->idproducto;
				$trsp->cantidad = $c["cantidad"];
				$prodSuc->cantidad = $trsp->cantidad;

				$prods = $prodSuc->getBySucursalProducto($trsp->idorigen,$prodSuc->idproducto);
				$prods->cantidad = $prods->cantidad - $trsp->cantidad;
				$prods->updateEx();
				$prods = $prodSuc->getBySucursalProducto($trsp->iddestino,$prodSuc->idproducto);
				$prods->cantidad = $prods->cantidad + $trsp->cantidad;
				$prods->updateEx();
				#print_r($prods);
				#echo "<br><br>";
				$trsp->addTraspasoProd();
			}
		}
	}
	unset($_SESSION["origen"]);
	unset($_SESSION["trasp"]);
	header("location: index.php?view=tradex&id=$r[1]");
?>
