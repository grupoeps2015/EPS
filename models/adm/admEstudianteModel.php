<?php

class admEstudianteModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getDeptos() {
        $post = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
        return $post->fetchall();
    }
    
    public function getInfoGeneral($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralEstudiante({$idUsuario})");
        return $info->fetchAll();
    }
    
}