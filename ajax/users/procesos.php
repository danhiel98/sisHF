<?php
    
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/UserData.php");
    
    if ((isset($_POST["idUsr"]) && $_POST["idUsr"]) && isset($_POST["tipo"]) && $_POST["tipo"]) {
        $usr = UserData::getById($_POST["idUsr"]);
        switch ($_POST["tipo"]) {
            case 'estado':
                if ($usr->activo == 0) {
                    $usr->activo = 1;
                }elseif ($usr->activo == 1) {
                    $usr->activo = 0;
                }
                $usr->updateS();
                break;
            case 'admin':
                if ($usr->isAdmin == 0) {
                    $usr->isAdmin = 1;
                }elseif ($usr->isAdmin == 1) {
                    $usr->isAdmin = 0;
                }
                $usr->updateT();
                break;
            default:
                # code...
                break;
        }
    }

?>