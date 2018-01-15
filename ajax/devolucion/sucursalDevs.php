<?php 
    
    @session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/CausaDevolucionData.php");
	include ("../../core/modules/sistema/model/DevolucionData.php");
    include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    
    $idSuc = $_REQUEST["id"];
    $devs = DevolucionData::getAllBySuc($idSuc);

    $sucActual = false;

    if($idSuc == $_SESSION["usr_suc"]){
        $sucActual = true;
    }

?>
<?php if (count($devs) > 0): ?>
    <?php
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
        $paginas = floor(count($devs)/$limit);
        $spaginas = count($devs)%$limit;
        if($spaginas>0){$paginas++;}
        $devs = DevolucionData::getByPage($idSuc,$start,$limit);
        $count = $start;
    ?>
    <div id="resultado">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <th></th>
                    <th>No.</th>
                    <th style="width: 140px;">No. Comprobante</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                    <th>Reembolso</th>
                    <th>Registrado Por</th>
                    <?php if($sucActual): ?>
                    <th></th>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php foreach ($devs as $dev): ?>
                        <tr>
                            <td style="width: 40px;"><a class="btn btn-default btn-xs" href="index.php?view=detalledev&id=<?php echo $dev->id."&num=".$count; ?>"><i class="fa fa-eye"></i></a></td>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $dev->getFactura()->numerofactura; ?></td>
                            <td><?php echo $dev->getCausa()->descripcion; ?></td>
                            <td><?php echo $dev->fecha; ?></td>
                            <td>$ <?php echo $dev->reembolso; ?></td>
                            <td><?php echo $dev->getUser()->name." ".$dev->getUser()->lastname; ?></td>
                            <?php if($sucActual): ?>
                            <td style="width:40px;">
                                <a title="¿Eliminar?" href="index.php?view=deldev&id=<?php echo $dev->id;?>" class="btn btn-danger btn-xs"
                                data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                data-btn-ok-class="btn-success btn-xs"
                                data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                data-btn-cancel-class="btn-danger btn-xs"
                                >
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
				<?php if($start != 1):?>
				<?php
					$prev = "#";
					if($start != 1){
						$prev = "?start=".($start-$limit)."&limit=".$limit."&id=".$idSuc;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/devolucion/sucursalDevs.php<?php echo $prev; ?>">&laquo;</a></li>
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
						<a class="pag" href="ajax/devolucion/sucursalDevs.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit."&id=".$idSuc; ?>"><?php echo $i; ?></a>
					</li>
					<?php
					endfor;
				?>
				<?php if($start != $anterior): ?>
				<?php 
					$next = "#";
					if($start != $anterior){
						$next = "?start=".($start + $limit)."&limit=".$limit."&id=".$idSuc;
					}
				?>
				<li class="previous"><a class="pag" href="ajax/devolucion/sucursalDevs.php<?php echo $next; ?>">&raquo;</a></li>
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
    </div>
<?php else: ?>
    <div class="clearfix"></div>
    <div class="alert alert-warning">
        ¡Vaya! Aún no no se han realizado devoluciones en esta sucursal.
    </div>
<?php endif; ?>