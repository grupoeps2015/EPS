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
            $post = $this->_db->prepare("SELECT * from spAgregarCurso(:codigo,:nombre,:traslape,:estado,:tipocurso,:centrounidadacademica) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getTiposCurso() {
        try{
            $post = $this->_db->query("select * from spconsultageneral('tipocurso,nombre','cur_tipo');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function informacionCurso($idCentroUnidad) {
        try {
            $post = $this->_db->query("select * from spInformacionCurso(" . $idCentroUnidad . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function eliminarCurso($intIdCurso, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarCurso(" . $intIdCurso . "," . $intEstadoNuevo . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function datosCurso($idCurso) {
        try {
            $post = $this->_db->query("select * from spDatosCurso(" . $idCurso . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function actualizarCurso($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spActualizarCurso(:codigo,:nombre,:traslape,:id,:tipocurso) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
}
