<?php
$ventas = FacturaData::getSellsUnBoxed();

if(count($ventas)){
	$box = new BoxData();
	$box->idusuario = $_SESSION["user_id"];
	$box->idsucursal = $_SESSION["usr_suc"];
	$b = $box->add();

	foreach($ventas as $v){
		$v->idcierrecaja = $b[1];
		$v->update_box();
	}
	Core::redir("./index.php?view=b&id=".$b[1]);
}

?>
