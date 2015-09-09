<?php

/**
 * Description of menuModel
 *
 * @author Gerson
 */

class menuModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function consultarFuncionMenuPadre($rol) {
        try{
            $post = $this->_db->query("SELECT * FROM spFuncionMenuPadre(".$rol.");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function insertarBitacoraAsignacion($_datos) {
        
    }
    
    public function insertarBitacoraNota($_datos) {
        
    }
    
}
