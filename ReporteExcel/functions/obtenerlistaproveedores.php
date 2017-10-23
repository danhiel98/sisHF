<?php 
function obtenerlistaproveedores()
{
  $mysqli = getConnexion();
  $query = 'SELECT  * FROM proveedor WHERE estado = 1 ';
  return $mysqli->query($query);

}