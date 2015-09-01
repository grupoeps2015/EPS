<?php

class estudianteModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getInfoGeneral($idUsuario){
        $info = $this->_db->query("select * from spInfoGeneralEstudiante({$idUsuario})");
        return $info->fetchAll();
    }
    
    public function setInfoGeneral($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["direccion"] . '\',';
        $sp .= $_datos["zona"] . ',' . $_datos["muni"] . ',\'';
        $sp .= $_datos["telefono"] . '\',' . $_datos["pais"];
        try{
            $this->_db->query("SELECT spUpdateInfoGeneralEstudiante(" . $sp . ");");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function setInfoEmergencia($_datos){
        $sp  = $_datos["id"] . ',\'' . $_datos["telefonoE"] . '\',\'';
        $sp .= $_datos["alergias"] . '\',\'' . $_datos["seguro"] . '\',\'';
        $sp .= $_datos["centro"] . '\',\'' . $_datos["sangre"] . '\'';
        try{
            $this->_db->query("SELECT spUpdateInfoEmergenciaEstudiante(" . $sp . ");");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
}