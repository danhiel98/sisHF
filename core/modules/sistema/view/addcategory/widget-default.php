<?php

	include 'loader.php';
	if(count($_POST)>0){
		$cat = new CategoryData();
		$cat->nombre= $_POST["name"];
		$cat->idusuario = Session::getUID();
		$cat->add();
	}

?>
<script>window.location='index.php?view=categories';</script>
