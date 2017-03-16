<?php
/**
 * @autor Farly Minchan Lezcano
 */

require_once("cnx.php");
date_default_timezone_set("America/Lima");

session_start();

class TipoDocumento {

    private $_misql;
    public $usuario;

    public function __construct() {
        $this->_misql = new MiSQL;
    }
    
    public function listarEnCombo() {
        $this->_misql->conectar();
        $this->_misql->sql = "SELECT id, codigo, nombre FROM tipo_documento WHERE estado=1 ORDER BY orden";
        $data = $this->_misql->devolverArreglo();
        $opciones = "";
        for($i=0; $i<sizeof($data); $i++){
            $opciones .= "<option value='". $data[$i]["id"] ."' cod='". $data[$i]["codigo"] ."'>". $data[$i]["nombre"] ."</option>\n";
        }
        echo $opciones;
    }

    public function siguienteNumero($codigo) {
        $this->_misql->conectar();
        $this->_misql->sql = "SELECT serie, numero FROM tipo_documento WHERE codigo = $codigo";
        $data = $this->_misql->devolverArreglo();
        return $data;
    }

}