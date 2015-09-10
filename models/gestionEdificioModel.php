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
        try {
            $post = $this->_db->prepare("SELECT * from spagregaredificio(:nombre,:descripcion,:estado) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function asignarUnidadEdificio($_datos){
        try {
            $post = $this->_db->prepare("SELECT * from spasignaredificioacentrounidadacademica(:centroUnidadAcademica,:edificio,:jornada, :estado) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
    }
    
    public function eliminarAsignacion($intIdAsignacion, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spEliminarAsignacionEdificio(" . $intIdAsignacion . "," . $intEstadoNuevo . ");");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function informacionAsignacionEdificio($idEdificio) {
        try {
            $post = $this->_db->query("select * from spInformacionEdificio(" . $idEdificio . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
