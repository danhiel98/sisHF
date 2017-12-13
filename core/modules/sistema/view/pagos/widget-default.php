<?php
    include "modals/agregar.php";
    $todos = false;
    if (isset($_REQUEST["idP"]) && $_REQUEST["idP"] != ""){
        $id = $_REQUEST["idP"];
        $pagos = AbonoData::getAllByPedidoId($id);
    }else{
        $pagos = AbonoData::getAll();
        $todos = true;
    }
    $total = 0;
?>
<div class="row">
    <!--
    <div class="btn-group pull-right">
        <a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Pago </a>
    </div>
    -->
    <div class="col-md-12">
        <h1>Pagos Realizados <?php if(!$todos){echo "[Pedido #$id]";} ?></h1>
        <?php if (count($pagos) > 0): ?>
           <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <?php if($todos): ?><th width="100px">No. Pedido</th><?php endif; ?>
                            <th>Cliente</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Tipo Comprobante</th>
                            <th>No. Comprobante</th>
                            <th>Recibido Por</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pagos as $p): ?>
                        <tr>
                            <?php if($todos): ?><td><?php echo $p->idpedido; ?></td><?php endif; ?>
                            <td><?php echo $p->getClient()->name." ".$p->getClient()->lastname; ?></td>
                            <td>$ <?php echo $p->cantidad; $total += $p->cantidad; ?></td>                            
                            <td><?php echo $p->fecha; ?></td>
                            <td><?php echo $p->getComprobante()->nombre; ?></td>
                            <td><?php echo $p->numerocomprobante; ?></td>
                            <td>
                                <?php
                                    $usuario = $p->getUser();
                                    if ($usuario->idempleado == null){
                                        echo $usuario->name." ".$usuario->lastname;
                                    }else{
                                        $empleado = $p->getUser()->getEmpleado();
                                        echo $empleado->name." ".$empleado->lastname;
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(!$todos): ?>
                <h2>Total: <strong>$ <?php echo number_format($total,2,".",","); ?></strong></h2>
                <?php endif; ?>
           </div>
        <?php else: ?>
        <div class="alert alert-info">
            No se han reaizado pagos.
        </div>
        <?php endif; ?>
    </div>
</div>