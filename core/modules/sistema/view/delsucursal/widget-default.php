<?php

$sucursal = SucursalData::getById($_GET["id"]);
$sucursal->del();
Core::redir("./index.php?view=sucursal");

?>
