<?php

	@session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/ProductoSucursalData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/TraspasoData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    include ("../../core/modules/sistema/model/UserData.php");

    $idSuc = $_SESSION["usr_suc"];
    $trasp = new TraspasoData();
    $realizados = $trasp->getAllSends($idSuc);

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
    $paginas = floor(count($realizados)/$limit);
    $spaginas = count($realizados)%$limit;
    if($spaginas>0){$paginas++;}
    $realizados = TraspasoData::getAllReceivedPage($idSuc,$start,$limit);
    $num = $start;

?>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th></th>
                <th style="width: 50px;">No.</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Registrado Por</th>
                <!-- <th style="width: 40px;"></th> -->
            </tr>
        </thead>
        <tbody>
        <?php foreach($realizados as $t): ?>
            <tr>
                <td style="width:30px;">
                    <a href="index.php?view=tradex&id=<?php echo $t->id; ?>#recibido" title="Detalles de traspaso" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
                </td>
                <td><?php echo $num++; ?></td>
                <td>
                    <?php echo $t->getSucursalO()->nombre; ?>
                </td>
                <td>
                    <?php echo $t->getSucursalD()->nombre; ?>
                </td>
                <td><?php echo $t->fecha; ?></td>
                <td><?php if(!is_null($t->getUser()->idempleado)){echo $t->getUser()->getEmpleado()->nombrecompleto;}else{echo $t->getUser()->fullname;}?></td>
                <!-- <td>
                    <a title="¿Eliminar?" href="index.php?view=deltrasp&id=<?php echo $t->id;?>" class="btn btn-danger btn-xs"
                    data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                    data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                    data-btn-ok-class="btn-success btn-xs"
                    data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                    data-btn-cancel-class="btn-danger btn-xs">
                        <i class="fa fa-trash fa-fw"></i>
                    </a>
                </td> -->
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
                $prev = "?start=".($start-$limit)."&limit=";
            }
            ?>
            <li class="previous"><a class="pagF" href="ajax/traspasos/consultaR.php<?php echo $prev; ?>">&laquo;</a></li>
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
                <a class="pagF" href="ajax/traspasos/consultaR.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&sucursal=".$idSuc; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor;
            if($start != $anterior):
                $next = "#";
                if($start != $anterior){
                    $next = "?start=".($start + $limit)."&limit=".$limit."&sucursal=".$idSuc;
                }
            ?>
            <li class="previous"><a class="pagF" href="ajax/traspasos/consultaR.php<?php echo $next; ?>">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</div>
<script>
    $(".pagF").on("click", function(){
        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            success: function(res){
                $("#resultadoR").html(res);
            }
        });
        return false;
    });
</script>