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
        
        $_datos[":tabla"] = $tabla;
        $info = $this->_db->prepare("SELECT from spInsertarBitacoraUsuario(:tabla,:usuario,:nombreusuario,:funcion,:ip,:registro,:tablacampo,:descripcion);");
        $info->execute($_datos);
        if($info === false){
            return "1101/insertarBitacoraUsuario";
        }else{
            return $info->fetchall();
        }

    }
    
    public function insertarBitacoraAsignacion($_datos) {
        
    }
    
    public function insertarBitacoraNota($_datos) {
        
    }
    
}
