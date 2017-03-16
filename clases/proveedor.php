<?php
/**
 * @autor Farly Minchan Lezcano
 */

require_once("cnx.php");
date_default_timezone_set("America/Lima");
mb_internal_encoding('UTF-8');

session_start();

class Proveedor {

    private $_misql;
    public $usuario;

    public function __construct() {
        $this->_misql = new MiSQL;
    }

    public function listarDataTable($postData) {
        global $bd_servidor;
        global $bd_baseDatos;
        global $bd_usuario;
        global $bd_clave;

        extract($postData);


        $aColumns = array('id', 'razon_social', 'ruc', 'representante', 'telefono', 'direccion', 'correo', "web");
        $sIndexColumn = 'id';
        $sTable = 'proveedor';

        $gaSql['user']     = $bd_usuario;
        $gaSql['password'] = $bd_clave;
        $gaSql['db']       = $bd_baseDatos;
        $gaSql['server']   = $bd_servidor;
        $gaSql['port']     = 3306;

        $input =& $_POST;

        $gaSql['charset']  = 'utf8';

        $db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
        if (mysqli_connect_error()) {
            die( 'Error conectando al servidor MySQL (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
        }

        if (!$db->set_charset($gaSql['charset'])) {
            die( 'Error abriendo el juego de caracteres "'.$gaSql['charset'].'": '.$db->error );
        }


        /**
         * Paginado
         */
        $sLimit = "";
        if ( isset( $input['start'] ) && $input['length'] != '-1' ) {
            $sLimit = " LIMIT ".intval( $input['start'] ).", ".intval( $input['length'] );
        }


        /**
         * Orden
         */
        $aOrderingRules = array();
        if ( isset( $input["order"][0]["column"] ) ) {
            $iSortingCols =  sizeof($input["order"]);
            for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
                if ( $input["columns"][$i]["orderable"] == 'true' ) {
                    $aOrderingRules[] =
                        "`".$aColumns[ intval( $input["order"][$i]["column"] ) ]."` "
                        .($input["order"][0]["dir"]==='asc' ? 'asc' : 'desc');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }

        $iColumnCount = count($aColumns);

        if ( isset($input['search']['value']) && $input['search']['value'] != "" ) {
            $aFilteringRules = array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if ( isset($input["columns"][$i]["searchable"]) && $input["columns"][$i]["searchable"] == 'true' ) {
                    $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string( $input['search']['value'] )."%'";
                }
            }
            if (!empty($aFilteringRules)) {
                $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
            }
        }

        // Individual column filtering
        for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
            if ( isset($input["columns"][$i]["searchable"]) && $input["columns"][$i]["searchable"] == 'true' && $input["columns"][$i]["search"]["value"] != '' ) {
                $aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input["columns"][$i]["search"]["value"])."%'";
            }
        }

        if (!empty($aFilteringRules)) {
            $sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }

        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        $sQuery = "
            SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
            FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;

        $rResult = $db->query( $sQuery ) or die($db->error);

        // Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS()";
        $rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
        list($iFilteredTotal) = $rResultFilterTotal->fetch_row();

        // Total data set length
        $sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
        $rResultTotal = $db->query( $sQuery ) or die($db->error);
        list($iTotal) = $rResultTotal->fetch_row();


        /**
         * Output
         */
        $output = array(
            "draw"                => intval($input['draw']),
            "recordsTotal"        => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data"               => array(),
        );

        while ( $aRow = $rResult->fetch_assoc() ) {
            $output['data'][] = $aRow;
        }

        return json_encode( $output );
    }

    public function insertar($data) {
        $fechaActual = date("Y-m-d H:i:s");

        $this->_misql->conectar();
        $this->_misql->sql = "INSERT INTO proveedor(razon_social, ruc, representante, telefono, direccion, correo, web, creador, creacion_fecha) " .
            "VALUES('" . $data["razon_social"] ."', '". $data["ruc"] ."','" . $data["representante"] . "', '". $data["telefono"] ."','" .
            $data["direccion"] . "', '". $data["correo"]. "', '". $data["web"] . "', ". $_SESSION["id"] . ", '". $fechaActual . "') ";
        //echo ($this->_misql->sql);
        $this->_misql->ejecutar();
        if($this->_misql->numeroAfectados())
            $idInsertado = $this->_misql->ultimoIdInsertado();
        else
            $idInsertado = 0;
        $this->_misql->cerrar();
        return $idInsertado;
    }

    public function actualizar($data) {
        $this->_misql->conectar();
        $this->_misql->sql = "UPDATE proveedor SET " .
            "razon_social='". $data["razon_social"] ."', " .
            "ruc='". $data["ruc"] ."', " .
            "representante='". $data["representante"] ."', " .
            "telefono='". $data["telefono"] ."', " .
            "direccion='". $data["direccion"] ."', " .
            "correo='". $data["correo"] ."', " .
            "web='". $data["web"] ."', " .
            "editor=". $_SESSION["id"] .", " .
            "edicion_fecha='". $fechaActual ."' ";
        $this->_misql->sql .="WHERE id=". $data["id"];
        $this->_misql->ejecutar();
        $nro = $this->_misql->numeroAfectados();
        $this->_misql->cerrar();
        return $nro;
    }

    public function eliminar($id) {
        $this->_misql->conectar();
        $this->_misql->sql = "DELETE FROM proveedor WHERE id=$id";
        $rs = $this->_misql->ejecutar();
        $this->_misql->cerrar();
        return $rs;
    }

    public function existe($campo, $valor, $idExcluido="") {
        $exclusion = $idExcluido=="" ? "" : " AND id <>" . $idExcluido;
        $this->_misql->sql = "SELECT * FROM proveedor WHERE $campo='" . $valor . "'" . $exclusion;
        $this->_misql->conectar();
        $data = $this->_misql->devolverArreglo();
        if(sizeof($data) > 0){
            $fila = $data[0];
        }else
            $fila = [];
        $this->_misql->liberarYcerrar();
        return $fila;
    }
    
    public function listarSugerencia($busqueda) {
        $this->_misql->conectar();
        $this->_misql->sql = "SELECT id, razon_social FROM proveedor WHERE razon_social like '%". $busqueda ."%' ORDER BY razon_social LIMIT 10";
        $data = $this->_misql->devolverArreglo();
        return $data;
    }

}