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
            return "1200/getEstadoCicloNotas";
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
    
    public function reprobarNota($idAsignado){
        $info = $this->_db->query("select * from spReprobarNota({$idAsignado});");
        if($info === false){
            return "1103/reprobarNota";
        }else{
            return $info->fetchall();
        }
    }
}