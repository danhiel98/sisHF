<?php

    @session_start();
    include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ReabastecimientoMPData.php");
    
    if (isset($_SESSION["productn"]) && !empty($_SESSION["productn"])):
?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($_SESSION["productn"] as $c):
            $prod = MateriaPrimaData::getById($c["product_id"]);
        ?>
            <tr>
                <td><?php echo $prod->nombre; ?></td>
                <th style="width:80px;"><?php echo $c["cantidad"]; ?></th>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="alert alert-warning">Debe agregar materia prima.</p>
<?php endif; ?>