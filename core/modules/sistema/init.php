<?php

	include "core/modules/".Module::$module."/model/ClientData.php";
	include "core/modules/".Module::$module."/model/SucursalData.php";
	include "core/modules/".Module::$module."/model/BancoData.php";
	include "core/modules/".Module::$module."/model/EmpleadoData.php";
	include "core/modules/".Module::$module."/model/ProviderData.php";
	include "core/modules/".Module::$module."/model/MateriaPrimaData.php";
	include "core/modules/".Module::$module."/model/ServiceData.php";
	include "core/modules/".Module::$module."/model/EnvioData.php";
	include "core/modules/".Module::$module."/model/GastoData.php";
	include "core/modules/".Module::$module."/model/ReabastecimientoData.php";
	include "core/modules/".Module::$module."/model/ReabastecimientoMPData.php";
	include "core/modules/".Module::$module."/model/CajaChicaData.php";
	include "core/modules/".Module::$module."/model/FacturaData.php";
	include "core/modules/".Module::$module."/model/TraspasoData.php";
	include "core/modules/".Module::$module."/model/ProductoSucursalData.php";
	include "core/modules/".Module::$module."/model/ProduccionData.php";
	include "core/modules/".Module::$module."/model/ProduccionMPData.php";
	include "core/modules/".Module::$module."/model/PedidoData.php";
	include "core/modules/".Module::$module."/model/DireccionData.php";
	include "core/modules/".Module::$module."/model/UserTypeData.php";
	include "core/modules/".Module::$module."/model/ComprobanteData.php";
	include "core/modules/".Module::$module."/model/AbonoData.php";
	include "core/modules/".Module::$module."/model/UserData.php";
	include "core/modules/".Module::$module."/model/ProductData.php";
	include "core/modules/".Module::$module."/model/ConfigurationData.php";
	include "core/modules/".Module::$module."/model/CategoryData.php";
	include "core/modules/".Module::$module."/model/BoxData.php";
	include "core/modules/".Module::$module."/model/CausaDevolucionData.php";
	include "core/modules/".Module::$module."/model/DevolucionData.php";
	include "core/modules/".Module::$module."/model/MantenimientoData.php";
	include "core/modules/".Module::$module."/model/MantenimientoProductoData.php";
	
	session_start();
	ob_start();

	Module::loadLayout();

?>