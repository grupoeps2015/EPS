<?php

/**
 * Description of gestionEdificioModel
 *
 * @author amoino
 */
class gestionEdificioModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarEdificio($_datos) {
            $post = $this->_db->prepare("SELECT * from spagregaredificio(:nombre,:descripcion,:estado) as Id;");
            $post->execute($_datos);
            if ($post === false) {
                return "1101/agregarEdificio";
            } else {
                return $post->fetchall();
            }
    }

    public function asignarUnidadEdificio($_datos) {
            $post = $this->_db->prepare("SELECT * from spasignaredificioacentrounidadacademica(:centroUnidadAcademica,:edificio,:jornada, :estado) as Id;");
            $post->execute($_datos);
            if ($post === false) {
                return "1101/asignarUnidadEdificio";
            } else {
                return $post->fetchall();
            }
            
    }

    public function eliminarAsignacion($intIdAsignacion, $intEstadoNuevo) {

        $info = $this->_db->query("SELECT spEliminarAsignacionEdificio(" . $intIdAsignacion . "," . $intEstadoNuevo . ");");
        if ($info === false) {
            return "1102/eliminarEdificio";
        } else {
            return $info->fetchall();
        }
    }

    public function informacionAsignacionEdificio($idEdificio) {

        $post = $this->_db->query("select * from spDatosEdificio(" . $idEdificio . ");");
        //print_r("select * from spInformacionEdificio(" . $idEdificio . ");");
        if ($post === FALSE) {
            return "1104/gestionEdificio";
        } else {
            return $post->fetchall();
        }
    }
    
    public function allEdificios() {
        $info = $this->_db->query("select * from spmostraredificios();");
        if($info === false){
            return "1104/listadoEdificios";
        }else{
            return $info->fetchall();
        }
    }
    
    public function activarDesactivarEdificio($intIdEdificio, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT spactivardesactivaredificio(" . $intIdEdificio . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1103/activardesactivaredificio";
        }else{
            return $info->fetchall();
        }
    }
    
    public function actualizarEdificio($_datos) {
        $info = $this->_db->prepare("SELECT * spactualizarAsignacion(:centroUnidad,:edificio,:jornada,:asignacion) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarAsignacion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getJornadas() {
        $info = $this->_db->query("select * from spconsultageneral('jornada,nombre','cur_jornada');");
        if($info === false){
            return "1104/getJornadas";
        }else{
            return $info->fetchall();
        }
    }

}
