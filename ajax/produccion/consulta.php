<!-- Este archivo sirve para obtener los datos generales de las producciones activas y las terminadas -->
<?php

	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ProduccionData.php");
    include ("../../core/modules/sistema/model/ProduccionMPData.php");

    $prodxs = false; #Verificar si hay producciones registradas
    $prodxsA = false; #Verificar si hay producciones activas
    $prodxsT = false; #Verificar si hay producciones terminadas
    
    $productns = ProduccionData::getAll();
    if (count($productns)>0) {
        $prodxs = true;
    }
    $productnsT = ProduccionData::getFinished();
    if (count($productnsT)>0) {
        $prodxsT = true;
    }
    $productnsA = ProduccionData::getActive();
    if (count($productnsA)>0) {
        $prodxsA = true;
    }

    $matp = MateriaPrimaData::getAll();
    $prods = ProductData::getAll();
    
?>
    <?php include "detallesError.php"; ?>
    <script src="js/bootstrap-confirmation.js"></script>
    <?php if (count($matp)>0 && count($prods)>0): ?>
		<script type="text/javascript">
			var btn = '<div class="btn-group pull-right"><a href="index.php?view=newproducn" class="btn btn-default"><i class="icon-plus"></i> Agregar a producción</a></div>';
			$(function(){
				$("#btnAdd").html(btn);
			});
		</script>
    <?php endif; ?>

    <?php if ($prodxs): ?>
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
        ?>
        <ul class="nav nav-tabs">
            <li class="active"><a href="#process">En proceso</a></li>
            <li><a href="#end">Terminado</a></li>
        </ul>
        <div class="tab-content">
            <div id="process" class="tab-pane fade in active">
                <h2>Producciones en proceso</h2>
                <?php
                if ($prodxsA):
                    $paginas = floor(count($productnsA)/$limit);
                    $spaginas = count($productnsA)%$limit;
                    if($spaginas>0){$paginas++;}
                    $productnsA = ProduccionData::getActiveByPage($start,$limit);
                ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <th></th>
                            <th>ID.</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th style="width: 50px;"></th>
                        </thead>
                        <tbody>
                            <?php foreach ($productnsA as $pa): ?>
                            <tr>
                                <td style="width:40px;"><a href="index.php?view=oneprod&id=<?php echo $pa->id; ?>" class="btn btn-default btn-xs"><i class="fa fa-eye" title="Detalles"></i></a></td>
                                <td><?php echo $pa->id;; ?></td>
                                <td><?php echo $pa->getProduct()->nombre; ?></td>
                                <td><?php echo $pa->cantidad; ?></td>
                                <td><?php echo $pa->fechainicio; ?></td>
                                <td><?php echo $pa->fechafin; ?></td>
                                <td>
                                    <a href=""></a>
                                    <a title="Finalizar" href="#" class="btn btn-xs btn-success finalizar" id="<?php echo $pa->id; ?>"
                                        data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                        data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
                                        data-btn-ok-class="btn-success btn-xs"
                                        data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                        data-btn-cancel-class="btn-danger btn-xs"
                                        data-title="¿Finalizar?">
                                        <i class="fa fa-check"></i>
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
                                $prev = "?start=".($start-$limit)."&limit=".$limit;
                            }
                            ?>
                            <li class="previous"><a class="pag" href="ajax/produccion/consulta.php<?php echo $prev; ?>">&laquo;</a></li>
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
                                <a class="pag" href="ajax/produccion/consulta.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
                            <li class="previous"><a class="pag" href="ajax/produccion/consulta.php<?php echo $next; ?>">&raquo;</a></li>
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
                        Vaya! No hay producciones en proceso.
                    </div>
                <?php endif; ?>
            </div>

            <div id="end" class="tab-pane fade">
                <h2>Producciones finalizadas</h2>
                <?php if ($prodxsT): ?>
                <?php
                    $paginas = floor(count($productnsT)/$limit);
                    $spaginas = count($productnsT)%$limit;
                    if($spaginas>0){$paginas++;}
                    $productnsT = ProduccionData::getFinishedByPage($start,$limit);
                ?>
                <div id="resultadoFinished">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID.</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Finalizado</th>
                                </tr>
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
                </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No hay producciones terminadas.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>

        <div class="alert alert-warning">
            ¡Vaya! Aún no se han registrado producciones.
        </div>
      
        <?php if (count($matp) <= 0 && count($prods) <= 0): ?>
        
            <div class="alert alert-warning">
                Para registrar una producci&oacute;n debe haber <a href="index.php?view=products">productos</a> y <a href="index.php?view=inventarymp">materia</a> prima en el sistema.
            </div>
		
        <?php elseif(count($matp) <= 0): ?>
			
            <div class="alert alert-warning">
                Para registrar una producci&oacute;n debe haber materia prima. <a href="index.php?view=inventarymp">Ir a materia prima.</a>
            </div>
		
        <?php elseif(count($prods) <= 0): ?>
			<div class="alert alert-warning">
                Para registrar una producci&oacute;n debe haber productos en el sistema. <a href="index.php?view=products">Ir a productos.</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
	<script>
        //Cambiar de tab
		$(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });
    
        //No modificar, le dan la funcionalidad a el piput de confirmación
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

		function finalizar(id){
			$.ajax({
				url: "ajax/produccion/procesos.php",
				type: "POST",
				dataType: "html",
				data: {
					idFin: id
				}
			}).done(function(res){
        if (res != ""){
          $("#detallesMP").html(res); //Cargar los detalles de la materia prima insuficiente
          $("#detalles").modal().show(); //Mostrar el modal
        }else{
          producciones("end"); //Todo está bien, se finaliza la producción
        }
			});
		}

		$(".finalizar").on("confirmed.bs.confirmation",function(){
			var id = this.id;
			finalizar(id);
		});

	</script>
