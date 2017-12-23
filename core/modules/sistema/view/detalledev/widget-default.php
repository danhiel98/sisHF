<?php
    
    $error = true;
    
    if (isset($_REQUEST["id"]) && !empty($_REQUEST["id"])){
        $id = $_REQUEST["id"];
        $dev = DevolucionData::getById($id);
        if (!is_null($dev) || !empty($dev)){
            $prods = $dev->getProdsByDev($dev->id);
            $error = false;
        }
    }

    if ($error){
        @header("location: index.php?view=devolucion");
    }
?>
<div class="row">
   <div class="col-md-12">
        <a class="btn btn-default" href="index.php?view=devolucion"><i class="fa fa-arrow-left fa-fw"></i>Regresar</a>
        <h1>Devolución No. <?php echo $id; ?></h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">Tipo Comprobante</th>
                    <td><?php echo $dev->getFactura()->getComprobante()->nombre; ?></td>
                </tr>
                <tr>
                    <th>No. Comprobante</th>
                    <td><?php echo $dev->getFactura()->numerofactura; ?></td>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <td><?php echo $dev->getFactura()->getClient()->fullname; ?></td>
                </tr>
                <tr>
                    <th>Causa</th>
                    <td><?php echo $dev->getCausa()->descripcion; ?></td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td><?php echo $dev->fecha; ?></td>
                </tr>
                <tr>
                    <th>Reembolso</th>
                    <td>$ <?php echo number_format($dev->reembolso,2,".",","); ?></td>
                </tr>
            </table>
        </div>
        <h2>Productos devueltos</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-dashed">
                <thead>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </thead>
                <tbody>
                <?php foreach($prods as $prd): ?>
                    <tr>
                        <td><?php echo $prd->getProduct()->nombre; ?></td>
                        <td style="width: 50px;"><?php echo $prd->cantidad; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
   </div>
</div>