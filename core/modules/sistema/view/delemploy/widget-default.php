<?php

$employ = EmpleadoData::getById($_GET["id"]);
$employ->del();
Core::redir("./index.php?view=empleados");

?>
