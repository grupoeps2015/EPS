<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPaises(){
        //$post = $this->_db->query("select * from spconsultageneral('departamento,nombre','adm_departamento');");
        //return $post->fetchall();
        $paises = $this->_db->query(
                "select * from adm_departamento"
                );
        return $paises->fetchall();
    }
    
    public function getCiudades($pais){
//        $post = $this->_db->query("select * from spMunicipioXDepto({$depto})");
//        $post->setFetchMode(PDO::FETCH_ASSOC);
//        return $post->fetchall();
        $ciudades = $this->_db->query(
                "select * from adm_municipio where departamento={$pais}"
                );
        $ciudades->setFetchMod(PDO::FETCH_ASSOC);
        return $ciudades->fetchall();
    }
    
}