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
    
    public function getDocentesActivos($centrounidad){
        $info = $this->_db->query("SELECT * from spListaDocentesActivos(" . $centrounidad . ");");
        if($info === false){
            return "1104/getDocentesActivos";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDocenteEspecifico($idUsuario){
        $info = $this->_db->query("SELECT * from spDocentesEspecifico(" . $idUsuario . ");");
        if($info === false){
            return "1104/getDocenteEspecifico";
        }else{
            return $info->fetchall();
        }
    }
    
}