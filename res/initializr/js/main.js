$.ajaxSetup({
    error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            console.log('No conectado: Verifique su conexión a internet.');
        } else if (jqXHR.status == 404) {
            console.log('No se encontró la página solicitada [404]');
        } else if (jqXHR.status == 500) {
            console.log('Error interno del servidor [500].');
        } else if (textStatus === 'parsererror') {
            console.log('Requested JSON parse failed.');
        } else if (textStatus === 'timeout') {
            console.log('Time out error.');
        } else if (textStatus === 'abort') {
            console.log('Solicitud abortada.');
        } else {
            console.log('Error desconocido: ' + jqXHR.responseText);
        }
    }
});

$(function(){
    $('[data-toggle=confirmation-popout]').confirmation(
        {
            rootSelector: '[data-toggle=confirmation-popout]',
            container: 'body'
        }
    );

    $(".nav-tabs a").click(function () {
        $(this).tab('show');
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

})

function comparar(valor1,valor2){
    return valor1 == valor2;
}
