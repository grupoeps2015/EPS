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

    public function agregarCarrera($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spAgregarCarrera(:nombre,:estado,:centrounidadacademica) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function informacionCarrera($centrounidadacademica) {
        try {
            $post = $this->_db->query("select * from spInformacionCarrera(" . $centrounidadacademica . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function eliminarCarrera($intIdCarrera, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarCarrera(" . $intIdCarrera . "," . $intEstadoNuevo . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function datosCarrera($idCarrera) {
        try {
            $post = $this->_db->query("select * from spDatosCarrera(" . $idCarrera . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function actualizarCarrera($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spActualizarCarrera(:nombre,:id) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
}
