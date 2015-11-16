<?php

/**
 * Description of gestionRetrasadasModel
 *
 * @author amoino
 */
class gestionRetrasadasModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function allAsignaciones($carnet,$carrera) {
        $info = $this->_db->query("select * from spgetasignaciones(".$carnet.",".$carrera.");");
        if($info === false){
            return "1104/listadoAsignaciones";
        }else{
            return $info->fetchall();
        }
    }
    
}