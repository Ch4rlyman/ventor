<?php

//session_start();
extract($_POST);
include_once '../clases/tipodocumento.php';
$obj = new TipoDocumento();

switch ($_REQUEST["f"]) {
    case 10:
        echo $obj->listarEnCombo();
        break;
}
?>
