<?php

/**
 * Description of gestionHorarioModel
 *
 * @author Arias
 */

class gestionHorarioModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getJornadas() {
        $info = $this->_db->query("select * from spconsultageneral('jornada,nombre','cur_jornada');");
        if($info === false){
            return "1104/getJornadas";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposPeriodo() {
        $info = $this->_db->query("select * from spconsultageneral('tipoperiodo,nombre','cur_tipoperiodo');");
        if($info === false){
            return "1104/getTiposPeriodo";
        }else{
            return $info->fetchall();
        }
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
        $info = $this->_db->query("SELECT spActivarDesactivarCarrera(" . $intIdCarrera . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarCarrera";
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
