<?php

//session_start();
extract($_POST);
include_once '../clases/marca.php';
$oMar = new Marca();

switch ($_REQUEST["f"]) {
    case 1:
        echo $oMar->listarDataTable($_POST);
        break;
    case 2:
        $idInsetado = $oMar->insertar($_POST);
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
        $ac = $oMar->actualizar($_POST);
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
        if($oMar->eliminar($id)){
            $ok = true;
            $msg = "Registro eliminado correctamente.";
        }else{
            $ok = false;
            $msg = "Error al Eliminar el registro. Inténtelo luego";
        }
        echo json_encode(array("success" => $ok, "msg" => $msg), JSON_PRETTY_PRINT);
        break;
    case 10:
        $data = $oMar->listarSugerencia($_GET["query"]);
        echo json_encode($data);
        break;
    case 20:
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        if(sizeof($oMar->existe("nombre", $_GET["nombre"], $id))==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 La Marca ya existe. Por favor ingreso otra.");
        }
        break;
    case 21:
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $mar = $oMar->existe("abreviatura", $_GET["abreviatura"], $id);
        if(sizeof($mar)==0){
            http_response_code(200);
        }else{
            header("HTTP/1.1 420 La Abreviatura ya existe y pertenece a: " . $mar["nombre"] . " Por favor ingreso otra.");
        }
        break;
}
?>
