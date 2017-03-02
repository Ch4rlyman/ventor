<?php
extract($_POST);
include_once '../clases/unidadmedida.php';
$oUni = new UnidadMedida();

switch ($_REQUEST["f"]) {
    case 10:
        echo $oUni->listarCombo();
        break;
}
?>
