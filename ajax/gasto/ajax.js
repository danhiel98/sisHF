var gasto = (function (gasto, undefined) {
  var _disabled = true;
  gasto.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idgasto=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/gasto/resultado.php',
                data: { idGst: idgasto },
                success: function (data) {
                    var oDato = JSON.parse(data);
                    $('#eid').val(oDato[0].idGasto);
                    $('#eresponsable').val(oDato[0].idEmpleado);
                    $('#edescripcion').val(oDato[0].descripcion);
                    $('#epago').val(oDato[0].pago);
                    $('#ecomprobante').val(oDato[0].numeroComprobante);
                },
            });
        });
    }

    return gasto;

})(gasto || {});

$(function () {

    gasto.llenarModalEditar();

});
