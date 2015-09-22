<?php

/**
 * Description of gestionPensumModel
 *
 * @author Arias
 */

class gestionPensumModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarCarrera($_datos) {
        $info = $this->_db->prepare("SELECT * from spAgregarCarrera(:nombre,:estado,:centrounidadacademica) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
    public function informacionCarrera($centrounidadacademica) {
        $info = $this->_db->query("select * from spInformacionCarrera(" . $centrounidadacademica . ");");
        if($info === false){
            return "1104/informacionCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarCarrera($intIdCarrera, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spActivarDesactivarCarrera(" . $intIdCarrera . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1103/eliminarCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosCarrera($idCarrera) {
        $info = $this->_db->query("select * from spDatosCarrera(" . $idCarrera . ");");
        if($info === false){
            return "1104/datosCarrera";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarCarrera($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarCarrera(:nombre,:id) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarCarrera";
        }else{
            return $info->fetchall();
        }
    }
}
