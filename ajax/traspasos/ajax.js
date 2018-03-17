function traspasos() {
    $.ajax({
        url: "ajax/traspasos/consulta.php",
        type: "POST",
        dataType: "html",
    }).done(function (res) {
        $("#resultado").html(res);
    });
}

$(function () {
    traspasos();
});