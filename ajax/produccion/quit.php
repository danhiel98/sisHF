<?php

    @session_start();
    if (isset($_POST["product_id"]) && !empty($_POST["product_id"])) {
        if(!empty($_SESSION["productn"])){
            $cart = $_SESSION["productn"];
            if(count($cart) <= 1){
                unset($_SESSION["productn"]);
            }else{
                $newcart = array();
                foreach($cart as $c){
                    if($c["product_id"] != $_POST["product_id"]){
                        $newcart[] = $c;
                    }
                }
                $_SESSION["productn"] = $newcart;
            }
        }
    }

?>