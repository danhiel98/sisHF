function producciones(tab) {
    $.ajax({
        url: "ajax/producciones/consulta.php",
        type: "POST",
        dataType: "html",
        data: {
            tab: tab
        }
    }).done(function (res) {
        $("#resultado").html(res);
    });
}

$(function () {
    producciones();
});