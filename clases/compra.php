<?php

require_once("cnx.php");
date_default_timezone_set("America/Lima");
mb_internal_encoding('UTF-8');

class Compra {
    private $_misql;

    public function __construct() {
        $this->_misql = new MiSQL;
    }

    public function listarDataTable($postData) {
        global $bd_servidor;
        global $bd_baseDatos;
        global $bd_usuario;
        global $bd_clave;

        extract($postData);
        
        $aColumns = array('id', 'codigo', 'nombre','cantidad','precio','razon_social','fecha','producto_id','proveedor_id');
        $sIndexColumn = 'id';
        $sTable = 'v_compra';

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
        $this->_misql->sql = "INSERT INTO compra(fecha, cantidad, precio, producto_id, proveedor_id, creador, creacion_fecha) ".
            "VALUES(" .
            "'" . $data["fecha"]."', ".
            $data["cantidad"] .", ".
            $data["precio"] .", ".
            $data["producto_id"] .", ".
            $data["proveedor_id"] .", ".
            $_SESSION["id"] .", ".
            "'" . $fechaActual ."')";
        //echo $this->_misql->sql;
        $this->_misql->ejecutar();
        if($this->_misql->numeroAfectados()){
            $idInsertado = $this->_misql->ultimoIdInsertado();
            $this->_misql->ejecutar("UPDATE producto SET stock=stock + ". $data["cantidad"] ." WHERE id = " . $data["producto_id"]);
        }else{
            $idInsertado = 0;
        }
        $this->_misql->cerrar();
        return $idInsertado;
    }

    public function actualizar($data) {
        $fechaActual = date("Y-m-d H:i:s");
        $this->_misql->conectar();
        $this->_misql->sql = "UPDATE compra SET " .
            "precio=". $precio .", " .
            "fecha='". $fecha ."', " .
            "proveedor_id=". $proveedor_id .", " .
            "editor=". $_SESSION["id"] .", " .
            "edicion_fecha='". $fechaActual ."' ";
        $this->_misql->sql .="WHERE id=". $data["id"];
        $this->_misql->ejecutar();
        $nro = $this->_misql->numeroAfectados();
        $this->_misql->cerrar();
        return $nro;
    }

    public function eliminar($id, $eliminarStock = 0) {                  
        $this->_misql->conectar();
        
        if($eliminarStock){
            $this->_misql->sql = "SELECT * FROM compra WHERE id = " . $id;
            $dataCompra = $this->_misql->devolverArreglo();
            $dCompra = $dataCompra[0];
        }        

        $this->_misql->sql = "DELETE FROM compra WHERE id=$id";
        $rs = $this->_misql->ejecutar();

        if($eliminarStock){
            if ($rs)
                $this->_misql->ejecutar("UPDATE producto SET stock = stock - ". $dCompra["cantidad"] ." WHERE id = " . $dCompra["producto_id"]);    
        }

        $this->_misql->cerrar();
        return $rs;
    }
}
?>