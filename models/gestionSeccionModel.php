<?php

/**
 * Description of gestionSeccionModel
 *
 * @author Arias
 */

class gestionSeccionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarSeccion($_datos) {
        $info = $this->_db->prepare("SELECT * from spAgregarSeccion(:nombre,:descripcion,:curso,:estado,:tiposeccion) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposSeccion() {
        $info = $this->_db->query("select * from spconsultageneral('tiposeccion,nombre','cur_tiposeccion');");
        if($info === false){
            return "1104/getTiposSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function informacionSeccion($centrounidadacademica) {
        $info = $this->_db->query("select * from spInformacionSeccion(" . $centrounidadacademica . ");");
        if($info === false){
            return "1104/informacionSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarSeccion($intIdSeccion, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT spactivardesactivarseccion(" . $intIdSeccion . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosSeccion($idSeccion) {
        $info = $this->_db->query("select * from spDatosSeccion(" . $idSeccion . ");");
        if($info === false){
            return "1104/datosSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarSeccion($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarSeccion(:nombre,:descripcion,:curso,:id,:tiposeccion) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarSeccion";
        }else{
            return $info->fetchall();
        }
    }
}
