<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getDeptos(){
        $post = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
        return $post->fetchall();
    }
    
    public function getMunicipio($depto){
        $post = $this->_db->query("select * from spMunicipioXDepto({$depto})");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        return $post->fetchAll();
    }
    
}