<?php

    @session_start();
    
    include "funciones.php";
    
    if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"]) && isset($_REQUEST["opc"]) && !empty($_REQUEST["opc"]))
    {
        $opc = $_REQUEST["opc"]; #Controlar si se va a agregar o quitar un producto a la devolución
        $id = $_REQUEST["id"]; #El id delproducto que se va a agregar o quitar
        
        $idParecido = false; #En caso que se envíe el id de un producto más de una vez

        switch ($opc) {
            case 'add':
                if (!isset($_SESSION["prodsDev"]) || empty($_SESSION["prodsDev"])){
                    #Este array servirá para almacenar el id de los productos a devolver
                    $_SESSION["prodsDev"] = array(array("id"=>$id));
                    echo "ok"; #Para controlar si todo está bien
                }else{
                    $prods = $_SESSION["prodsDev"];
                    $idParecido = buscarId($prods,$id);
                    if (!$idParecido){
                        array_push($_SESSION["prodsDev"],array("id"=>$id));
                        echo "ok";
                    }
                }
                break;
            case 'quit':
                $prods = $_SESSION["prodsDev"];
                $prodsDev = array(); #Array auxiliar
                foreach ($prods as $prd){
                    if ($prd["id"] != $id){
                        array_push($prodsDev,$prd);
                    }
                }
                $_SESSION["prodsDev"] = $prodsDev;
                echo "ok";
                break;
            case 'cancel':
                #
                break;
            default:
                # code...
                break;
        }

    }