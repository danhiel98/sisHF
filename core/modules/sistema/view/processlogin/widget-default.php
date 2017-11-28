<?php

  // define('LBROOT',getcwd()); // LegoBox Root ... the server root
  // include("core/controller/Database.php");
  include("loader.php");
  if(Session::getUID() == ""){
    $base = new Database();
    $con = $base->connect();

    $user = $con->real_escape_string($_POST['user']);
    $pass = sha1(md5($con->real_escape_string($_POST['pass'])));

    $sql = "select * from usuario where (email= \"".$user."\" or usuario = \"".$user."\") and clave= \"".$pass."\" and activo = 1";
    #print $sql;
    $query = $con->query($sql);
    $userid = null; #Para almacenar el variable de sesión
    $usrs = array(); #Para controlar los datos obtenidos de la consulta.
    $_SESSION["usr_suc"] = ""; #Para saber en cual sucursal se encuentra el usuario que ingresa

    while($r = $query->fetch_array()){
      array_push($usrs, $r);
    }
    print_r($usrs);
    if (count($usrs) == 1) {
      foreach ($usrs as $r) {
        $userid = $r['idUsuario'];
        if ($r['idEmpleado'] != null) {
          $emp = EmpleadoData::getById($r['idEmpleado']);
          $_SESSION["usr_suc"] = $emp->getSucursal()->id;
        }else{
          if ($userid == 2){
            $sucursales = SucursalData::getAll();
            if (count($sucursales) > 0) {
              $_SESSION["usr_suc"] = 1;
              $_SESSION["adm"] = true;
            }
          }
        }
        if (isset($_SESSION['incpwd'])) {
          unset($_SESSION['incpwd']);
        }
      }
      $_SESSION['user_id'] = $userid;
      @header("location: index.php?view=home");
    }else{
      setcookie("incpwd","true");
      @header("location: ./index.php");
    }
  }
  @header("location: index.php");
?>
