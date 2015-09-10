<?php

/**
 * Description of gestionCursoModel
 *
 * @author Arias
 */

class gestionCursoModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarCurso($_datos) {
        $info = $this->_db->prepare("SELECT * from spAgregarCurso(:codigo,:nombre,:traslape,:estado,:tipocurso,:centrounidadacademica) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1101/agregarCurso";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTiposCurso() {
        $info = $this->_db->query("select * from spconsultageneral('tipocurso,nombre','cur_tipo');");
        if($info === false){
            return "1104/getTiposCurso";
        }else{
            return $info->fetchall();
        }
    }
    
    public function informacionCurso($idCentroUnidad) {
        $info = $this->_db->query("select * from spInformacionCurso(" . $idCentroUnidad . ");");
        if($info === false){
            return "1104/informacionCurso";
        }else{
            return $info->fetchall();
        }
    }
    
    public function eliminarCurso($intIdCurso, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT spActivarDesactivarCurso(" . $intIdCurso . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarCurso";
        }else{
            return $info->fetchall();
        }
    }
    
    public function datosCurso($idCurso) {
        $info = $this->_db->query("select * from spDatosCurso(" . $idCurso . ");");
        if($info === false){
            return "1104/datosCurso";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarCurso($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarCurso(:codigo,:nombre,:traslape,:id,:tipocurso) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarCurso";
        }else{
            return $info->fetchall();
        }
    }
}
