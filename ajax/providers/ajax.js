var proveedor = (function (proveedor, undefined) {
  var _disabled = true;
 //----------------proveedor POR AJAX POR METODO POST ------------------------////
  proveedor.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idproveedor=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/providers/resultado.php',
                data: { idProv: idproveedor },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idProveedor);
                    $('#enombre').val(oDato[0].nombre);
                    $('#eprovee').val(oDato[0].tipoProvee);
                    $('#edireccion').val(oDato[0].direccion);
                    $('#etelefono').val(oDato[0].telefono);
                    $('#ecorreo').val(oDato[0].correo);
                },
            });
        });
    };

    return proveedor;

})(proveedor || {});

$(function () {

    proveedor.llenarModalEditar();

});
