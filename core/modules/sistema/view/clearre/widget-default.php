<?php
if(isset($_GET["idMP"])){
	$cart = $_SESSION["reabastecerMP"];
	if(count($cart) == 1){
	 unset($_SESSION["reabastecerMP"]);
	}else{
		$ncart = null;
		$nx=0;
		foreach($cart as $c){
			if($c["idMateriaPrima"]!=$_GET["idMP"]){
				$ncart[$nx]= $c;
			}
			$nx++;
		}
		$_SESSION["reabastecerMP"] = $ncart;
	}

}else{
 unset($_SESSION["reabastecerMP"]);
}

	print "<script>window.location='index.php?view=re';</script>";

?>
