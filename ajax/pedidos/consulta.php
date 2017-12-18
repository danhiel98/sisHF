<?php
    
    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/PedidoData.php");
	include ("../../core/modules/sistema/model/ClientData.php");
	include ("../../core/modules/sistema/model/ProductData.php");

  #Variables booleanas que sirven para determinar que tipo de consulta se ha realizado.
  #Ej. Se quieren ver todos los datos, solamente los pedidos entregados o solamente los pendientes
  $pdids = false; #Todos los pedidos
  $pdidsT = false; #Entregados
  $pdidsA = false; #Pendientes

  $pedidos = PedidoData::getAll();
  if (count($pedidos)>0) {
    $pdids = true;
  }
  $pedidosT = PedidoData::getEntregado();
  if (count($pedidosT)>0) {
    $pdidsT = true;
  }
  $pedidosA = PedidoData::getPendiente();
  if (count($pedidosA)>0) {
    $id = 0; #Sirve para que no de error al obtener el id de pedido
    include "../../core/modules/sistema/view/agregarPago.php";
    $pdidsA = true;
  }

  $clientes = ClientData::getAll();
  $prods = ProductData::getAll();
  
?>
  <?php include "detallesError.php"; ?>
	<script src="js/bootstrap-confirmation.js"></script>
  <?php if ($pdids): ?>
    <?php 
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
    ?>
  	<ul class="nav nav-tabs">
      <li class="active"><a href="#process">Pendientes</a></li>
      <li><a href="#end">Entregados</a></li>
    </ul>
    <div class="tab-content">
      <div id="process" class="tab-pane fade in active">
        <h2>Pedidos Pendientes</h2>
        <?php if ($pdidsA): ?>
        <?php 
            $paginas = floor(count($pedidosA)/$limit);
            $spaginas = count($pedidosA)%$limit;
            if($spaginas>0){$paginas++;}
            $pedidosA = PedidoData::getPendienteByPage($start,$limit);
        ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered">
            <thead>
              <th style="width: 45px;"></th>
              <th style="width: 45px;">No.</th>
              <th>Cliente</th>
              <th>Fecha de Solicitud</th>
              <th>Fecha de Entrega</th>
              <th style="width: 50px;"></th>
            </thead>
            <tbody>
              <?php foreach ($pedidosA as $pdo): ?>
                <tr>
                  <td><a href="index.php?view=detallepedido&id=<?php echo $pdo->id; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                  <td><?php echo $pdo->id; ?></td>
                  <td><?php echo $pdo->getClient()->name." ".$pdo->getClient()->lastname; ?></td>
                  <td><?php echo $pdo->fechapedido; ?></td>
                  <td><?php echo $pdo->fechaentrega; ?></td>
                  <td>
                    <a title="Finalizar" href="#" class="btn btn-xs btn-success finalizar" id="<?php echo $pdo->id; ?>"
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
                    <li class="previous"><a class="pag" href="ajax/pedidos/consulta.php<?php echo $prev; ?>">&laquo;</a></li>
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
                        <a class="pag" href="ajax/pedidos/consulta.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
          Vaya! No hay pedidos pendientes.
        </div>
        <?php endif; ?>
      </div>
      <div id="end" class="tab-pane fade">
        <h2>Pedidos Entregados</h2>
        <?php if ($pdidsT): ?>
        <?php
            $paginas = floor(count($pedidosT)/$limit);
            $spaginas = count($pedidosT)%$limit;
            if($spaginas>0){$paginas++;}
            $pedidosT = PedidoData::getEntregadoByPage($start,$limit);
        ?>
        <div id="resultadoEntregado">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <th style="width: 45px;"></th>
                        <th style="width: 45px;">No.</th>
                        <th>Cliente</th>
                        <th>Fecha de Solicitud</th>
                        <th>Fecha de Entrega</th>
                        <th>Fecha Entregado</th>
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
                            $prev = "?start=".($start-$limit)."&limit=".$limit;
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
                            <a class="pagF" href="ajax/pedidos/consultaFinished.php?start=<?php echo $inicio; ?>&limit=<?php echo $limit; ?>"><?php echo $i; ?></a>
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
      <div class="alert alert-info" style="font-size: 1.2em;">
        No hay datos.
      </div>
      <?php if (count($clientes) <= 0 && count($prods) <= 0): ?>
        <div class="alert alert-warning">
          Para registrar un pedido debe haber <a href="index.php?view=products">productos</a> y <a href="index.php?view=clients">clientes</a> registrados en el sistema.
        </div>
			<?php elseif(count($clientes) <= 0): ?>
				<div class="alert alert-warning">
          Para registrar un pedido debe haber clientes registrados. <a href="index.php?view=clients">Ir a clientes.</a>
        </div>
			<?php elseif(count($prods) <= 0): ?>
				<div class="alert alert-warning">
          Para registrar un pedido debe haber productos en el sistema. <a href="index.php?view=products">Ir a productos.</a>
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
        url: "ajax/pedidos/procesos.php",
        type: "POST",
        dataType: "html",
        data: {
          idFin: id
        }
      }).done(function(res){
        //Esta función se encarga de obtenes todos los datos de los pedidos, se encuentra en el archivo ajax.js
        if (res != ""){
          $("#detallesProd").html(res); //Cargar los detalles de la materia prima insuficiente
          $("#detalles").modal().show(); //Mostrar el modal
        }else{
          pedidos("end"); //Creo que ya no la utilizo para nada xD
        }
      });
    }

    //Al dar clic en "Sí" en el popup de confirmación
    $(".finalizar").on("confirmed.bs.confirmation",function(){
      var id = this.id;
      finalizar(id);
    });

	</script>
