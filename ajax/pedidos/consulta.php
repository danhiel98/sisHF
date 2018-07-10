<?php
    
    @session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ProductoSucursalData.php");
    include ("../../core/modules/sistema/model/ServiceData.php");
    include ("../../core/modules/sistema/model/DireccionData.php");

    #Variables booleanas que sirven para determinar que tipo de consulta se ha realizado.
    #Ej. Se quieren ver todos los datos, solamente los pedidos entregados o solamente los pendientes
    $pdids = false; #Todos los pedidos
    $pdidsT = false; #Entregados
    $pdidsA = false; #Pendientes

    $idSuc = $_SESSION["usr_suc"];
    $suc = false;
    $actualSuc = false;

    if (isset($_REQUEST["sucursal"]) && !empty($_REQUEST["sucursal"])){
        $idSuc = $_REQUEST["sucursal"];
        $suc = true;
    }
    
    if($idSuc == $_SESSION["usr_suc"]){
        $actualSuc = true;
    }

    $pedidos = PedidoData::getAllBySuc($idSuc);
    if (count($pedidos)>0) {
        $pdids = true;
    }
    $pedidosT = PedidoData::getEntregadoBySuc($idSuc);
    if (count($pedidosT)>0) {
        $pdidsT = true;
    }
    $pedidosA = PedidoData::getPendienteBySuc($idSuc);
    if (count($pedidosA)>0) {
        $pdidsA = true;
    }

    $clientes = ClientData::getAll();
    $productos = ProductoSucursalData::getAllForSell($idSuc);
    $servicios = ServiceData::getAll();
    
    $clients = false;
    $prods = false;
    $servs = false;

    $prodsMsg = "<a href='index.php?view=inventaryprod'>productos</a> o <a href='index.php?view=services'>servicios</a> disponibles";
    $clientsMsg = "<a href='index.php?view=clients'>clientes</a> registrados";

    if(count($clientes)>0){$clients = true;}
    if(count($productos)>0){$prods = true;}
    if(count($servicios)>0){$servs = true;}

    $end = false;
    if (isset($_POST["tab"]) && $_POST["tab"] == "end"){
        $end = true;
    }
    
    include "detallesError.php";
?>    
    
    <?php if (isset($_COOKIE["okPdido"]) && !empty($_COOKIE["okPdido"])): ?>
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["okPdido"]; ?></p>
        </div>
    <?php setcookie("okPdido","",time()-18600); endif; ?>

    <?php if (isset($_COOKIE["errorPdido"]) && !empty($_COOKIE["errorPdido"])): ?>
        <div class="alert alert-warning alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class='fa fa-info fa-fw'></i> <?php echo $_COOKIE["errorPdido"]; ?></p>
        </div>
    <?php setcookie("errorPdido","",time()-18600); endif; ?>
    
    <?php if ($pdids):
        $start = 1; $limit = 10;
        if(isset($_REQUEST["start"]) && isset($_REQUEST["limit"])){
            $start = $_REQUEST["start"];
            $limit = $_REQUEST["limit"];
            #Para evitar que se muestre un error, se valida que los valores enviados no sean negativos
            if ($start <= 0 ){
                $start = 1;
            }
            if ($limit <= 0 ){$limit = 1;}
        }
        $num = $start;
    ?>
    <ul class="nav nav-tabs">
        <li <?php if (!$end){ echo "class='active'"; } ?>><a href="#process">Pendientes</a></li>
        <li <?php if ($end){ echo "class='active'"; } ?>><a href="#end" id="entregado">Entregados</a></li>
    </ul>
    <div class="tab-content">
        <div id="process" class="tab-pane fade <?php if (!$end){ echo 'in active'; } ?>">
            <h2>Pedidos Pendientes</h2>
            <?php if ($pdidsA):
                include "../../core/modules/sistema/view/agregarPago.php";
                $paginas = floor(count($pedidosA)/$limit);
                $spaginas = count($pedidosA)%$limit;
                if($spaginas>0){$paginas++;}
                $pedidosA = PedidoData::getPendienteByPage($idSuc,$start,$limit);
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
                            <?php if($actualSuc): ?>
                            <th style="width: 80px;"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pedidosA as $pdo): ?>
                        <tr>
                            <td><a href="index.php?view=detallepedido&id=<?php echo $pdo->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $pdo->getClient()->name; ?></td>
                            <td><?php echo $pdo->fechapedido; ?></td>
                            <td><?php echo $pdo->fechaentrega; ?></td>
                            <?php if($actualSuc): ?>
                            <td>
                                <a title="Finalizar" href="#" class="btn btn-xs btn-success finalizar" id="<?php echo $pdo->id; ?>" data-opc="terminar" data-estado="pendiente"
                                    data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                    data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                    data-btn-ok-class="btn-success btn-xs"
                                    data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                    data-btn-cancel-class="btn-danger btn-xs"
                                    data-title="¿Finalizar?">
                                    <i class="fa fa-check"></i>
                                </a>
                                <a title="¿Eliminar?" href="#" class="btn btn-danger btn-xs finalizar" id="<?php echo $pdo->id; ?>" data-opc="eliminar" data-estado="pendiente"
                                    data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                    data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                    data-btn-ok-class="btn-success btn-xs"
                                    data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                    data-btn-cancel-class="btn-danger btn-xs">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                            </td>
                            <?php endif; ?>
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
                            $prev = "?start=".($start-$limit)."&limit=".$limit."&sucursal=".$idSuc;
                        }
                    ?>
                        <li class="previous"><a class="pag" href="ajax/pedidos/consulta.php<?php echo $prev; ?>">&laquo;</a></li>
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
                            <a class="pag" href="ajax/pedidos/consulta.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&sucursal=".$idSuc; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php
                        endfor;
                        
                        if($start != $anterior):
                            $next = "#";
                            if($start != $anterior){
                                $next = "?start=".($start + $limit)."&limit=".$limit."&sucursal=".$idSuc;
                            }
                        ?>
                        <li class="previous"><a class="pag" href="ajax/pedidos/consulta.php<?php echo $next; ?>">&raquo;</a></li>
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
        <div class="alert alert-info">
        !Vaya! No hay pedidos pendientes.
        </div>
        <?php endif; ?>
    </div>
    <div id="end" class="tab-pane fade <?php if ($end){ echo 'in active'; } ?>">
        <h2>Pedidos Entregados</h2>
        <?php if ($pdidsT): ?>
        <?php
            $paginas = floor(count($pedidosT)/$limit);
            $spaginas = count($pedidosT)%$limit;
            if($spaginas>0){$paginas++;}
            $pedidosT = PedidoData::getEntregadoByPage($idSuc,$start,$limit);
            $num = $start;
        ?>
        <div id="resultadoEntregado">
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
                            <?php if($actualSuc): ?>
                            <th style="width: 40px;"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pedidosT as $pdo): ?>
                        <tr>
                            <td><a href="index.php?view=detallepedido&id=<?php echo $pdo->id; ?>#end" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                            <td><?php echo $num++; ?></td>
                            <td><?php echo $pdo->getClient()->name; ?></td>
                            <td><?php echo $pdo->fechapedido; ?></td>
                            <td><?php echo $pdo->fechaentrega; ?></td>
                            <td><?php echo $pdo->fechafinalizado; ?></td>
                            <?php if($actualSuc): ?>
                            <td>
                                <a title="¿Eliminar?" href="#" class="btn btn-danger btn-xs finalizar" id="<?php echo $pdo->id; ?>" data-opc="eliminar" data-estado="entregado"
                                    data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                    data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                    data-btn-ok-class="btn-success btn-xs"
                                    data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                    data-btn-cancel-class="btn-danger btn-xs">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                            </td>
                            <?php endif; ?>
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
                            $prev = "?start=".($start-$limit)."&limit=".$limit."&sucursal=".$idSuc;
                        }
                        ?>
                        <li class="previous"><a class="pagF" href="ajax/pedidos/consultaFinished.php<?php echo $prev; ?>">&laquo;</a></li>
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
                        <a class="pagF" href="ajax/pedidos/consultaFinished.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&sucursal=".$idSuc; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <?php if($start != $anterior):
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
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            No hay pedidos entregados.
        </div>
        <?php endif; ?>
    </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning">
        !Vaya! Aún no se han realizado pedidos<?php if ($suc): ?> en esta sucursal<?php endif; ?>.
    </div>
    <?php if ((!$servs && !$prods) || !$clients): ?>
        <div class="alert alert-warning">
            <p>Para poder realizar pedidos debe haber <?php if(!$prods && !$servs){echo $prodsMsg;} if(!$prods && !$clients){echo " y ";} if(!$clients){echo $clientsMsg;} ?> en el sistema.</p>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <script>
    
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body'
        });
        $('[data-toggle=confirmation-singleton]').confirmation({
            rootSelector: '[data-toggle=confirmation-singleton]',
            container: 'body'
        });
        $('[data-toggle=confirmation-popout]').confirmation({
            rootSelector: '[data-toggle=confirmation-popout]',
            container: 'body'
        });
        $('#confirmation-delegate').confirmation({
            selector: 'button'
        });

        function finalizar(id,opc,est){
            $.ajax({
                url: "ajax/pedidos/procesos.php",
                type: "POST",
                dataType: "html",
                data: {
                    idFin: id,
                    option: opc,
                    status: est
                }
            }).done(function(res){
                var detalleProds = $("#detallesProd");
                var detalles = $("#detalles");
                //Esta función se encarga de obtener todos los datos de los pedidos, se encuentra en el archivo ajax.js
                if (res != ""){
                    detalleProds.html(res); //Cargar los detalles de la materia prima insuficiente
                    detalles.modal().show(); //Mostrar el modal
                }else{
                    if(opc == "terminar"){
                        pedidos("end");
                    }else{
                        pedidos();
                    }
                }
            });
        }

        $(".finalizar").on("confirmed.bs.confirmation",function(){
            var id = this.id;
            var opc = $(this).data("opc");
            var est = $(this).data("estado");
			finalizar(id,opc,est);
        });

        vHash = window.location.hash;
        if (vHash == "#end"){
            $("#entregado").tab("show");
        }

        $.getScript("js/bootstrap-confirmation.js");

    </script>