<?php

  $provider = ProviderData::getById($_GET["id"]);
  $provider->del();
  Core::redir("./index.php?view=providers");

?>
