<?php
  $found = false;
  if (isset($_GET["idProd"]) && !empty($_GET["idProd"])) {
    if(!empty($_SESSION["productn"])){
    	$cart = $_SESSION["productn"];
    	if(count($cart) <= 1){
        unset($_SESSION["productn"]);
      }else{
    		$newcart = array();
    		foreach($cart as $c){
    			if($c["product_id"] != $_GET["idProd"]){
    				$newcart[] = $c;
    			}
    		}
    		$_SESSION["productn"] = $newcart;
    	}
    }
    print "<script>window.location='index.php?view=newproducn&x';</script>";
  }

  if (isset($_GET["delAll"])){
    unset($_SESSION["productn"]);
    unset($_SESSION["produccion"]);
    print "<script>window.location='index.php?view=newproducn';</script>";
  }
  $products = ProductData::getAll();
?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="index.php?view=processprod" id="frmProduccion" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Producci&oacute;n</h4>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label class="col-lg-3 control-label">Producto</label>
            <div class="col-lg-7">
              <select class="form-control selectpicker" data-live-search="true" data-size="5" name="producto" id="producto" required>
                <option value="">--SELECCIONE--</option>
                <?php foreach ($products as $prod): ?>
                  <option value="<?php echo $prod->id; ?>"><?php echo $prod->nombre; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group control-group">
        		<label for="cantidad" class="col-lg-3 control-label">Cantidad A Producir</label>
            <div class="col-lg-7 controls">
              <input type="text" class="form-control" name="cantidad" id="cantidad" required>
              <p class="help-block"></p>
            </div>
          </div>
          <div class="form-group control-group">
        		<label for="inicio" class="col-lg-3 control-label">Fecha De Inicio</label>
            <div class="col-lg-7 controls">
              <div class='input-group date' id='dtpInicio'>
              	<input type="text" name="inicio" id="inicio" class="form-control" required data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" />
                <span class="input-group-addon">
                  <span class="fa fa-calendar"></span>
                </span>
              </div>
              <p class="help-block"></p>
            </div>
          </div>
          <div class="form-group control-group">
        		<label for="fin" class="col-lg-3 control-label">Fecha L&iacute;mite</label>
            <div class="col-lg-7 controls">
            	<div class='input-group date' id='dtpFin'>
              	<input type="text" name="fin" id="fin" class="form-control" required data-validation-regex-regex="[0-9]{1,2}(-|/)[0-9]{1,2}(-|/)[0-9]{4}" data-validation-regex-message="Utilice un formato válido" />
                <span class="input-group-addon">
                	<span class="fa fa-calendar"></span>
                </span>
              </div>
              <p class="help-block"></p>
            </div>
        	 </div>

          <?php if (isset($_SESSION["productn"]) && !empty($_SESSION["productn"])): ?>
            <table class="table table-bordered">
              <thead>
                <th>Producto</th>
                <th>Cantidad</th>
                <th></th>
              </thead>
              <tbody>
              <?php
                foreach($_SESSION["productn"] as $c):
                  $prod = MateriaPrimaData::getById($c["product_id"]);
              ?>
                <tr>
                  <td><?php echo $prod->nombre; ?></td>
                  <th style="width:80px;"><?php echo $c["cantidad"]; ?></th>
                  <td style="width:20px;">
                  <?php
                    $found = false;
                    foreach ($_SESSION["productn"] as $c) { if($c["product_id"]==$prod->id){ $found=true; break; }}
                  ?>
                    <a href="index.php?view=newproducn&idProd=<?php echo $c["product_id"];?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
  	              </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <p class="alert alert-warning">Debe agregar materia prima.</p>
          <?php endif; ?>

        </div>
        <div class="modal-footer">
          <?php if ($found): ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <a href="index.php?view=newproducn&delAll" class="btn btn-danger">Cancelar</a>
            <button name="addProducn" type="submit" class="btn btn-md btn-success" title="Registrar Producci&oacute;n" ><span class="fa fa-save"></span> Guardar</button>
          <?php else: ?>
            <button id="btnInfo" type="submit" class="btn btn-success" onclick="produccion();">Continuar</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(function () {
    $('#dtpInicio').datetimepicker({
      format: "DD/MM/YYYY",
      locale: "es",
      minDate: new Date()
    });
    $('#dtpFin').datetimepicker({
      format: "DD/MM/YYYY",
      locale: "es",
      minDate: new Date()
      //useCurrent: false //Important! See issue #1075
    });
    $("#dtpInicio").on("dp.change", function (e) {
      $('#dtpFin').data("DateTimePicker").minDate(e.date);
    });
    $("#dtpFin").on("dp.change", function (e) {
      $('#dtpInicio').data("DateTimePicker").maxDate(e.date);
    });
  });
  function produccion(){
    try {
      $("#frmProduccion").submit(function(){
        $.ajax({
          url: "ajax/produccion/info.php",
          type: "POST",
          data: $(this).serialize(),
          success: function(){
            $("#resumen").modal("hide");
          }
        });
        return false;
      });
    } catch (e) {
      alert("Ha ocurrido un error!" + e.getMessage());
    } finally {
      console.log("Se ejecutó la función...");
    }
  }
</script>
<?php if (isset($_SESSION["produccion"])): $prd = $_SESSION["produccion"]; ?>
  <script type="text/javascript">
    $(function(){
      $("#producto").val(<?php echo $prd["idProducto"] ?>);
      $("#cantidad").val(<?php echo $prd["cantidad"] ?>);
      $("#inicio").val('<?php echo $prd["inicio"] ?>');
      $("#fin").val('<?php echo $prd["fin"] ?>');
    });
  </script>
<?php endif; ?>
