<div class="modal" id="password">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form  class="form-horizontal" action="index.php?view=changepasswd" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span class="modal-title">Introduzca la nueva contraseña</span>
                </div>
                <div class="modal-body">
                    <div class="form-group control-group">
                        <label for="password" class="col-sm-4 control-label">Contrase&ntilde;a*</label>
                        <div class="col-md-8 controls">
                            <input type="password" name="password" class="form-control" id="password1" placeholder="Contrase&ntilde;a" maxlength="30" data-validation-regex-regex="[\w\d].*" data-validation-regex-message="Contraseña ingresada inválida" minlength="3" required>
                        </div>
                    </div>
                    <div class="form-group control-group">
                        <label for="password2" class="col-sm-4 control-label">Repetir Contrase&ntilde;a*</label>
                        <div class="col-md-8 controls">
                            <input type="password" name="password" class="form-control" id="password2" placeholder="Repetir Contrase&ntilde;a" maxlength="30" data-validation-regex-regex="[\w\d].*" data-validation-regex-message="Contraseña ingresada inválida" minlength="3" required>
                        </div>
                    </div>
                    <p id="alerta" class="alert alert-warning error-info" hidden="hidden">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </p>
                </div>
                <input id="idUsr" type="hidden" name="idUsr" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#password").find("form").on("submit",function(event){
                
        pass1 = $("#password1").val();
        pass2 = $("#password2").val();
        
        if (!comparar(pass1,pass2)){
            event.preventDefault();
            block = $(this).find(".error-info");
            
            if (!block.hasClass("x")){
                block.html(block.html() + "Las contraseñas no coinciden");
            }
            
            block.show();
        }
    });
    
    $('#alerta').on('close.bs.alert', function (event) {
        event.preventDefault();
        alert = $(this);
        alert.addClass("x");
        alert.hide();
    });

</script>