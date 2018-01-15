<?php

    @session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/AbonoData.php");
    include ("../../core/modules/sistema/model/ComprobanteData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");

    $idSuc = $_SESSION["usr_suc"];

    if (isset($_REQUEST["sucursal"]) && !empty($_REQUEST["sucursal"])){
        $idSuc = $_REQUEST["sucursal"];
    }

    $total = 0;
    $pagos = AbonoData::getAllBySuc($idSuc);

    if (count($pagos) > 0):
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
?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width="100px">Pedido</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Tipo Comprobante</th>
                        <th>No. Comprobante</th>
                        <th>Recibido Por</th>
                        <th width="40px"></th>
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
                        <td><a data-toggle="modal" data-target="#detalleP" class="btn btn-default btn-xs btn-detail" id="<?php echo $p->idpedido; ?>"><i class="fa fa-list"></i> Detalles</a></td>
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
                        <td>
                            <a class="btn btn-default btn-xs" href="report/facturas/<?php echo $comprobante.".php?id=".$p->id."&abono"; ?>"><i class="fa fa-download"></i></a>
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
						$prev = "?start=".($start-$limit)."&limit=".$limit;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/pagos/resultadoSucursal.php<?php echo $prev; ?>">&laquo;</a></li>
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
						<a class="pag" href="ajax/pagos/resultadoSucursal.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
				<li class="previous"><a class="pag" href="ajax/pagos/resultadoSucursal.php<?php echo $next; ?>">&raquo;</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<script>
			$(".pag").on("click", function(){
				$.ajax({
					url: $(this).attr("href"),
					type: "GET",
					data: {sucursal: <?php echo $idSuc; ?>},
					success: function(res){
						$("#resultado").html(res);
					}
				});
				return false;
            });
            
            $(".btn-detail").on("click",function(){
                id = this.id;
                $.ajax({
                    url: "ajax/pagos/detallePedido.php",
                    type: "POST",
                    dataType: "html",
                    data: {id: id},
                    success: function(data){
                        $("#detalles").html(data);
                    }
                });
            });
		</script>
    <?php else: ?>
    <div class="alert alert-warning">
        No se han reaizado pagos en esta sucursal.
    </div>
    <?php endif; ?>