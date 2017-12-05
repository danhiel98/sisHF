<script type="text/javascript" src="ajax/busquedafecha/ajax.js"></script>
<div class="row">
  <div class="col-md-12">
  	<div class="btn-group pull-right">
			<a class="btn btn-default" href="index.php?view=sell"><i class="fa fa-usd"></i> Vender</a>
			<button  type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-download"></i> Descargar <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a id="btn_envio" target="_blank" href="#">Excel (.xlsx)</a></li>
			</ul>
		</div>
		<h1><i class='glyphicon glyphicon-shopping-cart'></i> Lista de Ventas</h1>
		<div class="clearfix"></div>

        <label for="inicio" class="col-lg-2 control-label">Fecha De Inicio</label><div class='col-md-2'>
            <div class="form-group">
                <div id="dateStart" class='input-group date'>
                    <input id='fecInicio'  value="01/05/2017" type='text' class="form-control fecha" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <label for="inicio" class="col-lg-2 control-label">Fecha Fin</label>
        <div class='col-md-2'>
            <div class="form-group">
                <div  id="dateEnd" class='input-group date' >
                    <input  id='fecFin' value="01/12/2017" type='text' class="form-control fecha" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
       </div>
       <div class="btn-group pull-center">
          <button  type="button" id="btnBusca" class="btn btn-info" data-toggle="modal" data-target="#ver">
            <i class="fa fa-search"></i> Buscar</span>
          </button>
       </div>
    <div id="agrega-registros">
    </div>
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

