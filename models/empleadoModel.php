<?php

class empleadoModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getInfoGeneral($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralEmpleado({$idUsuario})");
        return $info->fetchAll();
    }
    
    public function setInfo($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["direccion"] . '\',';
        $sp .= $_datos["zona"] . ',' . $_datos["muni"] . ',\'';
        $sp .= $_datos["telefono"] . '\',' . $_datos["pais"];
        
        $info = $this->_db->query("SELECT * from spUpdateInfoGeneralEmpleado(" . $sp . ");");
        if($info === false){
            return "1103/setInfo";
        }else{
            return $info->fetchall();
        }
    }
       
}