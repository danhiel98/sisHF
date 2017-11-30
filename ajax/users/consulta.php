<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    
    $users = false; #Todos los usuarios
    
    $usuarios = UserData::getAll();
    if (count($usuarios)>0) {
        $users = true;
    }

    $u = UserData::getById(Session::getUID());
	$sucursal = SucursalData::getAll();

?>
    <script src="res/x-editable/bootstrap3-editable/js/bootstrap-editable.js"></script>
    <?php if ($users): ?>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#all">Todos</a></li>
        <?php if (count($sucursal) > 1): ?>
            <li><a href="#suc">Por Sucursal</a></li>
        <?php endif; ?>
    </ul>
    <div class="clearfix"></div>
    <br>
    <div class="tab-content">
        <div id="all" class="tab-pane fade in active">
            <div class="">
                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Correo Electr&oacute;nico</th>
                        <th>Sucursal</th>
                        <th style="text-align:center;">Activo</th>
                        <th style="text-align:center;">Admin</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php foreach($usuarios as $user): ?>
                        <?php if((isset($_SESSION["usr_suc"]) && ($user->getEmpleado()->getSucursal()->id == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])): ?>
                        <tr>
                            <td><?php echo $user->getEmpleado()->nombre; ?></td>
                            <td><?php echo $user->getEmpleado()->apellido; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td><?php echo $user->getEmpleado()->getSucursal()->nombre; ?></td>
                            <td style="text-align:center;">
                                <?php if($user->activo):?>
                                <i class="glyphicon glyphicon-ok"></i>
                                <?php endif; ?>
                            </td>
                            <td style="text-align:center;">
                                <?php if($user->isAdmin):?>
                                <i class="glyphicon glyphicon-ok"></i>
                                <?php endif; ?>
                            </td>
                            <td width=110px>
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm">
                                        Opci&oacute;n
                                    </button>
                                    <button data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="estado" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                                data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
                                                data-btn-ok-class="btn-success btn-xs"
                                                data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                                data-btn-cancel-class="btn-danger btn-xs"
                                                data-title="Está seguro?">
                                                <?php if($user->activo):?>
                                                Desactivar
                                                <?php else: ?>
                                                Activar
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="admin" id="<?php echo $user->id; ?>" data-toggle="confirmation-popout" data-popout="true" data-placement="left"
                                                data-btn-ok-label="Sí" data-btn-ok-icon="fa fa-home fa-fw"
                                                data-btn-ok-class="btn-success btn-xs"
                                                data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-times fa-fw"
                                                data-btn-cancel-class="btn-danger btn-xs"
                                                data-title="Está seguro?">
                                                <?php if($user->isAdmin):?>
                                                Usuario Normal
                                                <?php else: ?>
                                                Administrador
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="suc" class="tab-pane fade">
            <div class="row">
                <div class="form-group form-horizontal">
                    <label for="sucursal" class="col-md-1 control-label">Sucursal</label>
                    <div class="col-md-6">
                        <select class="form-control" name="sucursal" id="sucursal">
                            <option id="su" value="">--SELECCIONE--</option>
                            <?php foreach ($sucursal as $s): ?>
                            <option value="<?php echo $s->id; ?>"><?php echo $s->nombre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div id="resultadoSuc"></div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        No hay usuarios registrados
    </div>
    <?php endif; ?>

    <script>
    
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
                var id = $("#sucursal").val();
                consultarPorSucursal(id);
            });
        });

        $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        container: 'body'});

        $('[data-toggle=confirmation-singleton]').confirmation({
        rootSelector: '[data-toggle=confirmation-singleton]',
        container: 'body'});

        $('[data-toggle=confirmation-popout]').confirmation({
        rootSelector: '[data-toggle=confirmation-popout]',
        container: 'body'});

        $('#confirmation-delegate').confirmation({
        selector: 'button'
        });

        function modificar(dato,id){
            $.ajax({
                url: "ajax/users/procesos.php",
                type: "POST",
                dataType: "html",
                data: {
                    tipo: dato,
                    idUsr: id
                }
            }).done(function(){
                //Esta función se encarga de obtenes todos los datos de los pedidos, se encuentra en el archivo ajax.js
                usuarios("all"); //Creo que ya no la utilizo para nada xD 
            });
        }

        //Al dar clic en "Sí" en el popup de confirmación
        $(".estado").on("confirmed.bs.confirmation",function(){
            var id = this.id;
            modificar("estado",id);
        });

        $(".admin").on("confirmed.bs.confirmation",function(){
            var id = this.id;
            modificar("admin",id);
        });

        function consultarPorSucursal(id){
            $.ajax({
                url: "ajax/users/consultaSucursal.php",
                type: "POST",
                dataType: "html",
                data: {
                    idSuc: id
                }
            }).done(function(resultado){
                $("#resultadoSuc").html(resultado);
            });
        }

        $("#sucursal").on("change",function(){
            var id = $(this).val();
            consultarPorSucursal(id);
        });

	</script>