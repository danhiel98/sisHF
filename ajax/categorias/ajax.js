var categoria = (function (categoria, undefined) {
  var _disabled = true;
  categoria.llenarModalEditar = function () {
        $(".btn-edit").on("click", function (e) {
            e.preventDefault();
            var idcategoria=this.id;

            $.ajax({
                type: "POST",
                url: 'ajax/categorias/resultado.php',
                data: { idCat: idcategoria },
                success: function (data) {
                    var oDato = JSON.parse(data);
                    $('#eid').val(oDato[0].idCategoria);
                    $('#ename').val(oDato[0].nombre);
                },
            });
        });
    }

    return categoria;

})(categoria || {});

$(function () {
    
    categoria.llenarModalEditar();

});
