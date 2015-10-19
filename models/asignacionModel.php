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
    public function getCursosDisponibles($ciclo, $carrera, $estudiante){
        $cursos = $this->_db->query("select * from spcursosdisponiblesasignacion({$ciclo},{$carrera},{$estudiante});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getCursosDisponibles";
        }else{
            return $cursos->fetchall();
        }
    }
    public function agregarCicloAsignacion($estudiante,$carrera,$periodo) {
        $info = $this->_db->query("SELECT * from spagregarasignacion({$estudiante},{$carrera},{$periodo}) as Id;");
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
    public function getDatosCursoPensum($curso, $carrera, $estudiante){
        $cursos = $this->_db->query("select * from spdatoscursopensum({$curso},{$carrera},{$estudiante});");
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
    public function getDatosCursoAprobado($estudiante,$id,$carrera){
        $cursos = $this->_db->query("select * from spdatoscursoaprobado({$id},{$estudiante},{$carrera});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getDatosCursoAprobado";
        }else{
            return $cursos->fetchall();
        }
    }
    
    public function getCursosTraslapados($ciclo,$secciones){
        $cursos = $this->_db->query("select * from spobtenercursostraslapados({$ciclo},'{$secciones}');");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getCursosTraslapados";
        }else{
            return $cursos->fetchall();
        }
    }
    
    public function getTraslapesXCriterio($criterio,$ciclo,$secciones,$max){
        $cursos = $this->_db->query("select * from spobtenertiempotraslapeentrecursos{$criterio}({$ciclo},'{$secciones}',{$max});");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/geTraslapesXCriterio";
        }else{
            return $cursos->fetchall();
        }
    }
    
    public function getOportunidadCursoEstudiante($estudiante,$id){
        $datos = $this->_db->query("select * from spoportunidadactualcursoestudiante({$estudiante},{$id}) as Oportunidad;");
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        if($datos === false){
            return "1200/getOportunidadCursoEstudiante";
        }else{
            return $datos->fetchall();
        }
    }
}