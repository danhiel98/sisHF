$.ajaxSetup({
    error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert('No conectado: Verifique su conexión a internet.');
        } else if (jqXHR.status == 404) {
            alert('No se encontró la página solicitada [404]');
        } else if (jqXHR.status == 500) {
            alert('Error interno del servidor [500].');
        } else if (textStatus === 'parsererror') {
            alert('Requested JSON parse failed.');
        } else if (textStatus === 'timeout') {
            alert('Time out error.');
        } else if (textStatus === 'abort') {
            alert('Solicitud abortada.');
        } else {
            alert('Error desconocido: ' + jqXHR.responseText);
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
})

function comparar(valor1,valor2){
    return valor1 == valor2;
}