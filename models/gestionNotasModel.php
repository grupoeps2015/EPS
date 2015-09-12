<?php

class gestionNotasModel extends Model {

    public function __construct() {
        parent::__construct();
    }
 
    public function getCursos() {
        $info = $this->_db->query("select * from spconsultageneral('curso, nombre','cur_curso');");
        if($info === false){
            return "1104/getCursos";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getInfoCatedratico($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralCatedratico({$idUsuario})");
        return $info->fetchAll();
    }
    
}