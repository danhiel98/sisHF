<?php
    
    #Para saber si hay alertas o no
    $alertMP = false; 
    $alertProd = false;

    #Productos que están en alerta
    $alertaMP = array();
    $alertaProd = array();

    $materiaPrima = MateriaPrimaData::getAll();
    $productos = ProductoSucursalData::getAll();

    foreach ($materiaPrima as $mp){
        if ($mp->existencias <= $mp->minimo){
            $alertMP = true;
            array_push($alertaMP, $mp);
        }
    }

    foreach ($productos as $prod){
        if ($prod->cantidad <= $prod->minimo){
            $alertProd = true;
            array_push($alertaProd, $prod);
        }
    }

    $totalAlertas = count($alertaMP) + count($alertaProd);

?>

<ul class="nav navbar-nav navbar-right ">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell fa-fw"></i>
            <b class="caret"></b>
            <span class="badge"><?php echo $totalAlertas;  ?></span>
        </a>
        <ul class="dropdown-menu">
            <?php if ($totalAlertas > 0): ?>
                <?php if (count($alertaProd > 0)): ?>
                <li>
                    <a data-toggle="modal" data-target="#alertaProd" href="#">Alerta(s) en productos <span class="label label-warning"><?php echo count($alertaProd); ?></span></a>
                </li>
                <?php endif; ?>
                <?php if (count($alertaMP > 0)): ?>
                <li>
                    <a data-toggle="modal" data-target="#alertaMP" href="#"> Alerta(s) en materia prima <span class="label label-warning"><?php echo count($alertaMP); ?></span></a>
                </li>
                <?php endif; ?>
            <?php else: ?>
                <li>
                    <a href="#">No hay alertas <span class="label label-success">0</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
</ul>

<div class="modal fade" id="alertaProd">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class='fa fa-list'></i> Detalles de alerta</h4>
      </div>
      <div class="modal-body">
        <div>
            <p class="alert alert-warning">Los siguientes <a target="_blank" href="index.php?view=inventaryprod">productos</a> tienen pocas existencias:</p>
        </div>
        <div>
            <div class="list-group">
                <?php foreach($alertaProd as $prod): ?>
                <div class="list-group-item">
                    <?php echo $prod->getProduct()->nombre; ?>
                    <div class="pull-right">
                        <span data-toggle="tooltip" title="Mínimo" class="label label-warning"><?php echo $prod->minimo; ?></span>
                        <span data-toggle="tooltip" title="Exsistencias" class="label label-primary"><?php echo $prod->cantidad; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="alertaMP">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class='fa fa-list'></i> Detalles de alerta</h4>
      </div>
      <div class="modal-body">
        <div>
            <p class="alert alert-warning">La siguiente <a target="_blank" href="index.php?view=inventarymp">materia prima</a> tienen pocas existencias:</p>
        </div>
        <div>
            <div class="list-group">
                <?php foreach($alertaMP as $mp): ?>
                <div class="list-group-item">
                    <?php echo $mp->nombre; ?>
                    <div class="pull-right">
                        <span data-toggle="tooltip" title="Mínimo" class="label label-warning"><?php echo $mp->minimo; ?></span>
                        <span data-toggle="tooltip" title="Exsistencias" class="label label-primary"><?php echo $mp->existencias; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>