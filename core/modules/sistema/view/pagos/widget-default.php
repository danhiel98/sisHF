<?php
    include "modals/pedido.php";
    $todos = false;
    $idPedido = "";
    $idSuc = $_SESSION["usr_suc"];
    if (isset($_REQUEST["idP"]) && is_numeric($_REQUEST["idP"])){
        $idPedido = $_REQUEST["idP"];
        $pagos = AbonoData::getAllByPedidoId($idPedido);
    }else{
        $pagos = AbonoData::getAllBySuc($idSuc);
        $todos = true;
    }
    
    $user = UserData::getById(Session::getUID());
    $sucursales = SucursalData::getAll();

    $total = 0;
?>
<script src="ajax/pagos/ajax.js"></script>
<div class="row">
    
    
    <div class="col-md-12">
        <?php if($idPedido != ""): ?>
        <a class="btn btn-default" href="index.php?view=detallepedido&id=<?php echo $idPedido; ?>"><i class="fa fa-arrow-left"></i> Regresar</a>
        <div class="btn-group pull-right">
            <a href="report/pagos.php?idPedido=<?php echo $idPedido; ?>" class="btn btn-default"><i class='fa fa-download fa-fw'></i>Reporte </a>
        </div>
        <?php endif; ?>
        <h1>Pagos Realizados <?php if(!$todos){echo "[Pedido]";} ?></h1>

        <?php if (count($sucursales) > 1 && $user->id == 1 && $idPedido == ""): ?>
            <div class="form-horizontal">
        <div class="container-fluid">
                <label for="sucursal" class="col-md-2 col-sm-2 col-xs-2 control-label">Sucursal</label>
                <div class="col-md-4 col-sm-6 col-xs-8">
                    <select name="sucursal" id="sucursal" class="form-control">
                        <?php foreach($sucursales as $suc): ?>
                            <option <?php if($suc->id == $idSuc){echo 'selected';} ?> value="<?php echo $suc->id; ?>"><?php echo $suc->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <script>
                $("#sucursal").on("change", function(){
                    $.ajax({
                        url: "ajax/pagos/resultadoSucursal.php",
                        type: "POST",
                        data: {
                            sucursal: $(this).val()
                        },
                        dataType: "html",
                        success: function(res){
                            $("#resultado").html(res);
                        }
                    });
                });
            </script>
        </div>
        <?php endif; ?>

        <div class="clearfix"></div>
        <br>
        <?php if (count($pagos) > 0):
            $num = 1;
            if ($idPedido == ""){
                $start = 1; $limit = 10;
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
                $pagos = AbonoData::getByPage($idSuc,$start,$limit);
                
                $num = $start; #Contador
            }
            
        ?>
        <div id="resultado">
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pagos as $p): ?>
                        <?php
                            $comp = $p->getComprobante()->nombre;
                            $comprobante = "";
                            switch ($comp){
                                case "Factura":
                                    $comprobante = "factura";
                                    break;
                                case "Comprobante de Crédito Fiscal":
                                    $comprobante = "ccf";
                                    break;
                                case "Recibo":
                                    $comprobante = "recibo";
                                    break;
                            }
                        ?>
                        <tr>
                            <td><?php echo $num++; ?></td>
                            <?php if($todos): ?>
                            <td><a data-toggle="modal" data-target="#detalleP" class="btn btn-default btn-xs btn-detail" id="<?php echo $p->idpedido; ?>"><i class="fa fa-list"></i> Detalles</a></td>
                            <?php endif; ?>
                            <td><?php echo $p->getClient()->name; ?></td>
                            <td>$ <?php echo number_format($p->cantidad,2,".",","); $total += $p->cantidad; ?></td>                            
                            <td><?php echo date("d/m/Y", strtotime($p->fecha)); ?></td>
                            <td><?php echo $p->getComprobante()->nombre; ?></td>
                            <td><?php echo $p->numerocomprobante; ?></td>
                            <td>
                                <?php
                                    $usuario = $p->getUser();
                                    if ($usuario->idempleado == null){
                                        echo $usuario->fullname;
                                    }else{
                                        $empleado = $p->getUser()->getEmpleado();
                                        echo $empleado->nombrecompleto;
                                    }
                                ?>
                            </td>
                            <td style="width: 40px;">
                                <a class="btn btn-default btn-xs" href="report/facturas/<?php echo $comprobante.".php?id=".$p->id."&abono"; ?>"><i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(!$todos): ?>
                <h2>Total: <strong>$ <?php echo number_format($total,2,".",","); ?></strong></h2>
                <?php endif; ?>
            </div>
            <?php if ($idPedido == ""): ?>
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
        </div>
        <?php else: ?>
        <div class="alert alert-warning">
            No se han reaizado pagos.
        </div>
        <?php endif; ?>
    </div>
</div>