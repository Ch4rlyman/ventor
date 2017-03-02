<?php
/**
 * @autor Farly Minchan Lezcano
 */

require_once("cnx.php");
date_default_timezone_set("America/Lima");

session_start();

class Configuracion {

    private $_misql;
    public $usuario;

    public function __construct() {
        $this->_misql = new MiSQL;
    }

    public function actualizar($cfg) {
        $campos ="";
        $campos .= isset($cfg['razon_social']) ? ", razon_social='" . $cfg['razon_social'] . "' " : "";
        $campos .= isset($cfg['nombre']) ? ", nombre='" . $cfg['nombre'] . "' " : "";
        $campos .= isset($cfg['ruc']) ? ", ruc='" . $cfg['ruc'] . "' " : "";
        $campos .= isset($cfg['representante']) ? ", representante='" . $cfg['representante'] . "' " : "";
        $campos .= isset($cfg['correo']) ? ", correo='" . $cfg['correo'] . "' " : "";
        $campos .= isset($cfg['igv']) ? ", igv='" . $cfg['igv'] . "' " : "";

        $campos = substr($campos,2);

        $this->_misql->sql = "UPDATE configuracion SET $campos WHERE id=1";

        $this->_misql->conectar();
        $this->_misql->ejecutar();
        if($this->_misql->numeroAfectados()){
            $success = true;
            $msg = "Configuración actualizada correctamente.";

            $this->_misql->ejecutar("SELECT * FROM configuracion");
            $dCon = $this->_misql->devolverArreglo();
            $_SESSION["cfg"] = $dCon[0];
        }else{
            $success = false;
            $msg = "No se pudo actualizar la configuración. Inténtelo luego por favor.";
        }
        $this->_misql->cerrar();

        $rpta = array(
            "success" => $success,
            "msg" => $msg,
        );

        return json_encode($rpta);
    }

    public function info() {
        $this->_misql->sql = "SELECT * FROM configuracion";
        $fila = $this->_misql->devolverArreglo();
        $data = $fila[0];
        return json_encode($data);
    }

}