$(function(){
  $("#departamento").on("change", function(){
    var id = $(this).val();
    $.ajax({
      url: "ajax/empleados/municipios.php",
      type: "POST",
      dataType: "html",
      data: {
        idDepto: id
      },
      success: function(res){
        var munic = $("#municipio");
        munic.html(res);
        if (id != "") {
          munic.removeAttr("disabled");
        }else{
          munic.attr("disabled","");
        }
      }
    });
  });
});
