<?php

  if (isset($_POST['username'])) {
    include("../conectarpdo.php");
    $cn = conexion();
    $user = $_POST['username'];
    $actual = null;
    if (isset($_POST['usract'])) {
      $actual = $_POST['usract'];
    }
    $sql= "select * from usuario where usuario = \"$user\"";
    $query = $cn->query($sql);
    $datos = $query->fetchAll();
    $usr = "";
    if (count($datos) > 0 ) {
      $usr = $datos[0][4];
      ?>
      <?php if (!empty($actual) && $actual == $usr): ?>

      <?php else: ?>
        <ul>
          <li role="alert">El nombre de usuario ingresado no está disponible</li>
        </ul>
        <script type="text/javascript">
          $(".username").attr('aria-invalid','true');
          $("#user-group").addClass('has-warning');
          $("#adduser").attr("onsubmit","return false");
        </script>
      <?php endif; ?>
      <?php
    }
  }

?>
