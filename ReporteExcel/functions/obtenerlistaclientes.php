<?php 
function obtenerlistaclientes()
{
  $mysqli = getConnexion();
  $query = 'SELECT  * FROM cliente WHERE estado = 1 ';
  return $mysqli->query($query);

}