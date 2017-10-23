var banco = (function (banco, undefined) {
  var _disabled = true;
 //----------------banco POR AJAX POR METODO POST ------------------------////
  banco.llenarModalEditar = function () {
    $(".btn-edit").on("click", function (e) {
      e.preventDefault();
      var idbanco=this.id;
      $.ajax({
        type: "POST",
        url: 'ajax/bancos/resultado.php',
        data: { idBanc: idbanco },
        success: function (data) {
          var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
          $('#eid').val(oDato[0].idBanco);
          $('#enombre').val(oDato[0].nombre);
          $('#edireccion').val(oDato[0].direccion);
          $('#etelefono').val(oDato[0].telefono);
        },
      });
    });
  },
  //----------------banco POR METODO GET SIN AJAX------------------------ /////

  banco.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return banco;

})(banco || {});

$(function () {

    banco.eliminarPersona();
    banco.llenarModalEditar();

});
