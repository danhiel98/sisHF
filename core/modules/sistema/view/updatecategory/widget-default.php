<?php

include "loader.php";
if(count($_POST)>0){
	$cat = CategoryData::getById($_POST["eid"]);
	$cat->nombre = $_POST["ename"];
	$cat->update();
	print "<script>window.location='index.php?view=categories';</script>";
}

?>
