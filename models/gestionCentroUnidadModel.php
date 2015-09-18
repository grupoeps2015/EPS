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
    
    public function getDatosCentro($idCentro){
        $info = $this->_db->query("select * from spDatosCentro({$idCentro});");
        if($info === false){
            return "1104/getDatosCentro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function setCentro($_datos){
        $info = $this->_db->prepare("SELECT * from spAgregarCentros(:nombre,:direccion,:municipio,:zona);");
        $info->execute($_datos);
        if($info === false){
            return "1101/setCentro";
        }else{
            return $info->fetchall();
        }
    }
    
    public function updateCentro($_datos){
        $info = $this->_db->prepare("SELECT * from spActualizarCentro(:id,:nombre,:direccion,:municipio,:zona);");
        $info->execute($_datos);
        if($info === false){
            return "1103/updateCentro";
        }else{
            return $info->fetchall();
        }
    }
    
}