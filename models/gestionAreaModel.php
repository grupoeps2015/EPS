<?php

/**
 * Description of gestionAreaModel
 *
 * @author amoino
 */
class gestionAreaModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarArea($_datos) {
            $post = $this->_db->prepare("SELECT * from spagregararea(:nombre,:descripcion,:estado) as Id;");
            $post->execute($_datos);
            if ($post === false) {
                return "1101/agregarArea";
            } else {
                return $post->fetchall();
            }
    }

    
    public function consultaArea($idArea) {

        $post = $this->_db->query("select * from spconsultaarea(" . $idArea . ");");
        
        if ($post === FALSE) {
            return "1104/consultaArea";
        } else {
            return $post->fetchall();
        }
    }
    
    public function allAreas() {
        $info = $this->_db->query("select * from spmostrarareas();");
        if($info === false){
            return "1104/listadoAreas";
        }else{
            return $info->fetchall();
        }
    }
    
    public function activarDesactivarArea($intIdArea, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spactivardesactivararea(" . $intIdArea . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1103/activardesactivararea";
        }else{
            return $info->fetchall();
        }
    }
    
   
    public function actualizarArea($_datos) {
        $sp = $_datos["edificio"] . ',';
        $sp .= '\'' . $_datos["nombre"] . '\',\'' . $_datos["descripcion"] . '\'';
       
        $info = $this->_db->query("SELECT * from spModificarArea(" . $sp. ");");
        if($info === false){
            return "1103/actualizarArea";
        }else{
            return $info->fetchall();
        }
    }
}
