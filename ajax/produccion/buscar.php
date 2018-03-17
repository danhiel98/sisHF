<?php
    
    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ReabastecimientoMPData.php");

    $materiaP = null;
    if(isset($_POST["productos"])){
		$materiaP = MateriaPrimaData::getLike($_POST['productos']);
    }

    if (count($materiaP) > 0):
?>
    <table class="table table-bordered table-hover table-responsive">
        <thead>
            <th>Nombre</th>
            <th>Descripción</th>
            <th style="width:50px;">Existencias</th>
            <th style="width: 140px;">Agregar</th>
        </thead>
        <tbody>
            <?php
            foreach ($materiaP as $mp):
                $found = false;
                if(isset($_SESSION["productn"])){
                    foreach ($_SESSION["productn"] as $c) {
                        if($c["product_id"] == $mp->id){ 
                            $found = true;
                            $cantidad = $c["cantidad"];
                            break;
                        }
                    }
                }
            ?>
            <tr>
                <td><?php echo $mp->nombre; ?></td>
                <td><?php echo $mp->descripcion; ?></td>
                <td><?php echo $mp->existencias; ?></td>
                <td>
                    <form class="form-inline enviar" method="post" action="ajax/produccion/<?php if($found){echo "quit";}else{ echo "add";} ?>.php">
                        <input type="hidden" name="product_id" value="<?php echo $mp->id; ?>">
                        <div class="form-group control-group">
                            <div class="controls">
                                <div class="input-group">
                                    <input class="form-control input-sm" type="text" name="cantidad" value="<?php if($found){echo $cantidad;}else{ echo "1";} ?>" style="width:80px;" min="1" placeholder="Cantidad" pattern="[\d]{1,8}" onkeypress="return soloNumeros(event)" maxlength="8" required <?php if($found){echo "disabled=disabled";} ?>>
                                    <span class="input-group-btn">
                                        <button type="submit" id="<?php echo $mp->id; ?>" class="btn btn-sm <?php if($found){echo "btn-danger";}else{ echo "btn-success";} ?>"><i class="fa <?php if($found){echo "fa-times";}else{ echo "fa-cart-plus";} ?>"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        $.getScript("ajax/produccion/cart.js");
    </script>
<?php else: ?>
    <div class="alert alert-warning">
        ¡Vaya! No se encontró nada :(
    </div>
<?php endif; ?>