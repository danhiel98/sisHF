<?php

  $usr = new UserData();
  $usr->id = $_SESSION["user_id"];
  $usr->user = $_POST["username"];
  $usr->email = $_POST["email"];
  $usr->updateG();
  $updtG = true;

?>
