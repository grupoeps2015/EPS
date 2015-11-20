<?php

/**
 * Description of gestionRetrasadasModel
 *
 * @author amoino
 */
class gestionRetrasadasModel extends Model {

    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function allAsignaciones($carnet,$carrera) {
        $info = $this->_db->query("select * from spgetasignaciones(".$carnet.",".$carrera.");");
        if($info === false){
            return "1104/listadoAsignaciones";
        }else{
            return $info->fetchall();
        }
    }
    public function getPeriodo($ciclo, $tipoPeriodo, $tipoAsignacion, $centrounidad){
        $periodo = $this->_db->query("select * from spPeriodoActivo({$ciclo},{$tipoPeriodo},{$tipoAsignacion},{$centrounidad});");
        $periodo->setFetchMode(PDO::FETCH_ASSOC);
        if($periodo === false){
            return "1200/getPeriodo";
        }else{
            return $periodo->fetchall();
        }
    }
    public function getDatosExtraBoleta($ciclo, $retrasada){
        $datos = $this->_db->query("select * from spdatosextraboletaretrasada({$ciclo},{$retrasada});");
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        if($datos === false){
            return "1200/getDatosExtraBoleta";
        }else{
            return $datos->fetchall();
        }
    }
    
    public function getCursosDisponiblesRetrasada($ciclo, $carrera, $estudiante, $periodo){
        $cursos = $this->_db->query("select * from spcursosdisponiblesasignacionretrasada({$ciclo},{$carrera},{$estudiante},{$periodo}) order by codigo;");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getCursosDisponiblesRetrasada";
        }else{
            return $cursos->fetchall();
        }
    }
    
    public function crearPago($boleta,$estudiante,$periodo,$carrera) {
        $info = $this->_db->query("select * from spagregarpago(".$boleta.",".$estudiante.",".$periodo.",".$carrera.");");
        if($info === false){
            return "1101/crearPago";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getBoletasPago($estudiante, $periodo, $carrera){
        $cursos = $this->_db->query("select * from spboletapagoporciclo({$estudiante},{$periodo},{$carrera});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getBoletasPago";
        }else{
            return $cursos->fetchall();
        }
    }
        
}