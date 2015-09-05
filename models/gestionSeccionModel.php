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
        try {
            $post = $this->_db->prepare("SELECT * from spAgregarSeccion(:nombre,:descripcion,:curso,:estado,:tiposeccion) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getTiposSeccion() {
        $post = $this->_db->query("select * from spconsultageneral('tiposeccion,nombre','cur_tiposeccion');");
        return $post->fetchall();
    }
    
    public function informacionSeccion($centro, $unidadacademica) {
        try {
            $post = $this->_db->query("select * from spInformacionSeccion(" . $centro . "," . $unidadacademica . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function eliminarSeccion($intIdSeccion, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spactivardesactivarseccion(" . $intIdSeccion . "," . $intEstadoNuevo . ");");
            //echo "SELECT spactivardesactivarseccion(" . $intIdSeccion . "," . $intEstadoNuevo . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function datosSeccion($idSeccion) {
        try {
            $post = $this->_db->query("select * from spDatosSeccion(" . $idSeccion . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function actualizarSeccion($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spActualizarSeccion(:nombre,:descripcion,:curso,:id,:tiposeccion) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
