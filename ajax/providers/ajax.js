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
    },
  //----------------proveedor POR METODO GET SIN AJAX------------------------ /////

  proveedor.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return proveedor;

})(proveedor || {});

$(function () {

    proveedor.eliminarPersona();
    proveedor.llenarModalEditar();

});
