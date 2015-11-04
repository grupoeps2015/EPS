<?php

/**
 * Description of gestionEdificioModel
 *
 * @author amoino
 */
class gestionDesasignacionModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    
    public function allAsignaciones($carnet) {
        $info = $this->_db->query("select * from spgetasignaciones(".$carnet.");");
        if($info === false){
            return "1104/listadoAsignaciones";
        }else{
            return $info->fetchall();
        }
    }
    
    public function activarDesactivarAsignacion($intIdAsignacion, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spactivardesactivarasignacion(" . $intIdAsignacion . "," . $intEstadoNuevo . ");");
        if($info === false){
            return "1103/activardesactivararea";
        }else{
            return $info->fetchall();
        }
    }
    
    public function agregarDesasignacion($intIdAsignacion) {
        $post = $this->_db->prepare("SELECT * from spagregardesasignacion(:asignacion, :descripcion) as Id;");
            $post->execute($intIdAsignacion);
            if ($post === false) {
                return "1101/agregarDesasignacion";
            } else {
                return $post->fetchall();
            }
    }
    
    public function getAsignacion($asignacion) {
        $info = $this->_db->query("select * from spgetasignacion(".$asignacion.");");
        if($info === false){
            return "1104/getAsignacion";
        }else{
            return $info->fetchall();
        }
    }

}
