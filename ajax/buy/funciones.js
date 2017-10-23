$(function(){

  $(".cmpCant").on("keypress",function(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0);
  });

  $(".cmpPrec").on("keypress",function(e){
    key = (window.Event) ? e.which : e.keyCode;
    return (key >= 48 && key <= 57 || key >= 8 && key <= 31 || key == 0 || key == 46);
  });

  $(".cmpValid").on("change keyup leave", function(){
    id = $(this).data("id");
    objCant = $(".cmpCant[data-id="+id+"]");
    objPrec = $(".cmpPrec[data-id="+id+"]");
    objBtn = $(".btnEnviar[data-id="+id+"]");
    validar(objCant,objPrec,objBtn);
  });

  function validar(obj1,obj2,btn){
    cnt = obj1.val();
    prc = obj2.val();
    if ((obj1.attr("aria-invalid")=="false" && cnt.length > 0) && (obj2.attr("aria-invalid")=="false" && prc.length > 0)) {
      btn.removeAttr("disabled");
    }else{
      btn.attr("disabled","true");
    }
  }

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
