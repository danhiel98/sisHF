<?php
    
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ServiceData.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    
    $pedido = array();
    if (isset($_REQUEST["id"]) && $_REQUEST["id"] != ""){
        $id = $_REQUEST["id"];
        $pedido = PedidoData::getById($id);
    }

    if (count($pedido) == 1):
        $prodP = PedidoData::getAllProductsByPedidoId($id);
        $servP = PedidoData::getAllServicesByPedidoId($id);
        $total = 0;
        $client = $pedido->getClient();
?>
    <div>
        <table class="table table-bordered">
            <tr>
                <td>Fecha De Pedido</td>
                <td><?php echo date("d-m-Y", strtotime($pedido->fechapedido)); ?></td>
            </tr>
            <tr>
                <td>Fecha De Entrega</td>
                <td><?php echo $pedido->fechaentrega; ?></td>
            </tr>
            <tr>
                <td>Entregado</td>
                <td>
                    <?php if ($pedido->entregado == 1): ?>
                        <span class="fa fa-check"></span>
                    <?php else: ?>
                        <span class="fa fa-times"></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php if ($pedido->entregado == 1): ?>
            <tr>
                <td>Fecha Entregado</td>
                <td><?php echo $pedido->fechafinalizado; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td style="width:150px;">Cliente</td>
                <td><?php echo $client->name;?></td>
            </tr>
            <?php if($pedido->idusuario != ""):
                $user = $pedido->getUser();
            ?>
            <tr>
                <td>Atendido por</td>
                <td><?php echo $user->name." ".$user->lastname;?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>Pendiente</td>
                <td><strong>$ <?php echo $pedido->restante; ?></strong></td>
            </tr>
        </table>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>C&oacute;digo</th>
                    <th>Cantidad</th>
                    <th>Nombre del Producto / Servicio</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($prodP as $pedid):
                    $prod = $pedid->getProduct();
                ?>
                <tr>
                    <td><?php echo $prod->id ;?></td>
                    <td><?php echo $pedid->cantidad ;?></td>
                    <td><?php echo $prod->nombre ;?></td>
                    <td>$ <?php echo number_format($pedid->precio,2,".",",") ;?></td>
                    <td><b>$ <?php echo number_format($pedid->total,2,".",","); $total += $pedid->total;?></b></td>
                </tr>
                <?php endforeach; ?>
                <?php
                foreach ($servP as $pedid):
                    $prod = $pedid->getService();
                ?>
                <tr>
                    <td><?php echo $prod->id ;?></td>
                    <td><?php echo $pedid->cantidad ;?></td>
                    <td><?php echo $prod->nombre ;?></td>
                    <td>$ <?php echo number_format($pedid->precio,2,".",",") ;?></td>
                    <td><b>$ <?php echo number_format($pedid->total,2,".",","); $total += $pedid->total;?></b></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h1>Total: $ <?php echo number_format($total,2,'.',','); ?></h1>
    </div>
    <?php else: ?>
        Error 501: Internal Error.
    <?php endif; ?>