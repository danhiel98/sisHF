<?php

$banco = BancoData::getById($_GET["id"]);
$banco->del();
Core::redir("./index.php?view=banco");

?>
