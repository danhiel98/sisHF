<?php

    @session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/SucursalData.php");
    include ("../../core/modules/sistema/model/EmpleadoData.php");
    
    $users = false; #Todos los usuarios
    
    #En siguiente variable se van a almacenar los usuarios que pertenecen a la sucursal especificada
    #Porque no se puede hacer una consulta directa entre el usuario y la sucursal
    $usuariosSuc = array(); 

    $idSucursal = $_POST["idSuc"];

    $usuarios = UserData::getAll();
    if (count($usuarios)>0) {
        foreach ($usuarios as $usr){
            if ($usr->getEmpleado()->idsucursal == $idSucursal){
                array_push($usuariosSuc,$usr);
            }
        }
    }
    
    #print_r($usuariosSuc);
    
    if (count($usuariosSuc) > 0){
        $users = true;
    }

    $u = UserData::getById(Session::getUID());
	$sucursal = SucursalData::getAll();

?>
    <?php if ($users): ?>
        <script>
            $.getScript("js/bootstrap-confirmation.js");
        </script>
        <div class="">
            <table class="table table-hover table-bordered">
                <thead>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Correo Electr&oacute;nico</th>
                    <th style="text-align:center;">Activo</th>
                    <th style="text-align:center;">Admin</th>
                    <th></th>
                </thead>
                <tbody>
                <?php foreach($usuariosSuc as $user): ?>
                    <?php if((isset($_SESSION["usr_suc"]) && ($user->getEmpleado()->getSucursal()->id == $_SESSION["usr_suc"])) || isset($_SESSION["adm"])): ?>
                    <tr>
                        <td><?php echo $user->getEmpleado()->nombre; ?></td>
                        <td><?php echo $user->getEmpleado()->apellido; ?></td>
                        <td><?php echo $user->username; ?></td>
                        <td><?php echo $user->email; ?></td>
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
    <?php elseif($idSucursal == ""): ?>
    <div class="alert alert-info">
        Seleccione una sucursal.
    </div>
    <?php else: ?>
    <div class="alert alert-info">
        No hay usuarios registrados en la sucursal seleccionada.
    </div>
    <?php endif; ?>