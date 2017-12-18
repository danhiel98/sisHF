<?php
    include "modals/pedido.php";
    $todos = false;
    $id = "";
    if (isset($_REQUEST["idP"]) && $_REQUEST["idP"] != ""){
        $id = $_REQUEST["idP"];
        $pagos = AbonoData::getAllByPedidoId($id);
    }else{
        $pagos = AbonoData::getAll();
        $todos = true;
    }
    $total = 0;
?>
<script src="ajax/pagos/ajax.js"></script>
<div class="row">
    <!--
    <div class="btn-group pull-right">
        <a data-toggle="modal" data-target="#agregar" class="btn btn-default"><i class='fa fa-credit-card'></i> Registrar Pago </a>
    </div>
    -->
    <div class="col-md-12">
        <?php if($id != ""): ?>
        <a class="btn btn-default" href="index.php?view=detallepedido&id=<?php echo $id; ?>"><i class="fa fa-arrow-left"></i> Regresar</a>
        <?php endif; ?>
        <h1>Pagos Realizados <?php if(!$todos){echo "[Pedido #$id]";} ?></h1>
        <?php if (count($pagos) > 0):
            if ($id == ""){
                $start = 1; $limit = 5;
                if(isset($_REQUEST["start"]) && isset($_REQUEST["limit"])){
                    $start = $_REQUEST["start"];
                    $limit = $_REQUEST["limit"];
                    #Para evitar que se muestre un error, se valida que los valores enviados no sean negativos
                    if ($start <= 0 ){
                        $start = 1;
                    }
                    if ($limit <= 0 ){
                        $limit = 1;
                    }
                }
                $paginas = floor(count($pagos)/$limit);
                $spaginas = count($pagos)%$limit;
                if($spaginas>0){$paginas++;}
                $pagos = AbonoData::getByPage($start,$limit);
                
            }
            $num = 0; #Contador
        ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <?php if($todos): ?>
                            <th width="100px">Pedido</th>
                            <?php endif; ?>
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
                            <td><?php echo ++$num; ?></td>
                            <?php if($todos): ?>
                            <td><a data-toggle="modal" data-target="#detalleP" class="btn btn-default btn-xs btn-detail" id="<?php echo $p->idpedido; ?>"><i class="fa fa-list"></i> Detalles</a></td>
                            <?php endif; ?>
                            <td><?php echo $p->getClient()->name." ".$p->getClient()->lastname; ?></td>
                            <td>$ <?php echo number_format($p->cantidad,2,".",","); $total += $p->cantidad; ?></td>                            
                            <td><?php echo date("d/m/Y", strtotime($p->fecha)); ?></td>
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
            <?php if ($id == ""): ?>
            <div class="container-fluid">
                <div class="pull-right">
                    <ul class="pagination">
                        <?php if($start != 1):?>
                        <?php
                            $prev = "#";
                            if($start != 1){
                                $prev = "&start=".($start-$limit)."&limit=".$limit;
                            }
                        ?>
                        <li class="previous"><a href="index.php?view=pagos<?php echo $prev; ?>">&laquo;</a></li>
                        <?php endif; ?>
                        <?php 
                            $anterior = 1;
                            for($i=1; $i<=$paginas; $i++):
                                $inicio = 1;
                                if ($i != 1){
                                    $inicio = $limit + $anterior;
                                    $anterior = $inicio;
                                }
                            ?>
                            <li <?php if($start == $inicio){echo "class='active'";} ?>>
                                <a href="index.php?view=pagos&start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php
                            endfor;
                        ?>
                        <?php if($start != $anterior): ?>
                        <?php 
                            $next = "#";
                            if($start != $anterior){
                                $next = "&start=".($start + $limit)."&limit=".$limit;
                            }
                        ?>
                        <li class="previous"><a href="index.php?view=pagos<?php echo $next; ?>">&raquo;</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
        <div class="alert alert-info">
            No se han reaizado pagos.
        </div>
        <?php endif; ?>
    </div>
</div>