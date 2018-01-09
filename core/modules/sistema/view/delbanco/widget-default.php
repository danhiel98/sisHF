<?php
    
    include "loader.php";
    $banco = new BancoData();
    if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($banco->getById($_GET["id"]))){
        $banco = $banco->getById($_GET["id"]);
        $enviosBanco = EnvioData::getByBanco($banco->id);
        if (count($enviosBanco) <= 0){
            $banco->del();
            setcookie("okBanco","¡Se eliminó la información correctamente!");
        }else{
            setcookie("errorBanco","No se puede eliminar el banco porque ya se han registrado envíos hacia él.");
        }
    }else{
        setcookie("errorBanco","!Vaya! Parece que no se ha podido eliminar el banco. Por favor, inténtelo nuevamente.");
    }
    Core::redir("./index.php?view=banco");

?>
