<?php
	#En este archivo se valida si hay materia prima sufuciente para finalizar la producción
	@session_start();
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/MateriaPrimaData.php");
	include ("../../core/modules/sistema/model/ProductData.php");
	include ("../../core/modules/sistema/model/ProduccionData.php");
	include ("../../core/modules/sistema/model/ProduccionMPData.php");
	include ("../../core/modules/sistema/model/ProductoSucursalData.php");

	if (isset($_POST["idFin"]) && is_numeric($_POST["idFin"]) && isset($_POST["option"])) {
		$opcion = $_POST["option"];
		$id = $_POST["idFin"];
		$produccion = ProduccionData::getById($id); #Obtener la información general de la producción
		
		switch($opcion){
			case "eliminar":
				$error = false;
				if($produccion->terminado == 1){
					$prodSuc = ProductoSucursalData::getBySucursalProducto(1,$produccion->idproducto);
					$prodSuc->cantidad -= $produccion->cantidad;
					if ($prodSuc->cantidad < 0){
						$error = true;
					}
				}
				if (!$error){
					# Si la producción se había finalizado
					if ($produccion->terminado == 1){
						# Obtener la materia prima utilizada y reailizar el 'reembolso'
						$materiaPrima = ProduccionMPData::getAllByProdId($produccion->id);
						foreach ($materiaPrima as $mp){
							$matPrim = MateriaPrimaData::getById($mp->idmateriaprima);
							$matPrim->existencias += $mp->cantidad;
							$matPrim->updateEx();
						}
					}

					$produccion->del();
					if(isset($prodSuc)){
						$prodSuc->updateEx();
					}
					setcookie("okProd","¡Se eliminó la información correctamente!");
				}else{
					setcookie("errorProd","Ocurrió un error al tratar de eliminar la produción.");
				}
				break;
			case "terminar":
				#Obtener toda la materia prima según el id de producción en donde se utilizó
				$materiaPrima = ProduccionMPData::getAllByProdId($produccion->id);
				$error = false; #Verificar si no hay suficiente materia prima para continuar
				$errorMP = array(); #Cuál es la materia prima insuficiente

				foreach ($materiaPrima as $mp){
					$matPrim = MateriaPrimaData::getById($mp->idmateriaprima);
					$resta = $matPrim->existencias - $mp->cantidad;
					if ($resta < 0){
						$error = true; #Ha encontrado al menos un error
						array_push($errorMP,$mp); #Agregar datos de la materia prima insuficiente encontrada
					}
				}

				if (!$error)
				{
					#Si no hay errores se procede a ejecutar lo siguienteÑ
					foreach ($materiaPrima as $mp){
						$matPrim = MateriaPrimaData::getById($mp->idmateriaprima);
						$matPrim->existencias -= $mp->cantidad;
						$matPrim->updateEx();
					}

					$produccion->finalizar();

					$prodSuc = ProductoSucursalData::getBySucursalProducto(1,$produccion->idproducto);
					$prodSuc->cantidad += $produccion->cantidad;
					$prodSuc->updateEx();
					setcookie("okProd","¡Se finalizó la producción correctamente!");
				}
				else
				{
					#En caso de haber errores el resultado será el detalle de la materia prima que hace falta
					#Esto se agrega al modal de error
					?>
					<div class="list-group">
						<?php foreach($errorMP as $mp): ?>
						<div class="list-group-item">
							<?php $matPrim = MateriaPrimaData::getById($mp->idmateriaprima); ?>
							<?php echo $matPrim->nombre; ?>
							<div class="pull-right">
								<span data-toggle="tooltip" title="Existentes" class="label label-danger"><?php echo $matPrim->existencias; ?></span>
								<span data-toggle="tooltip" title="Necesarios" class="label label-primary"><?php echo $mp->cantidad; ?></span>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
					<?php
				}
				break;
			default:
				break;
		}
	}
?>
