<?php

$eventos = array(
    0 => array(
        "id"=> "1",
        "title"=> "Evento 1",
        "url"=> "",
        "class"=> "event-special",
        "start"=> "1519624800000",
        "end"=> "1519711199059"
    ),
    1 => array(
        "id"=> "2",
        "title"=> "Evento 2",
        "url"=> "",
        "class"=> "event-warning",
        "start"=> "1519624800000",
        "end"=> "1519711199059"
    )
);

$todo = array(
    "success" => 1,
    "result" => $eventos  
);

echo json_encode($todo);

?>