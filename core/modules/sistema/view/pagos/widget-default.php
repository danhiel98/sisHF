<?php
    include "modals/agregar.php";
    $pagos = AbonoData::getAll();
?>
<div class="row">
    <div class="btn-group pull-right">
        <a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-smile-o'></i> Registrar Pago </a>
    </div>
    <div class="col-md-12">
        <h1>Pagos Realizados</h1>
        <?php if (count($pagos) > 0): ?>
           <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="20px"></th>
                            <th width="100px">No. Pedido</th>
                            <th>Cliente</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Tipo Comprobante</th>
                            <th>No. Comprobante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pagos as $p): ?>
                        <tr>
                            <td><a class="btn btn-default btn-xs" href="index.php?view=detallepedido&id=<?php echo $p->idpedido; ?>"><i class="fa fa-eye"></i></a></td>
                            <td><?php echo $p->idpedido; ?></td>
                            <td><?php echo $p->getClient()->name." ".$p->getClient()->lastname; ?></td>
                            <td>$ <?php echo $p->cantidad; ?></td>                            
                            <td><?php echo $p->fecha; ?></td>
                            <td><?php echo $p->getComprobante()->nombre; ?></td>
                            <td><?php echo $p->numerocomprobante; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
           </div>
        <?php else: ?>
        <div class="alert alert-info">
            No se han reaizado pagos.
        </div>
        <?php endif; ?>
    </div>
</div>