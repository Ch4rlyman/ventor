<?php
extract($_POST);
include_once '../clases/producto.php';
$oPro = new Producto();

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
    case 10:
        $data = $oPro->listarSugerencia($_GET["query"]);
        echo json_encode($data);
        break;
    case 20:
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if(sizeof($oPro->existe("codigo", $_GET["codigo"], $id))==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 El Codigo ya se encuentra Registrado. Ingrese otro.");
        }
        break;
    case 21:
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if(sizeof($oPro->existe("nombre", $_GET["nombre"], $id))==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 El Nombre ya se encuentra Registrado. Por favor verifique.");
        }
        break;
}

?>