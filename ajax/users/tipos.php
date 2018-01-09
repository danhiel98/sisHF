<?php

  sleep(1);   

  @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/UserTypeData.php");

  $tiposUsr = UserTypeData::getAll();

  $tipos = array();

  foreach ($tiposUsr as $type){
    $datos = array('value' => $type->id, 'text' => ''.$type->nombre.'');
    array_push($tipos,$datos);
  }

  if (isset($_GET["X"])){
    array_pop($tipos);
  }

  echo json_encode($tipos);