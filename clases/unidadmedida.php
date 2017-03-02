<?php

require_once("cnx.php");
date_default_timezone_set("America/Lima");
mb_internal_encoding('UTF-8');

class UnidadMedida {
    private $_misql;

    public function __construct() {
        $this->_misql = new MiSQL;
    }

    public function listarCombo() {
        $this->_misql->conectar();
        $this->_misql->sql = "SELECT * FROM unidad_medida ORDER BY nombre";
        $data = $this->_misql->devolverArreglo();
        $opciones = "<option value='0'> ---- Ninguno ----</option>\n";
        for($i=0; $i<sizeof($data); $i++){
            $opciones .= "<option value='". $data[$i]["id"] ."'>". $data[$i]["nombre"] ."</option>\n";
        }
        echo $opciones;
    }
}
?>