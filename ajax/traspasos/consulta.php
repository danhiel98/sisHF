<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/TraspasoData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    include ("../../core/modules/sistema/model/UserData.php");

    $idSuc = $_SESSION["usr_suc"];
    $trasp = new TraspasoData();

    $traspasos = $trasp->getAllBySuc($idSuc);
	$realizados = $trasp->getAllSends($idSuc);
	$recibidos = $trasp->getAllReceived($idSuc);
?>
    <?php if(count($traspasos) > 0): ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#realizado">Realizados</a></li>
            <li><a href="#recibido" id="recibidos">Recibidos</a></li>
        </ul>
        <div class="tab-content">
            <div id="realizado" class="tab-pane fade in active">
                <h2>Traspasos Enviados</h2>
                <?php
                if (count($realizados) > 0):
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
                    $realizados = TraspasoData::getAllSendsPage($idSuc,$start,$limit);
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
                                    <th style="width: 40px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($realizados as $t): ?>
                                <tr>
                                    <td style="width:30px;">
                                        <a href="index.php?view=tradex&id=<?php echo $t->id; ?>" title="Detalles de traspaso" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a>
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
                                    <td>
                                        <a title="¿Eliminar?" href="index.php?view=deltrasp&id=<?php echo $t->id;?>" class="btn btn-danger btn-xs"
                                        data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                        data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                        data-btn-ok-class="btn-success btn-xs"
                                        data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                        data-btn-cancel-class="btn-danger btn-xs">
                                            <i class="fa fa-trash fa-fw"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pull-right">
                        <ul class="pagination">
                            <?php if($start != 1):
                                $prev = "#";
                                if($start != 1){
                                    $prev = "?start=".($start-$limit)."&limit=".$limit;
                                }
                            ?>
                                <li class="previous"><a class="pag" href="ajax/traspasos/consulta.php<?php echo $prev; ?>">&laquo;</a></li>
                            <?php endif;
                                $anterior = 1;
                                for($i=1; $i<=$paginas; $i++):
                                    $inicio = 1;
                                    if ($i != 1){
                                        $inicio = $limit + $anterior;
                                        $anterior = $inicio;
                                    }
                                ?>
                                <li <?php if($start == $inicio){echo "class='active'";} ?>>
                                    <a class="pag" href="ajax/traspasos/consulta.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php
                                endfor;
                                if($start != $anterior):
                                    $next = "#";
                                    if($start != $anterior){
                                        $next = "?start=".($start + $limit)."&limit=".$limit;
                                    }
                                ?>
                                <li class="previous"><a class="pag" href="ajax/traspasos/consulta.php<?php echo $next; ?>">&raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <script>
                        $(".pag").on("click", function(){
                            $.ajax({
                                url: $(this).attr("href"),
                                type: "GET",
                                success: function(res){
                                    $("#resultado").html(res);
                                }
                            });
                            return false;
                        });
                    </script>
                <?php else: ?>
                    <div class="alert alert-warning">
                        ¡Vaya! Aún no se han enviado productos desde esta sucursal.
                    </div>
                <?php endif; ?>
            </div>
            <div id="recibido" class="tab-pane">
                <h2>Traspasos Recibidos</h2>
                <?php
                if (count($recibidos) > 0):
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
                    <div id="resultadoR">
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
                                        <th style="width: 40px;"></th>
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
                                        <td>
                                            <a title="¿Eliminar?" href="index.php?view=deltrasp&id=<?php echo $t->id;?>" class="btn btn-danger btn-xs"
                                            data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                            data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                            data-btn-ok-class="btn-success btn-xs"
                                            data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                            data-btn-cancel-class="btn-danger btn-xs">
                                                <i class="fa fa-trash fa-fw"></i>
                                            </a>
                                        </td>
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
                                        $("#resultadoEntregado").html(res);
                                    }
                                });
                                return false;
                            });
                        </script>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        ¡Vaya! Aún no se han enviado productos desde esta sucursal.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $(".nav-tabs a").click(function(){
                    $(this).tab('show');
                });
            });

            $('[data-toggle=confirmation]').confirmation({
                rootSelector: '[data-toggle=confirmation]',
                container: 'body'});
            $('[data-toggle=confirmation-singleton]').confirmation({
                rootSelector: '[data-toggle=confirmation-singleton]',
                container: 'body'});
            $('[data-toggle=confirmation-popout]').confirmation({
                rootSelector: '[data-toggle=confirmation-popout]',
                container: 'body'});
            $('#confirmation-delegate').confirmation({
                selector: 'button'
            });

            vHash = window.location.hash;
            if (vHash == "#recibido"){
                $("#recibidos").tab("show");
            }

        </script>
    <?php else: ?>
        <div class="jumbotron">
            <div class="container">
                <?php if ($sucs): ?>
                    <h2>No se han registrado traspasos</h2>
                    <?php if(count($prodSuc) > 0): ?>
                    Puede registrar uno dando clic en el boton <b>"Registrar Traspaso"</b>
                    <?php else: ?>
                    No hay <a href="index.php?view=inventaryprod">productos</a> disponibles para realizar el traspaso.
                    <?php endif; ?>
                <?php else: ?>
                    <h2>No se pueden registrar traspasos</h2>
                    <?php if(count($sucursales) < 2): ?>
                    Para ello debe haber m&aacute;s de una sucursal registradas.
                    <a href="index.php?view=sucursal">Ir a sucursales</a>
                    <?php else: ?>
                    Para realizar traspasos a otra sucursal debe haber al menos un <a href="index.php?view=users">usuario</a> registrado en la sucursal de destino.
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>