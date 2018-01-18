<?php

$traspaso = new TraspasoData();

if ((isset($_GET["id"]) && !empty($_GET["id"])) && !is_null($traspaso->getById($_GET["id"]))){
    $idTrasp = $_GET["id"];
    $error = false;
    
    $traspaso = TraspasoData::getById($idTrasp);
    $prods = $traspaso->getAllProductsByTraspasoId($idTrasp);
    
    foreach ($prods as $prd){
        $prodSucDestino = ProductoSucursalData::getBySucursalProducto($traspaso->iddestino,$prd->idproducto);
        $prodSucDestino->cantidad = $prodSucDestino->cantidad - $prd->cantidad;

        if($prodSucDestino->cantidad < 0){
            $error = true;
        }
        
    }

    if(!$error){
        foreach ($prods as $prd){
            $prodSucOrigen = ProductoSucursalData::getBySucursalProducto($traspaso->idorigen,$prd->idproducto);
            $prodSucOrigen->cantidad = $prodSucOrigen->cantidad + $prd->cantidad;
            $prodSucOrigen->updateEx();
            
            $prodSucDestino = ProductoSucursalData::getBySucursalProducto($traspaso->iddestino,$prd->idproducto);
            $prodSucDestino->cantidad = $prodSucDestino->cantidad - $prd->cantidad;
            $prodSucDestino->updateEx();
            
            $prd->delTraspasoProducto();
        }
        $traspaso->del();
        setcookie("okTrasp","¡Se eliminó la información correctamente!");
    }else{
        setcookie("errorTrasp","No se puede eliminar el traspaso porque no hay sufucientes productos en la sucusal de destino.");
    }

}
@header("location: index.php?view=traspasos");

?>
