<?php
$idMateria = $_GET["opcionsu"];
function obtenerlistadeusuarios()
{
  $mysqli = getConnexion();
  $query = 'SELECT E.dui as dui, E.nit as nit, E.nombre as nombreE, E.apellido as apellido, E.sexo as sexo, E.area as area, E.telefono as telefono, S.nombre as nombreS FROM empleado AS E JOIN sucursal AS S ON E.idSucursal = S.idSucursal';
  return $mysqli->query($query);
}
//  $query = 'SELECT L.nombre as lista, V.nombre AS video, V.duracion, V.url FROM `materiaprima` AS V JOIN `listas_reproduccion` AS L ON V.id_lista = L.id';  SELECT * FROM empleado JOIN sucursal ON empleado.idSucursal = sucursal.idSucursal   dui, nit, nombre, apellido, sexo, area, telefono