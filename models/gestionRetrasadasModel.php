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
}