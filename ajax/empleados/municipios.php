<?php
	@session_start();
	include ("../../core/autoload.php");
	#include ("../../core/modules/sistema/model/UserData.php");
	include ("../../core/modules/sistema/model/DireccionData.php");

	$idDepto = "";
	echo "<option value=''>--SELECCIONE--</option>";
	if (isset($_POST["idDepto"]) && !empty($_POST["idDepto"])) {
		$idDepto = $_POST["idDepto"];
		$municipios = DireccionData::getMunicsByDeptoId($idDepto);
		#echo json_encode($municipios);
		foreach ($municipios as $mun):
	?>
			<option value="<?php echo $mun->id;?>"><?php echo $mun->nombreMunic; ?></option>
	<?php
		endforeach;
	}
?>
