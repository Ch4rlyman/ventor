<?php
extract($_POST);
include_once '../clases/configuracion.php';
$oCon = new Configuracion();

switch ($_REQUEST["f"]) {
    case 1:
        break;
    case 2:
        echo $oCon->actualizar($_POST);
        break;
}

?>