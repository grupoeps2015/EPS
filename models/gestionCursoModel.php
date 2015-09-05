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
        try {
            $post = $this->_db->prepare("SELECT * from spAgregarCurso(:codigo,:nombre,:traslape,:estado,:tipocurso,:centro,:unidadacademica) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
            //return "SELECT * from spAgregarCurso(" . $sp . ") as Id;";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getTiposCurso() {
        $post = $this->_db->query("select * from spconsultageneral('tipocurso,nombre','cur_tipo');");
        return $post->fetchall();
    }
    
    public function informacionCurso($centro, $unidadacademica) {
        try {
            $post = $this->_db->query("select * from spInformacionCurso(" . $centro . "," . $unidadacademica . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function eliminarCurso($intIdCurso, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarCurso(" . $intIdCurso . "," . $intEstadoNuevo . ");");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function datosCurso($idCurso) {
        try {
            $post = $this->_db->query("select * from spDatosCurso(" . $idCurso . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function actualizarCurso($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spActualizarCurso(:codigo,:nombre,:traslape,:id,:tipocurso) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
