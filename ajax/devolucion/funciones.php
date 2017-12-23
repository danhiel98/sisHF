<?php

function buscarId($array, $id){
    foreach ($array as $arr){
        if ($arr['id'] == $id){
            return true;
        }
    }
    return false;
}