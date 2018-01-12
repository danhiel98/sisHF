<?php
    $pedido = array();
    if (isset($_GET["id"]) && $_GET["id"] != ""){
        $id = $_GET["id"];
        $pedido = PedidoData::getById($id);
    }

    if (count($pedido) == 1):
        include "core/modules/sistema/view/agregarPago.php";
        $prodP = PedidoData::getAllProductsByPedidoId($_GET["id"]);
        $servP = PedidoData::getAllServicesByPedidoId($_GET["id"]);
        $total = 0;
        $client = $pedido->getClient();
?>
    <div>
        <a class="btn btn-default" href="index.php?view=pedidos"><i class="fa fa-arrow-left"></i> Regresar</a>
        <div class="btn-group pull-right">
            <a class="btn btn-default" href="index.php?view=pagos&idP=<?php echo $id; ?>"><i class="fa fa-credit-card"></i> Ver Pagos</a>
            <?php if($pedido->restante > 0): ?>
            <a class="btn btn-default" id="btnPago" data-toggle="modal" data-target="#agregar" href="#"><i class="fa fa-dollar"></i> Nuevo Pago</a>
            <?php endif; ?>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-download"></i> Descargar <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="report/pedidodetalle.php?id=<?php echo $_GET["id"];?>">Excel (.xlsx)</a></li>
            </ul>
        </div>
        <h1>Resumen de Pedido</h1>
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
                <td>
                <?php
                    if ($user->idempleado == null){
                        echo $user->fullname;
                    }else{
                        echo $user->getEmpleado()->nombrecompleto;
                    }
                ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td>Pendiente</td>
                <td><strong>$ <?php echo $pedido->restante; ?></strong></td>
            </tr>
        </table>

        <table class="table table-bordered table-hover">
            <thead>
                <th>Cantidad</th>
                <th>Nombre del Producto / Servicio</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </thead>
            <tbody>
                <?php
                foreach($prodP as $pedid):
                    $prod = $pedid->getProduct();
                ?>
                <tr>
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
    <?php else: @header("Location: index.php?view=pedidos"); ?>
<?php endif; ?>