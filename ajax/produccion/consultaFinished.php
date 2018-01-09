<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ProduccionData.php");
    include ("../../core/modules/sistema/model/ProduccionMPData.php");

    $productnsT = ProduccionData::getFinished();
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
    $paginas = floor(count($productnsT)/$limit);
    $spaginas = count($productnsT)%$limit;
    if($spaginas>0){$paginas++;}
    $productnsT = ProduccionData::getFinishedByPage($start,$limit);

?>
    <table class="table table-hover table-bordered">
        <thead>
        <th></th>
        <th>No.</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Fecha Inicio</th>
        <th>Fecha Fin</th>
        <th>Finalizado</th>
        </thead>
        <tbody>
        <?php foreach ($productnsT as $pt): ?>
            <tr>
            <td style="width:40px;"><a href="index.php?view=oneprod&id=<?php echo $pt->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" title="Detalles"></i></a></td>
            <td><?php echo $pt->id; ?></td>
            <td><?php echo $pt->getProduct()->nombre; ?></td>
            <td><?php echo $pt->cantidad; ?></td>
            <td><?php echo $pt->fechainicio; ?></td>
            <td><?php echo $pt->fechafin; ?></td>
            <td><?php echo $pt->fechafinalizado; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pull-right">
        <ul class="pagination">
            <?php if($start != 1):?>
                <?php
                $prev = "#";
                if($start != 1){
                    $prev = "?start=".($start-$limit)."&limit=".$limit;
                }
                ?>
                <li class="previous"><a class="pagF" href="ajax/produccion/consultaFinished.php<?php echo $prev; ?>">&laquo;</a></li>
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
                    <a class="pagF" href="ajax/produccion/consultaFinished.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
                </li>
                <?php
                endfor;
                ?>
                <?php if($start != $anterior): ?>
                <?php 
                $next = "#";
                if($start != $anterior){
                    $next = "?start=".($start + $limit)."&limit=".$limit;
                }
                ?>
                <li class="previous"><a class="pagF" href="ajax/produccion/consultaFinished.php<?php echo $next; ?>">&raquo;</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <script>
        $(".pagF").on("click", function(){
            $.ajax({
                url: $(this).attr("href"),
                type: "GET",
                success: function(res){
                    $("#resultadoFinished").html(res);
                }
            });
            return false;
        });
    </script>