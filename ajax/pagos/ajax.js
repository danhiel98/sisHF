$(function(){
    
    //Eso se encarga de cargar la información del pedido cuando estamos en detallePedido
    function obtenerDatos(idPedido){
        cliente = $("#cliente");
        cantidad = $("#cantidad");
        restante = $("#restante");
        $.ajax({
            url: "ajax/pagos/infoPedido.php",
            type: "POST",
            data: { idPedido: idPedido },
            success: function (data) {
                if (data != "") {
                    var dato = JSON.parse(data);
                    cliente.val(dato.nombreC);
                    cantidad.val(dato.restante);
                    restante.val(cantidad.val() - dato.restante);
                    $.ajax({
                        url: "ajax/pagos/infoComprobante.php",
                        type: "POST",
                        dataType: "html",
                        data: { idCliente: dato.idcliente },
                        success: function (data) {
                            $("#tipoComprobante").html(data);
                        }
                    });
                } else {
                    cliente.val("");
                    cantidad.val("");
                    restante.val("");
                }
            }
        });
    }

    $("#btnPago").on("click",function(){
        id = $("#idPedido").val();
        obtenerDatos(id);
    });

    $(".btn-detail").on("click",function(){
        id = this.id;
        $.ajax({
            url: "ajax/pagos/detallePedido.php",
            type: "POST",
            dataType: "html",
            data: {id: id},
            success: function(data){
                $("#detalles").html(data);
            }
        });
    });
    
    //Al dar clic en "Sí" en el popup de confirmación
    $(".finalizar").on("confirmed.bs.confirmation", function () {
        var id = this.id;
        var opc = $(this).data("opc");
        var est = $(this).data("estado");
        $("#idPedido").val(id);
        obtenerDatos(id);
        finalizar(id, opc, est);
    });

    /*
    $(".finalizar").on("click", function () {
        id = this.id;
        $("#idPedido").val(id);
        obtenerDatos(id);
    });
    */
});