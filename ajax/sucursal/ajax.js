var sucursal = (function (sucursal, undefined) {
  var _disabled = true;
 //----------------sucursal POR AJAX POR METODO POST ------------------------////
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
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idSucursal);
                    $('#enombre').val(oDato[0].nombre);
                    $('#edireccion').val(oDato[0].direccion);
                    $('#etelefono').val(oDato[0].telefono);
                },
            });
        });
    },
  //----------------sucursal POR METODO GET SIN AJAX------------------------ /////

  sucursal.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return sucursal;

})(sucursal || {});

$(function () {

    sucursal.eliminarPersona();
    sucursal.llenarModalEditar();

});
