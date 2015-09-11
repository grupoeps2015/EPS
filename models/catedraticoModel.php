<?php

class catedraticoModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getInfo($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralCatedratico({$idUsuario})");
        return $info->fetchAll();
    }
    
    public function setInfo($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["direccion"] . '\',';
        $sp .= $_datos["zona"] . ',' . $_datos["muni"] . ',\'';
        $sp .= $_datos["telefono"] . '\',' . $_datos["pais"];
        
        $info = $this->_db->query("SELECT spUpdateInfoGeneralCatedratico(" . $sp . ");");
        if($info === false){
            return "1103/setInfo";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getCatedraticos($centrounidad){
        $info = $this->_db->query("SELECT * from spinformacioncatedratico(" . $centrounidad . ");");
        if($info === false){
            return "1104/getCatedraticos";
        }else{
            return $info->fetchall();
        }
    }
}