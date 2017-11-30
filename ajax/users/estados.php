<?php

sleep(1);   

$estados = array(
  array('value' => 0, 'text' => 'Inactivo'),
  array('value' => 1, 'text' => 'Activo')
);

echo json_encode($estados);