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
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getTiposSeccion() {
        try{
            $post = $this->_db->query("select * from spconsultageneral('tiposeccion,nombre','cur_tiposeccion');");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function informacionSeccion($centrounidadacademica) {
        try {
            $post = $this->_db->query("select * from spInformacionSeccion(" . $centrounidadacademica . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function eliminarSeccion($intIdSeccion, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spactivardesactivarseccion(" . $intIdSeccion . "," . $intEstadoNuevo . ");");
            return "OK";
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function datosSeccion($idSeccion) {
        try {
            $post = $this->_db->query("select * from spDatosSeccion(" . $idSeccion . ");");
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
    
    public function actualizarSeccion($_datos) {
        try {
            $post = $this->_db->prepare("SELECT * from spActualizarSeccion(:nombre,:descripcion,:curso,:id,:tiposeccion) as Id;");
            $post->execute($_datos);
            return $post->fetchall();
        }catch(Exception $e){
            $error = "Error de sql: " . $e->getMessage();
            return $error;
        }
    }
}
