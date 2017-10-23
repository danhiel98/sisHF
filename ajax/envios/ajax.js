var envio = (function (envio, undefined) {
  var _disabled = true;
 //----------------ENVIO POR AJAX POR METODO POST ------------------------////
  envio.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idenvio=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/envios/resultado.php',
                data: { idEnv: idenvio },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idEnvioBanco);
                    $('#ebanco').val(oDato[0].idBanco);
                    $('#ecantidad').val(oDato[0].cantidad);
                    $('#ecomprobante').val(oDato[0].numComprobante);
                },
            });
        });
    },
  //----------------ENVIO POR METODO GET SIN AJAX------------------------ /////

  envio.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return envio;

})(envio || {});

$(function () {

    envio.eliminarPersona();
    envio.llenarModalEditar();

});
