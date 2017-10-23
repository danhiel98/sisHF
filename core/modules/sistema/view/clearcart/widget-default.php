<?php
	if(isset($_GET["idProducto"])){
		$cart=$_SESSION["cart"];
		if(count($cart)==1){
	 		unset($_SESSION["cart"]);
		}else{
			$ncart = null;
			$nx=0;
			foreach($cart as $c){
				if($c["idProducto"]!=$_GET["idProducto"]){
					$ncart[$nx]= $c;
				}
				$nx++;
			}
			$_SESSION["cart"] = $ncart;
		}
	}else{
 		unset($_SESSION["cart"]);
	}
	print "<script>window.location='index.php?view=sell';</script>";
?>
