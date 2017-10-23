var servicio = (function (servicio, undefined) {
  var _disabled = true;
 //----------------servicio POR AJAX POR METODO POST ------------------------////
  servicio.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idservicio=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/servicio/resultado.php',
                data: { idServ: idservicio },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idServicio);
                    $('#enombre').val(oDato[0].nombre);
                    $('#edescripcion').val(oDato[0].descripcion);
                    $('#eprecio').val(oDato[0].precio);
                },
            });
        });
    },
  //----------------servicio POR METODO GET SIN AJAX------------------------ /////

  servicio.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return servicio;

})(servicio || {});

$(function () {

    servicio.eliminarPersona();
    servicio.llenarModalEditar();

});
