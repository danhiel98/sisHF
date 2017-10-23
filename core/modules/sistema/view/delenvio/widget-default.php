<?php

  $data = EnvioData::getById($_GET["id"]);
  $data->del();
  Core::redir("./index.php?view=envios");

?>
