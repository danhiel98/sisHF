$(function(){
    $("#numComprobante").on("change", function(){
        numero = $(this).val();
        $.ajax({
            url: "ajax/devolucion/resultado.php",
            type: "POST",
            data: { num: numero },
            success: function(data){
                var cliente = $("#cliente");
                var comprobante = $("#comprobante");
                var resultado = $("#resultadoProds");
                if (data != ""){
                    dato = JSON.parse(data);
                    cliente.val(dato.nombrecliente);
                    comprobante.val(dato.nombrecomprobante);
                    //xD
                    $.ajax({
                        url: "ajax/devolucion/productos.php",
                        type: "POST",
                        dataType: "html",
                        data: { id: dato.id },
                        success: function(res){
                            resultado.html(res);
                        }   
                    });
                }else{
                    cliente.val("");
                    comprobante.val("");
                    resultado.html("");
                    $(".compGroup").addClass("has-warning");
                }
            }
        });
    });
});