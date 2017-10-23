var gasto = (function (gasto, undefined) {
  var _disabled = true;
 //----------------ENVIO POR AJAX POR METODO POST ------------------------////
  gasto.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idgasto=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/gasto/resultado.php',
                data: { idGst: idgasto },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idGasto);
                    $('#edescripcion').val(oDato[0].descripcion);
                    $('#epago').val(oDato[0].pago);
                    $('#ecomprobante').val(oDato[0].numeroComprobante);
                },
            });
        });
    },
  //----------------ENVIO POR METODO GET SIN AJAX------------------------ /////

  gasto.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return gasto;

})(gasto || {});

$(function () {

    gasto.eliminarPersona();
    gasto.llenarModalEditar();

});
