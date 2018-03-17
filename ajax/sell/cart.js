$(function(){
    $("form.enviar").submit(function (event) {
        var form = $(this);
        var tipo = form.data("type");
        if (tipo == "product") {
            var idProd = $(".idProd", this).val();
        }
        var input = $(".input-sm", this); //El input de la cantidad de artículos
        //console.log(input);
        var btn = input.next().find("button"); //El botón de enviar
        //console.log(btn);
        var li = btn.children(); //El li para cambiar el ícono
        //console.log(li);
        if (input.attr("aria-invalid") != "true") {
            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: $(this).serialize(),
                success: function () {
                    // console.log("Se hizo la consulta ajax");
                    inactivo = input.attr("disabled"); //Obtener el valor de la propiedad disabled del input cantidad
                    if (inactivo == "disabled") {
                        //console.log("Está inactivo");
                        input.removeAttr("disabled");
                        form.attr("action", "ajax/sell/addxsell.php");
                        if (tipo == "product") {
                            $("[data-id='" + idProd + "']").removeAttr("disabled");
                        }
                    } else {
                        //console.log("Está activo");
                        input.attr("disabled", "disabled");
                        form.attr("action", "ajax/sell/quitar.php");
                        if (tipo == "product") {
                            $("[data-id='" + idProd + "']").attr("disabled", "disabled");
                        }
                    }
    
                    btn.toggleClass("btn-success");
                    btn.toggleClass("btn-danger");
                    li.toggleClass("fa-cart-plus");
                    li.toggleClass("fa-times");
                }
            });
        }
        event.preventDefault();
    });
});
