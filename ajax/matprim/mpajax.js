var materiaprima = (function (materiaprima, undefined) {
  var _disabled = true;

  materiaprima.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idMateriaPrima=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/matprim/resultado.php',
                data: { idMP: idMateriaPrima },
                success: function (data) {
                    var oDato = JSON.parse(data);// JSON.parse convierte ese JSON en un objeto
                    $('#eid').val(oDato[0].idMateriaPrima);
                    $('#enombre').val(oDato[0].nombre);
                    $('#edescripcion').val(oDato[0].descripcion);
                    $('#eminimo').val(oDato[0].minimo);
                },
            });
        });
    }

    return materiaprima;

})(materiaprima || {});

$(function () {

    materiaprima.llenarModalEditar();

});
