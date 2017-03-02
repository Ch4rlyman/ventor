<?php

//session_start();
extract($_POST);
include_once '../clases/categoria.php';
$oCat = new Categoria();

switch ($_REQUEST["f"]) {
    case 1:
        echo $oCat->listarDataTable($_POST);
        break;
    case 2:
        $idInsetado = $oCat->insertar($_POST);
        if($idInsetado > 0){
            $ok = true;
            $msg = "Registrado correctamente.";
        }else{
            $ok = false;
            $msg = "Error al insertar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 3:
        $ac = $oCat->actualizar($_POST);
        if ($ac >0 ){
            $ok = true;
            $msg = "Actualizado correctamente.";
        }else{
            $ok = false;
            $msg = "Error al actualizar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 4:
        if($oCat->eliminar($id)){
            $ok = true;
            $msg = "Registro eliminado correctamente.";
        }else{
            $ok = false;
            $msg = "Error al Eliminar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 10:
        $data = $oCat->listarSugerencia($_GET["query"]);
        echo json_encode($data);
        break;
}
?>
