<?php
	if(isset($_SESSION["reabastecerMP"])){
		$cart = $_SESSION["reabastecerMP"];
		if(count($cart) > 0){

			$process = true;
			$total = 0;
			if($process == true){
				$reab = new ReabastecimientoData();
				 if(count($_POST)>0){
				 	$reab->idproveedor = $_POST["proveedor"];
					$reab->idusuario = Session::getUID();
					$reab->tipo = $_POST["tipo"];
					$reab->comprobante = $_POST["numero"];
	 				$s = $reab->add();
				 }

				foreach($cart as  $c){
					$totalMP = ($c["precio"]*$c["cantidad"]);
					$reabMP = new ReabastecimientoMPData();
					$reabMP->idmateriaprima = $c["idMateriaPrima"];
					$reabMP->cantidad = $c["cantidad"];
					$reabMP->precio = $c["precio"];
					$reabMP->total = $totalMP;
					$reabMP->idfacturamp = $s[1];
					$add = $reabMP->add();

					$matPrim = MateriaPrimaData::getById($c["idMateriaPrima"]);
					$matPrim->existencias += $c["cantidad"];
					$matPrim->updateEx();

					$total += $totalMP;
				}
				$reab = ReabastecimientoData::getById($s[1]);
				$reab->total = $total;
				$reab->updateTot();

				unset($_SESSION["reabastecerMP"]);
				setcookie("comprado","comprado");
				print "<script>window.location='index.php?view=onere&id=$s[1]';</script>";
			}
		}
	}
?>
