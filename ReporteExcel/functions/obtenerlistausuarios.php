<?php 
function obtenerlistausuarios()
{
  $mysqli = getConnexion();
  $query = 'SELECT E.nombre as nombreE, E.apellido as apellido, E.email as email, E.usuario as usuario, W.nombre as nombreSucursal FROM usuario as E JOIN empleado as S JOIN sucursal as W ON S.idSucursal = W.idSucursal where E.activo = 1';
  return $mysqli->query($query);
}