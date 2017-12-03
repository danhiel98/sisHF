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
    $pdidsA = true;
  }

  $clientes = ClientData::getAll();
  $prods = ProductData::getAll();
  
?>
  <?php include "detallesError.php"; ?>
	<script src="js/bootstrap-confirmation.js"></script>
  <?php if ($pdids): ?>
  	<ul class="nav nav-tabs">
      <li class="active"><a href="#process">Pendientes</a></li>
      <li><a href="#end">Entregados</a></li>
    </ul>
    <div class="tab-content">
      <div id="process" class="tab-pane fade in active">
        <h2>Pedidos Pendientes</h2>
        <?php if ($pdidsA): ?>
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
                  <td><?php echo $pdo->getClient()->name; ?></td>
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
        <?php else: ?>
        <div class="alert alert-info">
          Vaya! No hay pedidos pendientes.
        </div>
        <?php endif; ?>
      </div>
      <div id="end" class="tab-pane fade">
        <h2>Producciones finalizadas</h2>
        <?php if ($pdidsT): ?>
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
      }).done(function(){
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
