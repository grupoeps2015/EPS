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

    public function actualizarAsignacionEdificio($_datos) {
        $info = $this->_db->prepare("SELECT spactualizarAsignacion(:centro_unidadacademica,:edificio,:jornada,:centrounidad_edificio) as Id;");
        $info->execute($_datos);
        if($info === false){
            return "1103/actualizarAsignacionEdificio";
        }else{
            return $info->fetchall();
        }
    }
    
    public function consultaEdificio($idEdificio) {

        $post = $this->_db->query("select * from spconsultaedificio(" . $idEdificio . ");");
        
        if ($post === FALSE) {
            return "1104/consultaEdificio";
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
        if ($post === FALSE) {
            return "1104/gestionEdificio";
        } else {
            return $post->fetchall();
        }
    }
    
     public function datosAsignacionEdificio($idAsignacion) {

        $post = $this->_db->query("select * from spinformacionasignacionedificio(" . $idAsignacion . ");");
        //print_r("select * from spInformacionEdificio(" . $idEdificio . ");");
        if ($post === FALSE) {
            return "1104/datosAsignacionEdificio";
        } else {
            return $post->fetchall();
        }
    }
    
    
    public function getCentro_UnidadAcademica($idCentroUnidadAcademica) {
        $info = $this->_db->query("select * from spconsultacentrounidadacademica( " . $idCentroUnidadAcademica . ");");
        if($info === false){
            return "1104/getCentro_UnidadAcademica";
        }else{
            return $info->fetchall();
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
        $sp = $_datos["edificio"] . ',';
        $sp .= '\'' . $_datos["nombre"] . '\',\'' . $_datos["descripcion"] . '\'';
       
        $info = $this->_db->query("SELECT spModificarEdificio(" . $sp. ");");
        if($info === false){
            return "1103/actualizarEdificio";
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
    
    //Región de gestión de salones
    public function listadoSalones($intIdEdificio,$intIdEstadoActivo) {
        $info = $this->_db->query("select * from spinformacionsalon(" . $intIdEdificio . "," . $intIdEstadoActivo . ");");
        if($info === false){
            return "1104/listadoSalones";
        }else{
            return $info->fetchall();
        }
    }
    
     public function eliminarSalon($intIdSalon, $intEstadoNuevo){
        $info = $this->_db->query("SELECT * from spModificarSalon(" . $intIdSalon . ",null,null,null," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarSalon";
        }else{
            return $info->fetchall();
        }
    }

    public function agregarSalon($_datos) {
            $post = $this->_db->prepare("SELECT spagregarsalon(:nombre,:edificio,:nivel,:capacidad);");
            $post->execute($_datos);
            if ($post === false) {
                return "1101/agregarSalon";
            } else {
                return $post->fetchall();
            }
    }
    
     public function consultaSalon($idSalon) {

        $post = $this->_db->query("select * from spdatossalon(" . $idSalon . ");");
        
        if ($post === FALSE) {
            return "1104/consultaSalon";
        } else {
            return $post->fetchall();
        }
    }
    
    public function actualizarSalon($_datos) {
        $sp = $_datos["salon"] . ',';
        $sp .= '\'' . $_datos["nombre"] . '\',' . $_datos["nivel"] . ',';
        $sp .= $_datos["capacidad"] . ',null';
        
        $info = $this->_db->query("SELECT * from spModificarSalon(" . $sp. ");");
        if($info === false){
            return "1103/actualizarSalon";
        }else{
            return $info->fetchall();
        }
    }
}
