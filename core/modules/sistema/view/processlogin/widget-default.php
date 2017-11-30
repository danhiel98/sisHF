<?php

  include("loader.php");

  if(Session::getUID() == ""){
    $base = new Database();
    $con = $base->connect();

    $user = $con->real_escape_string($_POST['user']);
    $pass = sha1(md5($con->real_escape_string($_POST['pass'])));

    $usuario = UserData::login($user,$pass);
    
    #Verificar si se ha encontrado el usuario con los datos ingresados
    if (count($usuario) == 1){

      #Para verificar si el usuario se encuentra inactivo
      if ($usuario->activo == 0){
        setcookie("inactiveUsr","true"); #Establece la cookie para indicar que el usuario está inactivo
        @header("location: ./index.php"); #Redirecciona a la página de inicio (login)
      }else{
        
        $userid = $usuario->id; #Obtener el id del usuario
  
        if ($usuario->idempleado != null){
          #Sirve para verificar si el usuario es un empleado (no el administrador), también sirve para saber en que sucursal se encuentra registrado
          $emp = EmpleadoData::getById($usuario->idempleado);
          $_SESSION["usr_suc"] = $emp->getSucursal()->id;
        }else{
          #Sirve para verificar si el usuario es el principal
          if ($userid == 1){
            $sucursales = SucursalData::getAll();
            if (count($sucursales) > 0) {
              $_SESSION["usr_suc"] = 1;
              $_SESSION["adm"] = true;
            }
          }
        }
      }

      if (isset($_SESSION['incpwd'])) {
        unset($_SESSION['incpwd']);
      }
      $_SESSION['user_id'] = $userid;

    }else{
      #Al no encontrar un usuario que coincidiera con los datos ingresados, se establece una cookie para indicar que los datos ingresados son incorrectos
      setcookie("incpwd","true");
      @header("location: ./index.php");
    }


  }

?>
