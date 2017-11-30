<?php
    
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/UserData.php");

    $pk = $_POST['pk'];
    $name = $_POST['name'];
    $value = $_POST['value'];

    $user = UserData::getById($pk);

    switch ($name) {
        case 'estado':
            $user->activo = $value;
            $user->updateS(); #Actializar el estado
            break;
        case 'tipo':
            $user->tipo = $value;
            $user->updateT(); #Actializar el tipo de usuario            
            break;
        default:
            # code...
            break;
    }

?>