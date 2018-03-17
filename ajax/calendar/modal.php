<?php

    @session_start();
	include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/MantenimientoData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include ("../../core/modules/sistema/model/UserData.php");
    include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/PedidoData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/SucursalData.php");

    if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
        error();
    }
        
    $id = $_GET["id"];
    $mantto = MantenimientoData::getById($id);
    if(!$mantto){
        error();
    }

    $operacion = null; #Para saber si es pedido o venta
    $nombreOperacion = "";
    $enlaceOperacion = "";
    
    //Si ambos tienen un valor nulo
    if($mantto->idpedido == null && $mantto->idfactura == null){
        error();
    //Si ambos tienen un id
    }elseif($mantto->idpedido != null && $mantto->idfactura != null){
        error();
    }else{
        if($mantto->idfactura != null){
            $operacion = $mantto->getFactura();
            $nombreOperacion = "Factura";
            $enlaceOperacion = "index.php?view=onesell&id=$mantto->idfactura";
        }elseif($mantto->idpedido != null){
            $operacion = $mantto->getPedido();
            $nombreOperacion = "Pedido";
            $enlaceOperacion = "index.php?view=detallepedido&id=$mantto->idpedido";
        }
    }

    $idSuc = $operacion->idsucursal;
    $sucursal = SucursalData::getById($idSuc);

    $class = "warning";
    $classR = "success";
    $estado = "Pendiente";
    $estadoR = "Realizado";
    $icon = "check";
    if($mantto->realizado == 1){
        $estado = "Realizado";
        $estadoR = "Pendiente";
        $class = "success";
        $classR = "warning";
        $icon = "times";
    }
    $fecha = new DateTime($mantto->start);
?>
<div class="pull-right">
    <h2>
        <span class="label label-<?php echo $class; ?>"><?php echo $estado; ?></span>
    </h2>
</div>
<h3><strong><?php echo $fecha->format("d-m-Y"); ?></strong></h3>
<h3><strong><span class="label label-info"><?php echo $sucursal->nombre; ?></span></strong></h3>
<h3><strong><?php echo $mantto->title; ?></strong></h3>
<div class="form-group col-md-12">
    <a target="_blank" href="<?php echo $enlaceOperacion; ?>">Ver <?php echo $nombreOperacion; ?></a>
</div>
<div class="form-group col-md-12">
    <strong>Cliente:</strong> <?php echo $operacion->getClient()->name; ?>
</div>
<div class="form-group col-md-12">
    <strong>Dirección:</strong> <?php echo $operacion->getClient()->direccion; ?>
</div>
<div class="form-group col-md-12">
    <strong>Teléfono:</strong> <?php echo $operacion->getClient()->phone; ?>
</div>
<?php if($mantto->realizado == 1): ?>
<div class="form-group col-md-12">
    <strong>Fecha Realizado:</strong> <?php echo $mantto->fecharealizado; ?>
</div>
<?php endif; ?>
<div class="form-group col-md-12">
    <div class="pull-right">
        <a title="¿Cambiar a <?php echo $estadoR; ?>?" href="ajax/calendar/cambiarEstado.php" data-id="<?php echo $mantto->id; ?>" class="btn btn-<?php echo $classR; ?> btn-sm estado"
            data-toggle="confirmation-popout" data-popout="true" data-placement="left"
            data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-check fa-fw"
            data-btn-ok-class="btn-success btn-xs"
            data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
            data-btn-cancel-class="btn-danger btn-xs"
            >
            <i class="fa fa-<?php echo $icon; ?> fa-fw"></i>
        </a>
    </div>
</div>
<script>
    $.getScript("js/bootstrap-confirmation.js");
    
     $('[data-toggle=confirmation-popout]').confirmation(
        {
            rootSelector: '[data-toggle=confirmation-popout]',
            container: 'body',
            onConfirm: function() {
                event.preventDefault();
                var modal_body = $("#events-modal").find('.modal-body');
                $.ajax({
                    url: $(this).attr("href"),
                    type: "post",
                    data: {
                        id: $(this).data("id")
                    },
                    success: function(){
                        $.ajax({
                            url: "ajax/calendar/modal.php?id=<?php echo $mantto->id; ?>",
                            dataType: "html",
                            success: function(data){
                                modal_body.html(data);
                            }
                        })
                    }
                });
            }
        }
    );
</script>