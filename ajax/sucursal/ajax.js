var sucursal = (function (sucursal, undefined) {
  var _disabled = true;
  sucursal.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idsucursal=this.id;

            $.ajax({
                type: "POST",
                encoding: "UTF-8",
                url: 'ajax/sucursal/resultado.php',
                data: { idSuc: idsucursal },
                success: function (data) {
                    var oDato = JSON.parse(data); // JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idSucursal);
                    $('#enombre').val(oDato[0].nombre);
                    $('#edireccion').val(oDato[0].direccion);
                    $('#etelefono').val(oDato[0].telefono);
                },
            });
        });
    }

    return sucursal;

})(sucursal || {});

$(function () {

    sucursal.llenarModalEditar();

});
