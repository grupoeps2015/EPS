<?php

class asignacionModel extends Model{
    
    public function __construct() {
        parent::__construct();
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
    public function getCursosDisponibles($ciclo, $carrera, $estudiante){
        $cursos = $this->_db->query("select * from spcursosdisponiblesasignacion({$ciclo},{$carrera},{$estudiante}) order by codigo;");
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
    public function desactivarAsignacionAnterior($nueva,$estudiante,$carrera,$periodo) {
        $info = $this->_db->query("SELECT * from spdesactivarasignacionanterior({$nueva},{$estudiante},{$carrera},{$periodo}) as Id;");
        $info->setFetchMode(PDO::FETCH_ASSOC);
        if($info === false){
            return "1103/desactivarAsignacionAnterior";
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
    
    public function getBoleta($ciclo, $estudiante, $carrera, $id = -1){
        $datos = $this->_db->query("select * from spobtenerboletaasignacion({$ciclo},{$estudiante},{$carrera},{$id});");
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        if($datos === false){
            return "1200/getBoleta";
        }else{
            return $datos->fetchall();
        }
    }
    
    public function getNota($ciclo, $estudiante, $carrera){
        $datos = $this->_db->query("select * from spobtenernotaasignacion({$ciclo},{$estudiante},{$carrera});");
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        if($datos === false){
            return "1200/getNota";
        }else{
            return $datos->fetchall();
        }
    }
    
    public function getIntentoAsignacion($ciclo, $estudiante, $carrera, $tipoper, $tipoasing){
        $datos = $this->_db->query("select * from spobtenerintentoasignacion({$ciclo},{$estudiante},{$carrera},{$tipoper},{$tipoasing}) as intento;");
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        if($datos === false){
            return "1200/getIntentoAsignacion";
        }else{
            return $datos->fetchall();
        }
    }
    
    public function datosSeccion($idSeccion) {
        $info = $this->_db->query("select * from spDatosSeccion(" . $idSeccion . ");");
        if($info === false){
            return "1104/datosSeccion";
        }else{
            return $info->fetchall();
        }
    }
    
    public function getCursosDisponiblesRetrasada($ciclo, $carrera, $estudiante){
        $cursos = $this->_db->query("select * from spcursosdisponiblesasignacionretrasada({$ciclo},{$carrera},{$estudiante}) order by codigo;");
        $cursos->setFetchMode(PDO::FETCH_ASSOC);
        if($cursos === false){
            return "1200/getCursosDisponiblesRetrasada";
        }else{
            return $cursos->fetchall();
        }
    }
    
    public function agregarAsignacionCursoRetrasada($asignacion,$pago,$oportunidad) {
        $info = $this->_db->query("SELECT * from spagregarasignacionretrasada({$asignacion},{$pago},{$oportunidad}) as Id;");
        if($info === false){
            return "1101/agregarAsignacionCursoRetrasada";
        }else{
            return $info->fetchall();
        }
    }
}