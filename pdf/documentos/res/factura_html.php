<style type="text/css">
	
	table { vertical-align: top; }
	tr    { vertical-align: top; }
	td    { vertical-align: top; }
	.midnight-blue{
		background:#2c3e50;
		padding: 4px 4px 4px;
		color:white;
		font-weight:bold;
		font-size:12px;
	}
	.silver{
		background:white;
		padding: 3px 4px 3px;
	}
	.clouds{
		background:#ecf0f1;
		padding: 3px 4px 3px;
	}
	.border-top{
		border-top: solid 1px #bdc3c7;
		
	}
	.border-left{
		border-left: solid 1px #bdc3c7;
	}
	.border-right{
		border-right: solid 1px #bdc3c7;
	}
	.border-bottom{
		border-bottom: solid 1px #bdc3c7;
	}
	table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
	}
	
</style>

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm" style="font-size: 12pt; font-family: arial" >
        	<page_footer>
					<table class="page_footer">
						<tr>

							<td style="width: 50%; text-align: left">
								P&aacute;gina [[page_cu]]/[[page_nb]]
							</td>
							<td style="width: 50%; text-align: right">
								&copy; <?php echo "Hierro Forjado"; echo  $anio = date('Y'); ?>
							</td>
						</tr>
					</table>
   			 </page_footer>
					<table cellspacing="0" style="width: 100%;">
						<tr>

							<td style="width: 25%; color: #444444;">
							
								
							</td>
							<td style="width: 50%; color: #34495e;font-size:12px;text-align:center">
								<span style="color: #34495e;font-size:14px;font-weight:bold">Hierro Forjado</span>
								<br>San Salvador<br> 
								Teléfono: 2209-2122<br>
								Email: hierroforjado@gmail.com
								
							</td>
							<?php
								$tipo = "";
								if ($sell->tipo == "CCF"){
									$tipo = "Comprobante de CF";
								}else{
									$tipo = $sell->tipo;
								}
							?>
							<td style="width: 25%;text-align:right">
							<?php echo strtoupper($tipo) ?> Nº <?php echo $sell->numerofactura; ?>
							</td>
							
						</tr>
					</table>
    <br>
    

	
					<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
						<tr>
						<td style="width:50%;" >FACTURAR A</td>
						</tr>
						<tr>
						<td style="width:50%;" >
								<?php echo $sell->getClient()->name." ".$sell->getClient()->lastname; ?>
								<br>
								<?php echo $sell->getClient()->direccion; ?>
								<br>
								<?php echo $sell->getClient()->nit; ?>
								
							</td>
						</tr>
						
				
					</table>
    
       <br>
					<table cellspacing="0" style="width: 100%; text-align: right; font-size: 11pt;">
					<tr>
					<td style="width:35%;">VENDEDOR</td>
						<td style="width:25%;">FECHA</td>

					</tr>
					<tr>
					<td style="width:35%;">

						<?php 
							echo $sell->getUser()->name." ".$sell->getUser()->lastname;
						?>
					</td>
					<td style="width:25%;"><?php echo $sell->fecha?></td>
					</tr>
					</table>
						<br>
	
					<table cellspacing="0" style="width: 10%; text-align: left; font-size: 10pt;">
					<tr>
						<th>Cantidad</th><br>
						<th>Nombre del Producto / Servicio</th><br>
						<th>Precio Unitario</th>
						<th>Total</th>
					</tr>
				<?php
					foreach($pVend as $vend):
						$prod = $vend->getProduct();
				?>
				<tr>
					
					<td><?php echo $vend->cantidad ;?></td>
					<td><?php echo $prod->nombre ;?></td>
					<td>$ <?php echo number_format($prod->precioventa,2,".",",") ;?></td>
					<td><b>$ <?php echo number_format($vend->cantidad*$prod->precioventa,2,".",","); $total += $vend->cantidad*$prod->precioventa;?></b></td>
				</tr>
				<?php	endforeach;	?>
				<?php
					foreach ($sVend as $vend):
					$prod = $vend->getService();
				?>
					<tr>
					
					<td><?php echo $vend->cantidad ;?></td>
					<td><?php echo $prod->nombre ;?></td>
					<td>$ <?php echo number_format($prod->precio,2,".",",") ;?></td>
					<td><b>$ <?php echo number_format($vend->cantidad*$prod->precio,2,".",","); $total += $vend->cantidad*$prod->precio;?></b></td>
					</tr>
				<?php endforeach; ?>
				
						<tr>		
							<td colspan="3" style="widtd: 85%; text-align: right;">SUBTOTAL &#36; </td>
							<td style="widtd: 15%; text-align: right;"> <?php echo number_format($total,2);?></td>
						</tr>
						
					</table>	
</page>