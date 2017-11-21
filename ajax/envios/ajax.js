var envio = (function (envio, undefined) {
  var _disabled = true;

  envio.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idenvio=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/envios/resultado.php',
                data: { idEnv: idenvio },
                success: function (data) {
                    var oDato = JSON.parse(data);
                    $('#eid').val(oDato[0].idEnvioBanco);
                    $('#ebanco').val(oDato[0].idBanco);
                    $('#ecantidad').val(oDato[0].cantidad);
                    $('#ecomprobante').val(oDato[0].numComprobante);
                    $.ajax({
                        type: "POST",
                        url: "ajax/envios/numCuenta.php",
                        data: { idBanc: oDato[0].idBanco },
                        success: function (data) {
                            var oDato = JSON.parse(data);
                            $("#enumeroCuenta").val(oDato[0].numeroCuenta);
                        }
                    });
                },
            });
        });
    },

    envio.obtenerNumCuenta = function(){
        $("#banco").on("change", function(){
            var idBanco = $(this).val();
            if (idBanco != "" && idBanco > 0){
                $.ajax({
                    type: "POST",
                    url: "ajax/envios/numCuenta.php",
                    data: { idBanc: idBanco },
                    success: function (data) {
                        var oDato = JSON.parse(data);
                        $("#numeroCuenta").val(oDato[0].numeroCuenta);
                    }
                });
            }else{
                $("#numeroCuenta").val("");
            }
        });
    },

      envio.obtenerNumCuenta2 = function () {
          $("#ebanco").on("change", function () {
              var idBanco = $(this).val();
              if (idBanco != "" && idBanco > 0) {
                  $.ajax({
                      type: "POST",
                      url: "ajax/envios/numCuenta.php",
                      data: { idBanc: idBanco },
                      success: function (data) {
                          var oDato = JSON.parse(data);
                          $("#enumeroCuenta").val(oDato[0].numeroCuenta);
                      }
                  });
              } else {
                  $("#enumeroCuenta").val("");
              }
          });
      }

    return envio;

})(envio || {});

$(function () {
    
    envio.obtenerNumCuenta();
    envio.obtenerNumCuenta2();
    envio.llenarModalEditar();

});
