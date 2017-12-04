<?php
  // init.php
  // archivo iniciarlizador del modulo
  // librerias requeridas
  // * Database
  // * Session

  #Variables de sesión generales a utilizar:
  /*
  *  $_SESSION["usr_suc"] = 1; -> El id de la sucursal en la que se encuentra el usuario
  *  $_SESSION["adm"] = true; -> Si el usuario es adminisrador
  *  $_SESSION['user_id'] = $userid; -> El id de usuario
  */

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
  include "core/modules/".Module::$module."/model/SecretQuestionData.php";
  include "core/modules/".Module::$module."/model/FacturaData.php";
  include "core/modules/".Module::$module."/model/TraspasoData.php";
  include "core/modules/".Module::$module."/model/ProductoSucursalData.php";
  include "core/modules/".Module::$module."/model/ProduccionData.php";
  include "core/modules/".Module::$module."/model/ProduccionMPData.php";
  include "core/modules/".Module::$module."/model/PedidoData.php";
  include "core/modules/".Module::$module."/model/DireccionData.php";
  include "core/modules/".Module::$module."/model/UserTypeData.php";

  include "core/modules/".Module::$module."/model/UserData.php";
  include "core/modules/".Module::$module."/model/ProductData.php";
  include "core/modules/".Module::$module."/model/OperationTypeData.php";
  include "core/modules/".Module::$module."/model/OperationData.php";
  include "core/modules/".Module::$module."/model/SellData.php";
  /* 7-Jul-2015 */
  include "core/modules/".Module::$module."/model/ConfigurationData.php";
  include "core/modules/".Module::$module."/model/PersonData.php";
  include "core/modules/".Module::$module."/model/CategoryData.php";
  include "core/modules/".Module::$module."/model/BoxData.php";

  session_start();
  ob_start();

  Module::loadLayout();

?>
