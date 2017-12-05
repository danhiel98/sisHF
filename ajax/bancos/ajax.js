var banco = (function (banco, undefined) {
  var _disabled = true;
  banco.llenarModalEditar = function () {
    $(".btn-edit").on("click", function (e) {
      e.preventDefault();
      var idbanco=this.id;
      $.ajax({
        type: "POST",
        url: 'ajax/bancos/resultado.php',
        data: { idBanc: idbanco },
        success: function (data) {
          var oDato = JSON.parse(data);
          $('#eid').val(oDato[0].idBanco);
          $('#enombre').val(oDato[0].nombre);
          $('#edireccion').val(oDato[0].direccion);
          $('#etelefono').val(oDato[0].telefono);
          $('#enumeroCuenta').val(oDato[0].numeroCuenta);
        },
      });
    });
  }
  
  return banco;

})(banco || {});

$(function () {
    
  banco.llenarModalEditar();

});
