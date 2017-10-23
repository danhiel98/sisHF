<?php
  $found = false;
  if (isset($_GET["idProd"]) && !empty($_GET["idProd"])) {
    if(!empty($_SESSION["trasp"])){
    	$cart = $_SESSION["trasp"];
    	if(count($cart) <= 1){
        unset($_SESSION["trasp"]);
        unset($_SESSION["origen"]);
      }else{
    		$newcart = array();
    		foreach($cart as $c){
    			if($c["product_id"] != $_GET["idProd"]){
    				$newcart[] = $c;
    			}
    		}
    		$_SESSION["trasp"] = $newcart;
    	}
    }
    print "<script>window.location='index.php?view=newtraspaso&x';</script>";
  }

  if (isset($_GET["delAll"])){
    unset($_SESSION["trasp"]);
    unset($_SESSION["origen"]);
    print "<script>window.location='index.php?view=newtraspaso';</script>";
  }

  $products = ProductData::getAll();
?>
<div class="modal fade" id="resumen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?view=proctraspaso" class="form-horizontal" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class='fa fa-list'></i> Resumen De Productos A Enviar</h4>
        </div>
        <div class="modal-body">
          <?php if (isset($_SESSION["trasp"]) && !empty($_SESSION["trasp"])): ?>
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-md-2 control-label">Origen</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" value="<?php echo SucursalData::getById($_SESSION["origen"])->nombre; ?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <label for="destino" class="col-md-2 control-label">Destino</label>
                <div class="col-md-9">
                  <select class="form-control" name="destino" required>
                    <option value="">--SELECCIONE--</option>
                    <?php foreach ($sucursal as $suc):?>
                      <?php if ($suc->id != $_SESSION["origen"]): ?>
                        <option value="<?php echo $suc->id; ?>"><?php echo $suc->nombre; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" name="origen" value="<?php echo $_SESSION["origen"]; ?>">
            <table class="table table-bordered">
              <thead>
              	<th>Producto</th>
                <th>Cantidad</th>
              	<th></th>
              </thead>
              <?php
              foreach($_SESSION["trasp"] as $c):
                $prod = ProductData::getById($c["product_id"]);
              ?>
              <tr>
                <td><?php echo $prod->nombre; ?></td>
                <th style="width:80px;"><?php echo $c["cantidad"]; ?></th>
                <td style="width:20px;">
                  <?php
                  $found = false;
                  foreach ($_SESSION["trasp"] as $c) { if($c["product_id"]==$prod->id){ $found=true; break; }}
                  ?>
                  <a href="index.php?view=newtraspaso&idProd=<?php echo $c["product_id"];?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
	              </td>
              </tr>
              <?php endforeach; ?>
            </table>
          <?php else: ?>
            <p class="alert alert-warning">No ha agregado productos.</p>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <?php if ($found): ?>
            <a href="index.php?view=newtraspaso&delAll" class="btn btn-danger">Cancelar</a>
            <button name="addTraspaso" type="submit" class="btn btn-md btn-success" title="Registrar Traspaso" ><span class="fa fa-save"></span> Continuar</button>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
