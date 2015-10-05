<?php

class asignacionModel extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getPeriodo($ciclo, $tipoPeriodo, $tipoAsignacion, $centrounidad){
        $periodo = $this->_db->query("select * from spPeriodoActivo({$ciclo},{$tipoPeriodo},{$tipoAsignacion},{$centrounidad}) as periodo;");
        $periodo->setFetchMode(PDO::FETCH_ASSOC);
        if($periodo === false){
            return "1200/getPeriodo";
        }else{
            return $periodo->fetchall();
        }
    }
    public function getCursosDisponibles($ciclo, $carrera){
        $cursos = $this->_db->query("select * from spcursosdisponiblesasignacion({$ciclo},{$carrera});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getCursosDisponibles";
        }else{
            return $cursos->fetchall();
        }
    }
    public function agregarCicloAsignacion($estudiante,$periodo) {
        $info = $this->_db->query("SELECT * from spagregarasignacion({$estudiante},{$periodo}) as Id;");
        $info->setFetchMode(PDO::FETCH_ASSOC);
        if($info === false){
            return "1101/agregarCicloAsignacion";
        }else{
            return $info->fetchall();
        }
    }
    public function agregarAsignacionCurso($estudiante,$cicloasignacion,$seccion,$adjuntos) {
        $info = $this->_db->query("SELECT * from spagregarcursoasignacion({$estudiante},{$cicloasignacion},{$seccion},'{$adjuntos}') as Id;");
        $info->setFetchMode(PDO::FETCH_ASSOC);
        if($info === false){
            return "1101/agregarAsignacionCurso";
        }else{
            return $info->fetchall();
        }
    }
    public function getDatosCursoPensum($curso, $carrera){
        $cursos = $this->_db->query("select * from spdatoscursopensum({$curso},{$carrera});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getDatosCursoPensum";
        }else{
            return $cursos->fetchall();
        }
    }
    public function getDatosCursoPensumArea($id){
        $cursos = $this->_db->query("select * from spdatoscursopensumarea({$id});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getDatosCursoPensumArea";
        }else{
            return $cursos->fetchall();
        }
    }
    public function getDatosCursoAprobado($estudiante,$id){
        $cursos = $this->_db->query("select * from spdatoscursoaprobado({$id},{$estudiante});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getDatosCursoAprobado";
        }else{
            return $cursos->fetchall();
        }
    }
    
}