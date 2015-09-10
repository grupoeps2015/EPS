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

}
