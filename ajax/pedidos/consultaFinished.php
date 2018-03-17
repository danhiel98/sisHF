<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/PedidoData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	include ("../../core/modules/sistema/model/ProductData.php");

    $idSuc = $_SESSION["usr_suc"];

    if (isset($_REQUEST["sucursal"]) && !empty($_REQUEST["sucursal"])){
		$idSuc = $_REQUEST["sucursal"];
	}

    $pedidosT = PedidoData::getEntregadoBySuc($idSuc);
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
    $paginas = floor(count($pedidosT)/$limit);
    $spaginas = count($pedidosT)%$limit;
    if($spaginas>0){$paginas++;}
    $pedidosT = PedidoData::getEntregadoByPage($idSuc,$start,$limit);

?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th style="width: 45px;"></th>
                    <th style="width: 45px;">No.</th>
                    <th>Cliente</th>
                    <th>Fecha de Solicitud</th>
                    <th>Fecha de Entrega</th>
                    <th>Fecha Entregado</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pedidosT as $pdo): ?>
                <tr>
                    <td><a href="index.php?view=detallepedido&id=<?php echo $pdo->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                    <td><?php echo $pdo->id; ?></td>
                    <td><?php echo $pdo->getClient()->name; ?></td>
                    <td><?php echo $pdo->fechapedido; ?></td>
                    <td><?php echo $pdo->fechaentrega; ?></td>
                    <td><?php echo $pdo->fechafinalizado; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pull-right">
        <ul class="pagination">
            <?php if($start != 1):?>
                <?php
                $prev = "#";
                if($start != 1){
                    $prev = "?start=".($start-$limit)."&limit=".$limit."&sucursal=".$idSuc;
                }
                ?>
                <li class="previous"><a class="pagF" href="ajax/pedidos/consultaFinished.php<?php echo $prev; ?>">&laquo;</a></li>
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
                    <a class="pagF" href="ajax/pedidos/consultaFinished.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&sucursal=".$idSuc; ?>"><?php echo $i; ?></a>
                </li>
                <?php
                endfor;
                ?>
                <?php if($start != $anterior): ?>
                <?php 
                $next = "#";
                if($start != $anterior){
                    $next = "?start=".($start + $limit)."&limit=".$limit."&sucursal=".$idSuc;
                }
                ?>
                <li class="previous"><a class="pagF" href="ajax/pedidos/consultaFinished.php<?php echo $next; ?>">&raquo;</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <script>
        $(".pagF").on("click", function(){
            $.ajax({
                url: $(this).attr("href"),
                type: "GET",
                success: function(res){
                    $("#resultadoEntregado").html(res);
                }
            });
            return false;
        });
    </script>