<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais(){
        
    }
    
    public function setPais(){
        $post = $this->_db->query("select * from spconsultageneral('pais, nombre','adm_pais');");
        return $post->fetchall();
    }
    
    public function getDepartamento(){
        $post = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
        return $post->fetchall();
    }
    
    public function getMunicipio($depto){
        $post = $this->_db->query("select * from spMunicipioXDepto({$depto})");
        return $post->fetchall();
    }
    
}