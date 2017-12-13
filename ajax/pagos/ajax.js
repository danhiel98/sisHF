$(function(){

    $("#btnPago").on("click",function(){
        id = $("#idPedido").val();
        cliente = $("#cliente");
        cantidad = $("#cantidad");
        restante = $("#restante");
        $.ajax({
            url: "ajax/pagos/infoPedido.php",
            type: "POST",
            data: { idPedido: id },
            success: function (data) {
                if (data != "") {
                    var dato = JSON.parse(data);
                    cliente.val(dato.nombreC + " " + dato.apellidoC);
                    cantidad.val(dato.restante);
                    restante.val(cantidad.val() - dato.restante);
                    $.ajax({
                        url: "ajax/pagos/infoComprobante.php",
                        type: "POST",
                        dataType: "html",
                        data: {idCliente: dato.idcliente},
                        success: function(data){
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
    });

});