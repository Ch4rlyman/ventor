<?php
/**
 * @autor Farly Minchan Lezcano
 */

require_once("cnx.php");
date_default_timezone_set("America/Lima");

session_start();

class Usuario {

    private $_misql;
    public $usuario;

    public function __construct() {
        $this->_misql = new MiSQL;
    }

    public function validar($reg) {
        $usuario = htmlentities($reg['usuario']);
        $clave = md5(htmlentities($reg['clave']));
        $this->_misql->sql = "SELECT * FROM usuario ";
        $this->_misql->sql.="WHERE usuario='$usuario' AND clave='$clave' ";
        //echo $this->_misql->sql;
        $this->_misql->conectar();
        $this->_misql->ejecutar();
        if ($this->_misql->numeroRegistros() > 0) {
            $datos = $this->_misql->devolverArreglo();
            $_SESSION = $datos[0];

            $this->_misql->ejecutar("SELECT * FROM configuracion");
            $dCon = $this->_misql->devolverArreglo();
            $_SESSION["cfg"] = $dCon[0];

            $this->_misql->liberarYcerrar();
            return 1;
        }
        else
            return 0;
    }

    public function infoUsuario() {
        $success = true;
        $data ="";
        $msg = "";

        $this->_misql->sql = "SELECT * FROM usuario WHERE id=" . $_SESSION["id"];
        $fila = $this->_misql->devolverArreglo();
        $data = $fila[0];

        $rpta = array(
            "success" => $success,
            "msg" => $msg,
            "data" => $data,
        );

        return json_encode($rpta);
    }

    public function cambiarClave($claveActual,$claveNueva){
        $msg = "";
        $success = true;

        $cActual = md5(htmlentities($claveActual));
        $cNueva = md5(htmlentities($claveNueva));

        $this->_misql->sql = "SELECT id FROM usuario ";
        $this->_misql->sql.= "WHERE usuario='" . $_SESSION["usuario"] . "' AND clave='$cActual' ";

        $this->_misql->conectar();
        $this->_misql->ejecutar();

        if ($this->_misql->numeroRegistros()) {
            $this->_misql->sql = "UPDATE usuario SET clave='$cNueva' WHERE id=" . $_SESSION["id"];
            
            $this->_misql->ejecutar();
            if($this->_misql->numeroAfectados()){
                $success = true;
                $msg = "Su contraseña ha sido cambiada correctamente.";
            }else{
                $success = false;
                $msg = "No se pudo cambiar la contraseña. Inténtelo luego por favor.";
            }
            $this->_misql->cerrar();
        }else{
            $success = false;
            $msg = "La contraseña actual ingresada, no es la correcta.";
        }

        $rpta = array(
            "success" => $success,
            "msg" => $msg,
        );

        return json_encode($rpta);

    }

    public function listarDataTable($postData) {
        global $bd_servidor;
        global $bd_baseDatos;
        global $bd_usuario;
        global $bd_clave;

        extract($postData);

        $aColumns = array('id', 'nombre', 'usuario', 'tipo', 'estado');
        $sIndexColumn = 'id';
        $sTable = 'usuario';

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
        $usuario = htmlentities($data['usuario']);
        $clave = md5(htmlentities($data['clave']));
        $estado = isset($data['estado']) ? $data['estado'] : "0";

        $this->_misql->conectar();
        $this->_misql->sql = "INSERT INTO usuario(nombre, usuario, clave, tipo, estado) VALUES('" . $data["nombre"] ."', '". $usuario ."','" . $clave . "', '". $data["tipo"] ."', ". $estado .") ";
//        echo $this->_misql->sql;
        $this->_misql->ejecutar();
        if($this->_misql->numeroAfectados())
            $idInsertado = $this->_misql->ultimoIdInsertado();
        else
            $idInsertado = 0;
        $this->_misql->cerrar();
        return $idInsertado;
    }

    public function actualizar($data) {
        $usuario = htmlentities($data['usuario']);
        $clave = trim($data['clave'])=="" ? "" : "clave='". md5(htmlentities($data['clave'])) ."', ";
        $estado = isset($data['estado']) ? $data['estado'] : "0";

//        if(sizeof($this->existe("usuario",$usuario,$data["id"]))==0){
            $this->_misql->conectar();
            $this->_misql->sql = "UPDATE usuario SET " .
                "nombre='". $data["nombre"] ."', " .
                "usuario='". $usuario ."', " .
                $clave .
                "tipo='". $data["tipo"] ."', " .
                "estado=". $estado;
            $this->_misql->sql .=" WHERE id=". $data["id"];
            $this->_misql->ejecutar();
            $nro = $this->_misql->numeroAfectados();
            $this->_misql->cerrar();
//        }else{
//            $nro=-1;
//        }
        return $nro;
    }

    public function eliminar($id) {
        $this->_misql->conectar();
        $this->_misql->sql = "DELETE FROM usuario WHERE id=$id";
        $rs = $this->_misql->ejecutar();
        $this->_misql->cerrar();
        return $rs;
    }

    public function existe($campo, $valor, $idExcluido="") {
        $exclusion = $idExcluido=="" ? "" : " AND id <>" . $idExcluido;
        $this->_misql->sql = "SELECT * FROM usuario WHERE $campo='" . $valor . "'" . $exclusion;
        $this->_misql->conectar();
        $this->_misql->ejecutar();
        if($this->_misql->numeroRegistros() > 0){
            $fila = $this->_misql->devolverArreglo()[0];
        }else
            $fila = [];
        $this->_misql->liberarYcerrar();
        return $fila;
    }

}