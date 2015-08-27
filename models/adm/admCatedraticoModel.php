<?php

class admCatedraticoModel extends Model {

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
        try{
            $this->_db->query("SELECT spUpdateInfoGeneralEstudiante(" . $sp . ");");
            //return "SELECT spUpdateInfoGeneralEstudiante(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
}