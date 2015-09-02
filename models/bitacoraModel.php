<?php

/**
 * Description of bitacoraModel
 *
 * @author Arias
 */

class bitacoraModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function insertarBitacoraUsuario($_datos, $rol) {
        $tabla = '';
        //EST_Bitacora
        if ($rol == ROL_ESTUDIANTE){
            $tabla = 'EST_Bitacora';
        }
        //CAT_Bitacora
        else if($rol == ROL_DOCENTE){
            $tabla = 'CAT_Bitacora';
        }
        //ADM_Bitacora
        else{
            $tabla = 'ADM_Bitacora';
        }
        $sp .= '\'' . $tabla . '\',' . $_datos["usuario"] . ',\'' . $_datos["nombreusuario"] . '\',';
        $sp .= $_datos["funcion"] . ',\'' . $_datos["ip"] . '\',' . $_datos["registro"] . ',\'' ;
        $sp .= $_datos["tablacampo"] . '\',\'' . $_datos["descripcion"] . '\'';
        try {
            $post = $this->_db->query("SELECT from spInsertarBitacoraUsuario(" . $sp . ");");
            return $post->fetchall();
            //return "SELECT * from spInsertarBitacoraUsuario(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function insertarBitacoraAsignacion($_datos) {
        
    }
    
    public function insertarBitacoraNota($_datos) {
        
    }
    
}
