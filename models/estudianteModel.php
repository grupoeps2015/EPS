<?php

class estudianteModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getInfoGeneral($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralEstudiante({$idUsuario})");
        if($info === false){
            return "1104/getInfoGeneral";
        }else{
            return $info->fetchall();
        }
    }
    
    public function setInfoGeneral($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["direccion"] . '\',';
        $sp .= $_datos["zona"] . ',' . $_datos["muni"] . ',\'';
        $sp .= $_datos["telefono"] . '\',' . $_datos["pais"];
        
        $info = $this->_db->query("SELECT spUpdateInfoGeneralEstudiante(" . $sp . ");");
        if($info === false){
            return "1103/setInfoGeneral";
        }else{
            return $info->fetchall();
        }
    }
    
    public function setInfoEmergencia($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["telefonoE"] . '\',\'';
        $sp .= $_datos["alergias"] . '\',\'' . $_datos["seguro"] . '\',\'';
        $sp .= $_datos["centro"] . '\',\'' . $_datos["sangre"] . '\'';
        $info = $this->_db->query("SELECT spUpdateInfoEmergenciaEstudiante(" . $sp . ");");
        if($info === false){
            return "1103/setInfoEmergencia";
        }else{
            return $info->fetchall();
        }
    }
    
}