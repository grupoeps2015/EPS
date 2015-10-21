<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of asignacionController
 *
 * @author ARIAS
 */
class asignacionController extends Controller{
    private $_asign;
    private $_ajax;
    private $estudiante;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_asign=$this->loadModel('asignacion');
        $this->_ajax = $this->loadModel("ajax");
        $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
        if(is_array($estudiante)){
            $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
        }else{
            $this->redireccionar("error/sql/" . $estudiante);
            exit;
        }
    }
    
    public function index(){
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
        if ($this->getInteger('hdEnvio')) {
            $anio = $this->getInteger('slAnio');            
        }
        else{
            $anio = (isset($lsAnios[count($lsAnios)-1]['anio']) ? $lsAnios[count($lsAnios)-1]['anio'] : -1);
        }
        
        $lsCiclos = $this->_ajax->getCiclosAjax($tipociclo, $anio);
        if(is_array($lsCiclos)){
            $this->_view->lstCiclos = $lsCiclos;
        }else{
            $this->redireccionar("error/sql/" . $lsCiclos);
            exit;
        }
        
        if ($this->getInteger('hdEnvio')) {
            $ciclo = $this->getInteger('slCiclo');            
        }
        else{
            $ciclo = (isset($lsCiclos[count($lsCiclos)-1]['codigo']) ? $lsCiclos[count($lsCiclos)-1]['codigo'] : -1);
        }
        
        
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        
        $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_CURSOS, ASIGN_OTRAS, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                $cursosDisponiblesEstudiante = array();
                $this->_view->asignacion = $periodo[0]['periodo'];
                $lsCursosDisponibles = $this->_asign->getCursosDisponibles($ciclo, $_SESSION["carrera"], $this->estudiante);
                if(is_array($lsCursosDisponibles)){
                    
                }else{
                    $this->redireccionar("error/sql/" . $lsCursosDisponibles);
                    exit;
                }
                if(count($lsCursosDisponibles)){
                    for($i=0;$i<count($lsCursosDisponibles);$i++){
                        //Parámetro de máximas asignaciones por curso
                        $parametroMaxAsignCurso = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXASIGNPORCURSO, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                        if(is_array($parametroMaxAsignCurso)){
                            $parametroMaxAsignCurso = (isset($parametroMaxAsignCurso[0]['valorparametro']) ? $parametroMaxAsignCurso[0]['valorparametro'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $parametroMaxAsignCurso);
                            exit;
                        }
                        //Oportunidad actual del curso para el estudiante
                        $oportunidadActual = $this->_asign->getOportunidadCursoEstudiante($this->estudiante,$lsCursosDisponibles[$i]['curso']);
                        if(is_array($oportunidadActual)){
                            $oportunidadActual = (isset($oportunidadActual[0]['oportunidad']) ? $oportunidadActual[0]['oportunidad'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $oportunidadActual);
                            exit;
                        }
                        //Si ya tiene el máximo de asignaciones por curso, no mostrar el curso como disponible y pasar al siguiente
                        if ($oportunidadActual < $parametroMaxAsignCurso) {
                            $oportunidadValida = true;
                        }
                        else{
                            $oportunidadValida = false;
                        }
                        
                        if ($oportunidadValida){
                            $datosCursoPensum = $this->_asign->getDatosCursoPensum($lsCursosDisponibles[$i]['curso'], $_SESSION["carrera"], $this->estudiante);
                            if(is_array($datosCursoPensum)){
                                if(!empty($datosCursoPensum[0]['prerrequisitos'])){
                                    $requisitosAprobados = true;
                                    $prerrequisitos = json_decode($datosCursoPensum[0]['prerrequisitos'],true);
                                    for($a=0;$a<count($prerrequisitos);$a++){
                                        switch ($prerrequisitos[$a]['tipo']) {
                                            case 1:
                                                //curso
                                                $cursoPensumArea = $this->_asign->getDatosCursoPensumArea($prerrequisitos[$a]['id']);
                                                if(is_array($cursoPensumArea)){
                                                    $idCurso = $cursoPensumArea[0]['curso'];
                                                }else{
                                                    $this->redireccionar("error/sql/" . $cursoPensumArea);
                                                    exit;
                                                }
                                                $cursoAprobado = $this->_asign->getDatosCursoAprobado($this->estudiante,$idCurso,$_SESSION["carrera"]);
                                                if(is_array($cursoAprobado)){

                                                }else{
                                                    $this->redireccionar("error/sql/" . $cursoAprobado);
                                                    exit;
                                                }
                                                //$idCurso en est_cursoaprobado
                                                //TODO: Marlen: consultar curpensumarea, obtener curso y consultarlo en est_cursoaprobado
                                                if(!count($cursoAprobado)){
                                                    $requisitosAprobados = false;
                                                }
                                                break;
                                            case 2:
                                                //credito
                                                //TODO: Marlen: calcular cuantos créditos lleva el estudiante y si son >= al $prerrequisitos[$i]['valor']
    //                                            if($algo){
    //                                                $requisitosAprobados = false;
    //                                            }
                                                break;
                                        }
                                        //$prerrequisitos[$i]['name']
                                        //$prerrequisitos[$i]['id']
                                        //$prerrequisitos[$i]['tipo']
                                        //$prerrequisitos[$i]['valor']

                                    }
                                    if($requisitosAprobados){
                                        array_push($cursosDisponiblesEstudiante,$lsCursosDisponibles[$i]);
                                    }
                                }
                                else{
                                    array_push($cursosDisponiblesEstudiante,$lsCursosDisponibles[$i]);
                                }
                            }else{
                                $this->redireccionar("error/sql/" . $datosCursoPensum);
                                exit;
                            }
                        }
                    }
                }
                //TODO: Marlen: agregar listado de cursos
                $this->_view->lstCursos = $cursosDisponiblesEstudiante;
                
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
            }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        
        $this->_view->setJs(array('inicio'));
        $this->_view->renderizar('inicio');
    }
    
    public function prueba(){
        $hola = json_decode('[{"name":"[002] TEORIA ECONOMICA I","id":"2","tipo":"1","valor":"-1"},{"name":"Creditos >=5","id":0,"tipo":"2","valor":"5"}]',true);
        //print_r($hola);
        for($i=0;$i<count($hola);$i++){
            echo $i.":"."<br>".
            $hola[$i]['name']."<br>".
            $hola[$i]['id']."<br>".
            $hola[$i]['tipo']."<br>".
            $hola[$i]['valor']."<br><br>";
        }
        
        $arrayobj = new ArrayObject(array(0=>'zero',1=>'one',2=>'two'));
        $arrayobj->offsetUnset(1);
        var_dump($arrayobj);
    }
    
    public function asignar(){
        if ($this->getInteger('hdEnvio') && $this->getInteger('hdCiclo')) {
            $periodo = $this->_asign->getPeriodo($this->getInteger('hdCiclo'), PERIODO_ASIGNACION_CURSOS, ASIGN_OTRAS, $_SESSION["centrounidad"]);
            if(is_array($periodo)){
                if(isset($periodo[0]['periodo'])){
                    $periodo = $periodo[0]['periodo'];
                }
                else{
                    //TODO: Marlen: Redirigir a página de error de asignación
                    echo "No existe período de asignación activo para este ciclo";
                    exit;
                }
            }
            else{
                $this->redireccionar("error/sql/" . $periodo);
                exit;
            }
            $cursos = $this->getTexto('hdCursos');
            $cursos = explode(";", $cursos);
            if(count($cursos)){
                //Parámetro de máximo número de cursos a asignarse
                $parametroMaxCursosAAsignar = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCURSOSAASIGNARPORCICLO, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                if(is_array($parametroMaxCursosAAsignar)){
                    $parametroMaxCursosAAsignar = (isset($parametroMaxCursosAAsignar[0]['valorparametro']) ? $parametroMaxCursosAAsignar[0]['valorparametro'] : -1);
                }else{
                    $this->redireccionar("error/sql/" . $parametroMaxCursosAAsignar);
                    exit;
                }
                if($parametroMaxCursosAAsignar > 0){
                    if (count(array_filter($cursos))> $parametroMaxCursosAAsignar) {
                        //TODO: Marlen: Redirigir a página de error de asignación
                        echo "Cursos a asignar superan el límite establecido en parámetro";
                        exit;
                    }
                }
                
                //Parámetro de número máximo de cursos traslapados 
                $parametroMaxCursosTraslapados = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCURSOSTRASLAPADOS, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                if(is_array($parametroMaxCursosTraslapados)){
                    $parametroMaxCursosTraslapados = (isset($parametroMaxCursosTraslapados[0]['valorparametro']) ? $parametroMaxCursosTraslapados[0]['valorparametro'] : -1);
                }else{
                    $this->redireccionar("error/sql/" . $parametroMaxCursosTraslapados);
                    exit;
                }
                
                //Consultar cursos traslapados en secciones elegidas a asignar
                $cursosTraslapados = $this->_asign->getCursosTraslapados($this->getInteger('hdCiclo'),$this->getTexto('hdCursos'));
                if(is_array($cursosTraslapados)){
                    $cursosTraslapadosCantidad = count($cursosTraslapados);
                    for($cu=0;$cu<$cursosTraslapadosCantidad;$cu++){
                        //Si el curso traslapado no acepta traslape
                        if(!$cursosTraslapados[$cu]['traslapecurso']){
                            //TODO: Marlen: Redirigir a página de error de asignación
                            echo "Curso no acepta traslape";
                            exit;
                        }
                    }
                }else{
                    $this->redireccionar("error/sql/" . $cursosTraslapados);
                    exit;
                }
                
                //Si $cursosTraslapados > $parametroMaxCursosTraslapados redirigir a error
                if($cursosTraslapadosCantidad > $parametroMaxCursosTraslapados){
                    //TODO: Marlen: Redirigir a página de error de asignación
                    echo "Cursos traslapados sobrepasan el máximo establecido por parámetro";
                    exit;
                }
                //Si no se acepta traslape y no hay cursos traslapados continuar
                else if($cursosTraslapadosCantidad == $parametroMaxCursosTraslapados && $parametroMaxCursosTraslapados == 0){
                    
                }
                //Si $parametroMaxCursosTraslapados >= $cursosTraslapados consultar parametroTiempoMaximoTraslapado y parametroCriterioTiempoTraslapado
                else{
                    //Parámetro de tiempo máximo de traslape entre dos cursos 
                    $parametroTiempoMaximoTraslapado = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXTIEMPOTRASLAPE, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                    if(is_array($parametroTiempoMaximoTraslapado)){
                        $parametroTiempoMaximoTraslapado = (isset($parametroTiempoMaximoTraslapado[0]['valorparametro']) ? $parametroTiempoMaximoTraslapado[0]['valorparametro'] : -1);
                    }else{
                        $this->redireccionar("error/sql/" . $parametroTiempoMaximoTraslapado);
                        exit;
                    }
                    //Parámetro de criterio de traslape 
                    $parametroCriterioTiempoTraslapado = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_CRITERIOTIEMPOTRASLAPE, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                    if(is_array($parametroCriterioTiempoTraslapado)){
                        $parametroCriterioTiempoTraslapado = (isset($parametroCriterioTiempoTraslapado[0]['valorparametro']) ? $parametroCriterioTiempoTraslapado[0]['valorparametro'] : "");
                    }else{
                        $this->redireccionar("error/sql/" . $parametroCriterioTiempoTraslapado);
                        exit;
                    }
                    //Según $parametroCriterioTiempoTraslapado ejecutar spObtenerTiempoTraslapeEntreCursos[Criterio]
                    if($parametroCriterioTiempoTraslapado == "D"){
                        $traslapes = $this->_asign->getTraslapesXCriterio('dia',$this->getInteger('hdCiclo'),$this->getTexto('hdCursos'),$parametroTiempoMaximoTraslapado);
                        if(is_array($traslapes)){
                            //Si no está vacío redirigir a página de error
                            if(count($traslapes)){
                                //TODO: Marlen: Redirigir a página de error de asignación
                                echo "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
                                exit;
                            }
                            //Si está vacío continuar
                        }else{
                            $this->redireccionar("error/sql/" . $traslapes);
                            exit;
                        }
                        
                    }
                    else if($parametroCriterioTiempoTraslapado == "S"){
                        $traslapes = $this->_asign->getTraslapesXCriterio('semana',$this->getInteger('hdCiclo'),$this->getTexto('hdCursos'),$parametroTiempoMaximoTraslapado);
                        if(is_array($traslapes)){
                            //Si no está vacío redirigir a página de error
                            if(count($traslapes)){
                                //TODO: Marlen: Redirigir a página de error de asignación
                                echo "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
                                exit;
                            }
                            //Si está vacío continuar
                        }else{
                            $this->redireccionar("error/sql/" . $traslapes);
                            exit;
                        }
                    }
                    else{
                        //TODO: Marlen: Redirigir a página de error de asignación
                        echo "No existe criterio de tiempo de traslape entre cursos";
                        exit;
                    }
                }
//                echo "Pasó todas las validaciones";
//                exit;
                //TODO: Marlen: Validar cupo de las secciones a asignar
                //
                for($i=0;$i<count($cursos);$i++){
                    if($cursos[$i] <> ""){
                        //Parámetro de cupo máximo por sección
                        $parametroCupoMaximo = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCUPOPORSECCIONCURSO, $_SESSION["carrera"], $_SESSION["centrounidad"]);
                        if(is_array($parametroCupoMaximo)){
                            $parametroCupoMaximo = (isset($parametroCupoMaximo[0]['valorparametro']) ? $parametroCupoMaximo[0]['valorparametro'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $parametroCupoMaximo);
                            exit;
                        }
                        //Si es > 0 hay límite
                        if ($parametroCupoMaximo > 0) {
                            $cupoSeccion = $this->_ajax->getCupoSeccionAjax($this->getInteger('hdCiclo'),$cursos[$i]);
                            if(is_array($cupoSeccion)){
                                $cupoSeccion = (isset($cupoSeccion[0]['cupo']) ? $cupoSeccion[0]['cupo'] : -1);
                            }else{
                                $this->redireccionar("error/sql/" . $cupoSeccion);
                                exit;
                            }
                            if ($cupoSeccion < $parametroCupoMaximo) {
                                //Si aún hay cupo continuar
                            }
                            else{
                                //TODO: Marlen: Redirigir a página de error de asignación
                                echo "No hay cupo disponible en esta sección";
                                exit;
                            }
                        }
                    }
                }
                //Crear ciclo asignación
                $asignacionEstudiante = $this->_asign->agregarCicloAsignacion($this->estudiante,$_SESSION["carrera"],$periodo);
                if(is_array($asignacionEstudiante)){
                    $asignacionEstudiante = (isset($asignacionEstudiante[0]['id']) ? $asignacionEstudiante[0]['id'] : -1);
                }else{
                    $this->redireccionar("error/sql/" . $asignacionEstudiante);
                    exit;
                }
                for($i=0;$i<count($cursos);$i++){
                    if($cursos[$i] <> ""){
                        //Insertar cada curso en asignación
                        $asignacionCurso = $this->_asign->agregarAsignacionCurso($this->estudiante,$asignacionEstudiante,$cursos[$i],"");
                        if(is_array($asignacionCurso)){
                            $asignacionCurso = (isset($asignacionCurso[0]['id']) ? $asignacionCurso[0]['id'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $asignacionCurso);
                            exit;
                        }
                    }
                    
                }
            }
        }
    }
    
}

?>
