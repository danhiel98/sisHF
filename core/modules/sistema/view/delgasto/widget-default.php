<?php

  $data = GastoData::getById($_GET["id"]);
  $data->del();
  Core::redir("./index.php?view=gastos");

?>
