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