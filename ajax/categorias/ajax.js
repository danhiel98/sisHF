var categoria = (function (categoria, undefined) {
  var _disabled = true;
 //----------------ENVIO POR AJAX POR METODO POST ------------------------////
  categoria.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idcategoria=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/categorias/resultado.php',
                data: { idCat: idcategoria },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idCategoria);
                    $('#ename').val(oDato[0].nombre);
                },
            });
        });
    },
  //----------------ENVIO POR METODO GET SIN AJAX------------------------ /////

  categoria.eliminarPersona = function () {

        $(".btn-eliminar").on("click", function (e) { //SE ACTIVA CUANDO SE HACE CLIC EN EL BOTON CON CLASE (btn-eliminar)

            e.preventDefault();

            var id=this.id; // CON EL (this.id) PODEMOS SACAR EL CONTENIDO DE LA ID  DEL BOTON CON LA CLASE (btn-eliminar) AL CUAL DIMOS CLIC


            p = confirm("¿Estas seguro que desea eliminar?");

            if(p){

                 window.location="controlers/eliminar_persona.php?pedrito="+id;    //ENVIAMOS POR GET EL ID PARA LUEGO RECIBIRLO EN eliminar_persona.php
             }
         });
    };


    return categoria;

})(categoria || {});

$(function () {

    categoria.eliminarPersona();
    categoria.llenarModalEditar();

});
