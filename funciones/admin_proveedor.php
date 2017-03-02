<?php
extract($_POST);
include_once '../clases/proveedor.php';
$oPro = new Proveedor();

switch ($_REQUEST["f"]) {
    case 1:
        echo $oPro->listarDataTable($_POST);
        break;
    case 2:
        $idInsetado = $oPro->insertar($_POST);
        if ($idInsetado > 0) {
            $ok = true;
            $msg = "Registrado correctamente.";
        } else {
            $ok = false;
            $msg = "Error al insertar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 3:
        $ac = $oPro->actualizar($_POST);
        if ($ac > 0) {
            $ok = true;
            $msg = "Actualizado correctamente.";
        } else{
            $ok = false;
            $msg = "Error al actualizar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 4:
        if($oPro->eliminar($id)){
            $ok = true;
            $msg = "Registro eliminado correctamente.";
        }else{
            $ok = false;
            $msg = "Error al Eliminar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 20:
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if(sizeof($oPro->existe("ruc", $_GET["ruc"], $id))==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 El RUC ya se encuentra Registrado. Por favor verifique.");
        }
        break;
}

?>