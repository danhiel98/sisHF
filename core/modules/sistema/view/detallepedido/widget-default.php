<?php
    $pedido = array();
    if (isset($_GET["id"]) && $_GET["id"] != ""){
        $id = $_GET["id"];
        $pedido = PedidoData::getById($id);
    }
    if (count($pedido) == 1):
?>
<div class="row">
    Hola
</div>
<?php endif ?>