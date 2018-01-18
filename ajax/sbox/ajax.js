$(function(){
    $(".btn-edit").on("click", function (e) {
        e.preventDefault();
        var id = this.id;
        var opcion = $(this).data("opc");
        $.ajax({
            type: "POST",
            url: 'ajax/sbox/resultado.php',
            data: {
                id: id,
                opc: opcion
             },
            success: function (data) {
                var oDato = JSON.parse(data); //JSON.parse convierte ese JSON en un objeto
                if (opcion == "entrada"){
                    $('#id').val(oDato[0].idIngresoCajaChica);
                    $('#cantidad').val(oDato[0].cantidad);
                }else if (opcion == "salida"){
                    $('#idS').val(oDato[0].idSalidaCajaChica);
                    $('#cantidadS').val(oDato[0].cantidad);                    
                    $('#empleado').val(oDato[0].idEmpleado);
                    $('#descripcion').val(oDato[0].descripcion);
                }
            }
        });
    });
});