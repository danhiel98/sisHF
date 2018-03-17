<?php

    $idSuc = $_SESSION["usr_suc"];

    $user = UserData::getById(Session::getUID());
    $sucursales = SucursalData::getAll();
    $prods = ProductoSucursalData::getAllForSell($idSuc);
    $clients = ClientData::getAll();
    $servs = ServiceData::getAll();

    count($clients) > 0 ? $clientes = true : $clientes = false;
    count($prods) > 0 ? $products = true : $products = false;
    count($servs) > 0 ? $services = true : $services = false;
?>
<script type="text/javascript" src="ajax/busquedafecha/ajax.js"></script>
<div class="row">
    <div class="col-md-12">
  	    <div class="btn-group pull-right">
            <?php if(($services || $products) && $clientes): ?>
            <a class="btn btn-default" href="index.php?view=sell"><i class="fa fa-usd"></i> Vender</a>
            <?php endif; ?>

        </div>
		
        <h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		
        <div class="clearfix"></div>

        <?php if(count($sucursales) > 1 && $user->id == 1): ?>

        <div class="form-horizontal">
            <label for="sucursal" class="col-md-2 col-sm-2 col-xs-2 control-label">Sucursal</label>
            <div class="col-md-4 col-sm-6 col-xs-8">
                <select name="sucursal" id="sucursal" class="form-control">
                    <?php foreach($sucursales as $suc): ?>
                        <option <?php if($suc->id == $idSuc){echo 'selected';} ?> value="<?php echo $suc->id; ?>"><?php echo $suc->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <script>
            $("#sucursal").on("change", function(){
                $.ajax({
                    url: "ajax/busquedafecha/sucursalSells.php",
                    type: "POST",
                    data: {
                        id: $(this).val()
                    },
                    dataType: "html",
                    success: function(res){
                        $("#agrega-registros").html(res);
                    }
                });
            });
        </script>
        
        <?php endif; ?>
        <div class="clearfix"></div>
        <br>

        <div id="agrega-registros"></div>
    </div>
</div>

<script type="text/javascript">
  $(function () {
      $('#dateStart').datetimepicker({
          format: "DD/MM/YYYY",
      locale: "es"
      });
      $('#dateEnd').datetimepicker({
        format: "DD/MM/YYYY",
        locale: "es",
        useCurrent: false //Important! See issue #1075
      });
      $("#dateStart").on("dp.change", function (e) {
        $('#dateEnd').data("DateTimePicker").minDate(e.date);
      });
      $("#dateEnd").on("dp.change", function (e) {
        $('#dateStart').data("DateTimePicker").maxDate(e.date);
      });
  });

$(function(){
    $("#btn_envio").click(function(){
        var primerFecha = $("#fecInicio").val();
        var segundaFecha = $("#fecFin").val();
      
        if (primerFecha != '' && segundaFecha != ''){
            window.open("report/resumenventas.php?facInicio=" + primerFecha + "&facFinal=" + segundaFecha, "_blank")
        }else{
            alert('Faltan campos por llenar');
        }
    });
});
</script>

