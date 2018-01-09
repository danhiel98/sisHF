<?php

    @session_start();
    include ("../../core/autoload.php");
    include ("../../core/modules/sistema/model/CausaDevolucionData.php");
	include ("../../core/modules/sistema/model/DevolucionData.php");
    include ("../../core/modules/sistema/model/ComprobanteData.php");
	include ("../../core/modules/sistema/model/FacturaData.php");
    include ("../../core/modules/sistema/model/ProductData.php");
    include ("../../core/modules/sistema/model/ClientData.php");
    include "funciones.php";

    unset($_SESSION["prodsDev"]);
    if (isset($_REQUEST["id"]) && $_REQUEST["id"] != ""):
        $id = $_REQUEST["id"]; #El id del comprobante (Factura, CCF o Recibo)      
        $prods = FacturaData::getAllSellsByFactId($id);
        
?>
    <table class="table table-bordered">
        <thead>
            <th>C&oacute;digo</th>
            <th>Nombre del Producto / Servicio</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th></th>
        </thead>
        <tbody>
    <?php
        foreach ($prods as $prd):
            $prod = $prd->getProduct();
    ?>
            <tr>
                <td><?php echo $prod->id; ?></td>
                <td><?php echo $prod->nombre; ?></td>
                <td><?php echo $prd->cantidad; ?></td>
                <td>$ <?php echo number_format($prd->precio,2,".",","); ?></td>
                <td style="width: 50px;">
                    <a data-id="<?php echo $prod->id; ?>" data-option="add" class="btn btn-warning btn-sm" href="ajax/devolucion/addDevolver.php"> Devolver</a>
                </td>
            </tr>
    <?php
        endforeach;
    ?>
        </tbody>
    </table>
    <script>
        $(".btn-sm").click(function(event){
            
            inputCant = $("#cantProds"); 
            cantidad = inputCant.val();
            
            btn = $(this);
            id = $(this).data("id");
            opcion = $(this).attr("data-option");
            
            $.ajax({
                url: $(this).attr("href"),
                type: "POST",
                data: {
                    id: id, //Envía el id del producto
                    opc: opcion //Sirve para controlar si se va a agregar o quitar el producto
                },
                success: function(res){
                    if (res == "ok"){
                        if (opcion == "add"){
                            btn.attr("class","btn btn-primary btn-sm");
                            btn.attr("data-option","quit");
                            btn.html("Quitar");
                            inputCant.val(++cantidad);
                        }else if(opcion == "quit"){
                            btn.attr("class","btn btn-warning btn-sm");
                            btn.attr("data-option","add");
                            btn.html("Devolver");
                            inputCant.val(--cantidad);
                        }
                    }
                    if (cantidad > 0){
                        $("#btnOk").removeAttr("disabled");           
                    }else{
                        $("#btnOk").attr("disabled","disabled");
                    }
                }
            });
            event.preventDefault();
        });
    </script>
    <?php
    endif;
    ?>