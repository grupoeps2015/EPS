<?php

class ajaxModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPais(){
        $post = $this->_db->query("select * from spconsultageneral('pais,nombre','adm_pais');");
        return $post->fetchall();
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
    
    public function getUnidades(){
          $post = $this->_db->query("select * from spconsultageneral('unidadAcademica,nombre','adm_unidadAcademica');");
          return $post->fetchall();
    }
    
    public function getCarreras($unidad){
        $post = $this->_db->query("select * from spcarreraxunidad({$unidad})");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        return $post->fetchAll();
    }
    
    public function getInfoCarreras($centro_unidadacademica){
        $post = $this->_db->query("select * from spinformacioncarrera({$centro_unidadacademica})");
        $post->setFetchMode(PDO::FETCH_ASSOC);
        return $post->fetchAll();
    }
    
}