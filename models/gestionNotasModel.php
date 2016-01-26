<?php

class gestionNotasModel extends Model {

    public function __construct() {
        parent::__construct();
    }
 
    public function getCursos() {
        $info = $this->_db->query("select * from spconsultageneral('curso, nombre','cur_curso');");
        if($info === false){
            return "1104/getCursos";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDocentesActivos($centrounidad){
        $info = $this->_db->query("SELECT * from spListaDocentesActivos(" . $centrounidad . ");");
        if($info === false){
            return "1104/getDocentesActivos";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getDocenteEspecifico($idUsuario){
        $info = $this->_db->query("SELECT * from spDocentesEspecifico(" . $idUsuario . ");");
        if($info === false){
            return "1104/getDocenteEspecifico";
        }else{
            return $info->fetchall();
        }
    }
    
    public function guardarNota($zona,$final,$asignacion){
        $info = $this->_db->query("select * from spActualizarNota({$zona},{$final},{$asignacion});");
        if($info === false){
            return "1103/guardarNota";
        }else{
            return $info->fetchall();
        }
    }
    
    public function guardarRetra($retra,$asignacionretra){
        $info = $this->_db->query("select * from spActualizarRetra({$retra},{$asignacionretra});");
        if($info === false){
            return "1103/guardarRetra";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getTipoActividad(){
        $info = $this->_db->query("select * from spconsultageneral('tipoactividad, nombre','cur_tipoactividad') order by codigo;");
        if($info === false){
            return "1104/getActividades";
        }else{
            return $info->fetchall();
        }
    }
    
    public function estadoCicloActividades($idCiclo){
        $info = $this->_db->query("select * from spobtenerestadocicloactividades({$idCiclo}) as estado;");
        if($info === false){
            return "1104/estadoCicloASignacion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function guardarActividad($idPadre,$idTipo,$nombre,$valor,$desc){
        $info = $this->_db->query("select * from spAgregarActividad({$idPadre},{$idTipo},'{$nombre}',{$valor},'{$desc}');");
        if($info === false){
            return "1101/guardarActividad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function asociarActividad($asignado,$actividad){
        $info = $this->_db->query("select * from spAgregarActividad({$asignado},{$actividad});");
        if($info === false){
            return "1101/asociarActividad";
        }else{
            return $info->fetchall();
        }
    }
    
    public function contarActividades($idTrama){
        $info = $this->_db->query("select * from spContarActividades({$idTrama});");
        if($info === false){
            return "1104/contarActividades";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getEstadoCicloNotas($idCiclo,$tipoPeriodo,$tipoAsignacion,$centrounidad){
        //$info = $this ->_db->query("select * from spobtenerestadociclonotas({$idCiclo}) as estadociclo");
        $info = $this->_db->query("select * from spPeriodoActivo({$idCiclo},{$tipoPeriodo},{$tipoAsignacion},{$centrounidad});");
        if($info === false){
            return "1104/getEstadoCicloNotas";
        }else{
            $info->setFetchMode(PDO::FETCH_ASSOC);
            return $info->fetchall();
        }
    }
    
    public function aprobarNota($idAsignado){
        $info = $this->_db->query("select * from spAprobarNota({$idAsignado});");
        if($info === false){
            return "1103/aprobarNota";
        }else{
            return $info->fetchall();
        }
    }
    
    public function aprobarRetra($idAsignado){
        $info = $this->_db->query("select * from spAprobarRetra({$idAsignado});");
        if($info === false){
            return "1103/aprobarRetra";
        }else{
            return $info->fetchall();
        }
    }
    
    public function reprobarNota($idAsignado){
        $info = $this->_db->query("select * from spReprobarNota({$idAsignado});");
        if($info === false){
            return "1103/reprobarNota";
        }else{
            return $info->fetchall();
        }
    }

    public function reprobarRetra($idAsignado){
        $info = $this->_db->query("select * from spReprobarRetra({$idAsignado});");
        if($info === false){
            return "1103/reprobarRetra";
        }else{
            return $info->fetchall();
        }
    }
    
    public function listarActividades($idAsignacion){
        $info = $this->_db->query("select * from spListarActividades({$idAsignacion});");
        if($info === false){
            return "1104/listarActividades";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getListaAsignados($id,$ciclo){
        $post = $this->_db->query("select * from spListaAsignados({$id},{$ciclo}) order by carnet");
        if($post === false){
            return "1104/getListaAsignados";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getListaAsignadosRetra($id,$ciclo,$retra){
        $post = $this->_db->query("select * from spListaAsignadosRetra({$id},{$ciclo},{$retra});");
        if($post === false){
            return "1104/getListaAsignadosRetra";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function getActividadesPadre(){
        $post = $this->_db->query("select * from spconsultageneral('tipoactividad, nombre','cur_tipoactividad') order by codigo;");
        if($post === false){
            return "1104/getActividadesPadre";
        }else{
            $post->setFetchMode(PDO::FETCH_ASSOC);
            return $post->fetchall();
        }
    }
    
    public function actualizarActividad($tipo,$valor,$nombre){
        $info = $this->_db->query("select * from spActualizarActividad({$tipo},{$valor},{$nombre});");
        if($info === false){
            return "1103/actualizarActividad";
        }else{
            return $info->fetchall();
        }
    }
}