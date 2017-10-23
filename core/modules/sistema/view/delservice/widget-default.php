<?php

  $data = ServiceData::getById($_GET["id"]);
  $data->del();
  Core::redir("./index.php?view=services");

?>
