$(function(){
  $(".cmpCant").on("keypress",function(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);
  });
  
  $(".cmpPrec").on("keypress",function(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0 || key == 46);
  });

  $(".cmpValid").on("paste", function(){
    return false;
  });

  $(".cmpValid").on("change keypress leave", function(){
    id = $(this).data("id");
    cantidad = $(".cmpCant[data-id=" + id + "]").val();
    precio = $(".cmpPrec[data-id=" + id + "]").val();
    btn = $(".btnEnviar[data-id=" + id + "]")

    if (cantidad > 0 && precio > 0){
      btn.removeAttr("disabled");
    }else{
      btn.attr("disabled", "true");
    }

  });

  $(".btnEnviar").click(function(){
    idBoton = $(this).data("id");
    cantidad = $(".cmpCant[data-id="+idBoton+"][aria-invalid=false]").val();
    precio = $(".cmpPrec[data-id="+idBoton+"][aria-invalid=false]").val();
    $.ajax({
      url: "ajax/buy/addtore.php",
      type: "POST",
      data: {
        idMP: idBoton,
        cantidadMP: cantidad,
        precioMP: precio
      },
      success: function(res){
        obtener_registros();
      }
    });
  });

  $(".btnQuitar").click(function(){
    idBoton = $(this).data("id");
    $.ajax({
      url: "ajax/buy/clearre.php",
      type: "POST",
      data: {
        idMP: idBoton
      },
      success: function(res){
        obtener_registros();
      }
    });
  });

});
