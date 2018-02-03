<?php

  $usr = UserData::getById(Session::GetUID());
  $usr->id = $_SESSION["user_id"];
  $usr->user = $_POST["username"];
  $usr->email = $_POST["email"];
  $usr->updateUE();
  $updtG = true;

?>
