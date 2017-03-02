<?php
extract($_POST);
include_once '../clases/usuario.php';
$oUsu = new Usuario();

switch ($_REQUEST["f"]) {
    case 1:
        try {
            if (!$oUsu->validar($_POST)) {
                echo 'Error: Usuario o Clave Incorrectos';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
    case 2:
        echo $oUsu->cambiarClave($claveactual, $clavenueva);
        break;
    case 11:
        echo $oUsu->listarDataTable($_POST);
        break;
    case 12:
        $idInsetado = $oUsu->insertar($_POST);
        if ($idInsetado > 0) {
            $ok = true;
            $msg = "Registrado correctamente.";
        } else {
            $ok = false;
            $msg = "Error al insertar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 13:
        $ac = $oUsu->actualizar($_POST);
        if ($ac > 0) {
            $ok = true;
            $msg = "Actualizado correctamente.";
        } else{
            $ok = false;
            $msg = "Error al actualizar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 14:
        if($oUsu->eliminar($id)){
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
        if(sizeof($oUsu->existe("usuario", $_GET["usuario"], $id))==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 El Usuario ya existe. Por favor ingreso otro.");
        }
        break;
}

?>