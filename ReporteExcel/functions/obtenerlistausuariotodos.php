<?php 
function obtenerlistasucursal()
{
  $mysqli = getConnexion();
  $query = 'SELECT  nombre, apellido, usuario, email,  FROM sucursal WHERE estado = 1 ';
  return $mysqli->query($query);

}
//  $query = 'SELECT L.nombre as lista, V.nombre AS video, V.duracion, V.url FROM `materiaprima` AS V JOIN `listas_reproduccion` AS L ON V.id_lista = L.id';