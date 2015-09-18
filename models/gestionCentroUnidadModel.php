<?php
/**
 * Description of gestionCentroUnidadModel
 *
 * @author Rickardo
 */
class gestionCentroUnidadModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getInfoCentros(){
        $centros = $this->_db->query("select * from spInfoCentros();");
        if($centros === false){
            return "1104/getInfoCentros";
        }else{
            return $centros->fetchall();
        }
    }
    
    public function setCentro($_datos){
        $info = $this->_db->prepare("SELECT * from spAgregarCentros(:nombre,:direccion,:municipio,:zona);");
        $info->execute($_datos);
//        $sp  = '\'' . $_datos[':nombre'] . '\',' . '\'' . $_datos[':direccion'] . '\',';
//        $sp .= $_datos[':municipio'] . ',' . $_datos[':zona'];
//        $info = $this->_db->query("SELECT * from spAgregarCentros({$sp});");
        if($info === false){
            return "1101/setCentro/";
        }else{
            return $info->fetchall();
        }
    }
    
}