<?php
	include ("../../core/autoload.php");
	include ("../../core/modules/sistema/model/ClientData.php");

	$ccf = false;
	if (isset($_POST["tipo"]) && $_POST["tipo"] == "CCF") {
		$clientes = ClientData::getAllWithNRC();
		$ccf = true;
	}else{
		$clientes = ClientData::getAll();
	}
	echo '<option value="">--NINGUNO--</option>';
?>
	<?php if (count($clientes)>0): ?>
		<?php foreach ($clientes as $cli): ?>
			<option value="<?php echo $cli->id; ?>"><?php echo $cli->name." ".$cli->lastname; ?></option>
		<?php endforeach; ?>
	<?php endif; ?>
	<script type="text/javascript">
		$(function(){
			$('.selectpicker').selectpicker('refresh');
		});
	</script>
	<?php if ($ccf): ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").attr("required","true");
			});
		</script>
	<?php else: ?>
		<script type="text/javascript">
			$(function(){
				$("#cliente").removeAttr("required","true");
			});
		</script>
	<?php endif; ?>
