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
    private $carrera;
    private $_encriptarFacil;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->getLibrary('wsGeneraOrdenPago');       
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encriptedEasy');
        $this->_encriptarFacil = new encriptedEasy();
        $this->_asign=$this->loadModel('asignacion');
        $this->_ajax = $this->loadModel("ajax");
        if ($this->getInteger('slEstudiantes')) {
            $this->estudiante = $this->getInteger('slEstudiantes');
        }
        else if($_SESSION["rol"] == ROL_ESTUDIANTE){
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
                $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
        }
        if ($this->getInteger('slEstudiantes') && $this->getInteger('slCarreras')) {
            $this->carrera = $this->getInteger('slCarreras');
        }
        else if (isset($_SESSION["carrera"])) {
            $this->carrera = $_SESSION["carrera"];
        }
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
    }
    
    public function inicio() {
        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONPENSUM);
//
//        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
//            echo "<script>
//                ".MSG_SINPERMISOS."
//                window.location.href='" . BASE_URL . "login/inicio';
//                </script>";
//        }

        $this->_view->renderizar('inicio');
    }
    
    public function index(){
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $this->_view->estudiante = $this->estudiante;
            $this->_view->carrera = $this->carrera;
        }
        
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONASIGNACION);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
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
        
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $tipoAs = ASIGN_JUNTADIRECTIVA;
        }
        else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
            $tipoAs = ASIGN_OTRAS;
        }
        $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_CURSOS, $tipoAs, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                //Hacer estas validaciones en rol estudiante
                if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                    //Si hay período activo, validar intentos de asignación
                    $intentoAsign = $this->_asign->getIntentoAsignacion($ciclo, $this->estudiante, $this->carrera, PERIODO_ASIGNACION_CURSOS, $periodo[0]['tipoasign']);
                    if(is_array($intentoAsign)){
                        $intentoAsign = (isset($intentoAsign[0]['intento']) ? $intentoAsign[0]['intento'] : 0);
                    }else{
                        $this->redireccionar("error/sql/" . $intentoAsign);
                        exit;
                    }
                    //Parámetro de máximo intento de asignaciones por ciclo
                    $parametroMaxIntentosAsign = $this->_ajax->valorParametro(CONS_PARAM_APP_MAXINTENTOSASIGN, -1, -1);
                    if(is_array($parametroMaxIntentosAsign)){
                        $parametroMaxIntentosAsign = (isset($parametroMaxIntentosAsign[0]['valorparametro']) ? $parametroMaxIntentosAsign[0]['valorparametro'] : 1);
                    }else{
                        $this->redireccionar("error/sql/" . $parametroMaxIntentosAsign);
                        exit;
                    }
                    //Si ha alcanzado o superado el máximo de intentos redirigir a boleta
                    if ($intentoAsign >= $parametroMaxIntentosAsign) {
                        $this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                        exit;
                    }
                }
                //Sino continuar
                //Mostrar cursos disponibles para asignación
                
                //TODO: Marlen: agregar listado de cursos
                $this->_view->asignacion = $periodo[0]['periodo'];
                $this->_view->lstCursos = $this->cursosDisponibles($ciclo);
                
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
                //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                //exit;
            }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        
        $this->_view->setJs(array('asignar'));
        $this->_view->renderizar('asignar');
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
            if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
                $tipoAs = ASIGN_JUNTADIRECTIVA;
            }
            else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                $tipoAs = ASIGN_OTRAS;
            }
            $periodo = $this->_asign->getPeriodo($this->getInteger('hdCiclo'), PERIODO_ASIGNACION_CURSOS, $tipoAs, $_SESSION["centrounidad"]);
            if(is_array($periodo)){
                if(isset($periodo[0]['periodo'])){
                    $tipoAsign = $periodo[0]['tipoasign'];
                    $periodo = $periodo[0]['periodo'];
                }
                else{
                    //TODO: Marlen: Redirigir a página de error de asignación
                    //echo "No existe período de asignación activo para este ciclo";
                    $this->redireccionar("error/asign/1300/10");
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
                if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                    //Si hay período activo, validar intentos de asignación
                    $intentoAsign = $this->_asign->getIntentoAsignacion($this->getInteger('hdCiclo'), $this->estudiante, $this->carrera, PERIODO_ASIGNACION_CURSOS, $tipoAsign);
                    if(is_array($intentoAsign)){
                        $intentoAsign = (isset($intentoAsign[0]['intento']) ? $intentoAsign[0]['intento'] : 0);
                    }else{
                        $this->redireccionar("error/sql/" . $intentoAsign);
                        exit;
                    }
                    //Parámetro de máximo intento de asignaciones por ciclo
                    $parametroMaxIntentosAsign = $this->_ajax->valorParametro(CONS_PARAM_APP_MAXINTENTOSASIGN, -1, -1);
                    if(is_array($parametroMaxIntentosAsign)){
                        $parametroMaxIntentosAsign = (isset($parametroMaxIntentosAsign[0]['valorparametro']) ? $parametroMaxIntentosAsign[0]['valorparametro'] : 1);
                    }else{
                        $this->redireccionar("error/sql/" . $parametroMaxIntentosAsign);
                        exit;
                    }
                    //Si ha alcanzado o superado el máximo de intentos redirigir a boleta
                    if ($intentoAsign >= $parametroMaxIntentosAsign) {
                        //TODO: Marlen: Redirigir a página de error de asignación
                        //echo "Cantidad de intentos de asignación por ciclo excede el límite establecido en parámetro";
                        $this->redireccionar("error/asign/1300/11");
                        exit;
                    }
                    //Sino continuar
                    //Parámetro de máximo número de cursos a asignarse
                    $parametroMaxCursosAAsignar = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCURSOSAASIGNARPORCICLO, $this->carrera, $_SESSION["centrounidad"]);
                    if(is_array($parametroMaxCursosAAsignar)){
                        $parametroMaxCursosAAsignar = (isset($parametroMaxCursosAAsignar[0]['valorparametro']) ? $parametroMaxCursosAAsignar[0]['valorparametro'] : -1);
                    }else{
                        $this->redireccionar("error/sql/" . $parametroMaxCursosAAsignar);
                        exit;
                    }
                    if($parametroMaxCursosAAsignar > 0){
                        if (count(array_filter($cursos))> $parametroMaxCursosAAsignar) {
                            //TODO: Marlen: Redirigir a página de error de asignación
                            //echo "Cursos a asignar superan el límite establecido en parámetro";
                            $this->redireccionar("error/asign/1300/12");
                            exit;
                        }
                    }

                    //Parámetro de número máximo de cursos traslapados 
                    $parametroMaxCursosTraslapados = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCURSOSTRASLAPADOS, $this->carrera, $_SESSION["centrounidad"]);
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
                                //echo "Curso no acepta traslape";
                                $this->redireccionar("error/asign/1300/13");
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
                        //echo "Cursos traslapados sobrepasan el máximo establecido por parámetro";
                        $this->redireccionar("error/asign/1300/14");
                        exit;
                    }
                    //Si no se acepta traslape y no hay cursos traslapados continuar
                    else if($cursosTraslapadosCantidad == $parametroMaxCursosTraslapados && $parametroMaxCursosTraslapados == 0){

                    }
                    //Si $parametroMaxCursosTraslapados >= $cursosTraslapados consultar parametroTiempoMaximoTraslapado y parametroCriterioTiempoTraslapado
                    else{
                        //Parámetro de tiempo máximo de traslape entre dos cursos 
                        $parametroTiempoMaximoTraslapado = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXTIEMPOTRASLAPE, $this->carrera, $_SESSION["centrounidad"]);
                        if(is_array($parametroTiempoMaximoTraslapado)){
                            $parametroTiempoMaximoTraslapado = (isset($parametroTiempoMaximoTraslapado[0]['valorparametro']) ? $parametroTiempoMaximoTraslapado[0]['valorparametro'] : -1);
                        }else{
                            $this->redireccionar("error/sql/" . $parametroTiempoMaximoTraslapado);
                            exit;
                        }
                        //Parámetro de criterio de traslape 
                        $parametroCriterioTiempoTraslapado = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_CRITERIOTIEMPOTRASLAPE, $this->carrera, $_SESSION["centrounidad"]);
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
                                    //echo "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
                                    $this->redireccionar("error/asign/1300/15");
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
                                    //echo "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
                                    $this->redireccionar("error/asign/1300/16");
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
                            //echo "No existe criterio de tiempo de traslape entre cursos";
                            $this->redireccionar("error/asign/1300/17");
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
                            $parametroCupoMaximo = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXCUPOPORSECCIONCURSO, $this->carrera, $_SESSION["centrounidad"]);
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
                                    //echo "No hay cupo disponible en esta sección";
                                    $this->redireccionar("error/asign/1300/18");
                                    exit;
                                }
                            }
                        }
                    }
                
                    //Previo a crear asignación, verificar que los cursos a asignar están dentro de los disponibles
                    for($i=0;$i<count($cursos);$i++){
                        if($cursos[$i] <> ""){
                            //Consultar el id del curso de la sección a asignar
                            $cursoSeccion = $this->_asign->datosSeccion($cursos[$i]);
                            if(is_array($cursoSeccion)){
                                $cursoSeccion = (isset($cursoSeccion[0]['curso']) ? $cursoSeccion[0]['curso'] : -1);
                            }else{
                                $this->redireccionar("error/sql/" . $cursoSeccion);
                                exit;
                            }
                            //Verificar que está en el listado
                            if(!in_array($cursoSeccion, array_column($this->cursosDisponibles($this->getInteger('hdCiclo')), 'curso'))){
                                //TODO: Marlen: Redirigir a página de error de asignación
                                //echo "Este curso no está disponible para asignación";
                                $this->redireccionar("error/asign/1300/19");
                                exit;
                            }
                        }
                    }   
                }
                //Crear ciclo asignación
                $asignacionEstudiante = $this->_asign->agregarCicloAsignacion($this->estudiante,$this->carrera,$periodo);
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
                //Desactivar asignación anterior
                if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                    $desactivarAsignacion = $this->_asign->desactivarAsignacionAnterior($asignacionEstudiante,$this->estudiante,$this->carrera,$periodo);
                    if(is_array($desactivarAsignacion)){
                    }else{
                        $this->redireccionar("error/sql/" . $desactivarAsignacion);
                        exit;
                    }
                }
                $this->boletaAsignacion($this->getInteger('hdAnio'),$this->getInteger('hdCiclo') );
                exit;
            }
        }
    }
    
    
    public function boletaAsignacion($anioA = -1, $cicloA = -1){
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $this->_view->estudiante = $this->estudiante;
            $this->_view->carrera = $this->carrera;
        }
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        //Si la búsqueda es por id
        if ($this->getTexto('txtIDBoleta')) {
            $periodo = $this->_asign->getBoleta(-1, -1, -1, $this->_encriptarFacil->decode($this->getTexto('txtIDBoleta')));
            if(is_array($periodo)){
                if(isset($periodo[0]['codigocurso'])){
                    $this->_view->asignacion = array_unique (array_column($periodo,'asignacion'));//$this->_encriptarFacil->encode($periodo[0]['asignacion']);
                    //$this->_view->fecha = $periodo[0]['fecha'];
                    //$this->_view->hora = $periodo[0]['hora'];
                    $this->_view->lstPar = $periodo;
                    $this->_view->_encriptarFacil = $this->_encriptarFacil;
                    $this->_view->estudiante = $periodo[0]['estudiante'];
                    $this->_view->carrera = $periodo[0]['carrera'];
                    $anio = $periodo[0]['anio'];
                    $ciclo = $periodo[0]['ciclo'];
                    $lsCiclos = $this->_ajax->getCiclosAjax($tipociclo, $anio);
                    if(is_array($lsCiclos)){
                        $this->_view->lstCiclos = $lsCiclos;
                    }else{
                        $this->redireccionar("error/sql/" . $lsCiclos);
                        exit;
                    }
                }
            }else{
                $this->redireccionar("error/sql/" . $periodo);
                exit;
            }
        }
        //Si la búsqueda es por ciclo, estudiante y carrera
        else{
            if ($anioA != -1){
                $anio = $anioA;
            }
            else if ($this->getInteger('hdEnvio')) {
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

            if ($cicloA != -1){
                $ciclo = $cicloA;
            }
            else if ($this->getInteger('hdEnvio')) {
                $ciclo = $this->getInteger('slCiclo');            
            }
            else{
                $ciclo = (isset($lsCiclos[count($lsCiclos)-1]['codigo']) ? $lsCiclos[count($lsCiclos)-1]['codigo'] : -1);
            }
            
            $periodo = $this->_asign->getBoleta($ciclo, $this->estudiante, $this->carrera);
            if(is_array($periodo)){
                if(isset($periodo[0]['codigocurso'])){
                    $this->_view->asignacion = array_unique (array_column($periodo,'asignacion'));//$this->_encriptarFacil->encode($periodo[0]['asignacion']);
                    //$this->_view->fecha = $periodo[0]['fecha'];
                    //$this->_view->hora = $periodo[0]['hora'];
                    $this->_view->lstPar = $periodo;
                    $this->_view->_encriptarFacil = $this->_encriptarFacil;
            }
            }else{
                $this->redireccionar("error/sql/" . $periodo);
                exit;
            }
        }
        
        
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('boletaAsignacion'));
        $this->_view->renderizar('boletaAsignacion');
    }
    
    public function notaAsignacion($anioA = -1, $cicloA = -1){
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $this->_view->estudiante = $this->estudiante;
            $this->_view->carrera = $this->carrera;
        }
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
        if ($anioA != -1){
            $anio = $anioA;
        }
        else if ($this->getInteger('hdEnvio')) {
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
        
        if ($cicloA != -1){
            $ciclo = $cicloA;
        }
        else if ($this->getInteger('hdEnvio')) {
            $ciclo = $this->getInteger('slCiclo');            
        }
        else{
            $ciclo = (isset($lsCiclos[count($lsCiclos)-1]['codigo']) ? $lsCiclos[count($lsCiclos)-1]['codigo'] : -1);
        }
        
        
        $this->_view->anio = $anio;
        $this->_view->ciclo = $ciclo;
        
        $periodo = $this->_asign->getNota($ciclo, $this->estudiante, $this->carrera);
        if(is_array($periodo)){
            if(isset($periodo[0]['codigocurso'])){
                $this->_view->asignacion = array_unique (array_column($periodo,'asignacion'));//$this->_encriptarFacil->encode($periodo[0]['asignacion']);
                //$this->_view->fecha = $periodo[0]['fecha'];
                //$this->_view->hora = $periodo[0]['hora'];
                $this->_view->lstPar = $periodo;
                $this->_view->_encriptarFacil = $this->_encriptarFacil;
        }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('notaAsignacion'));
        $this->_view->renderizar('notaAsignacion');
    }
    
    public function cursosDisponibles($ciclo){
        $cursosDisponiblesEstudiante = array();
        $lsCursosDisponibles = $this->_asign->getCursosDisponibles($ciclo, $this->carrera, $this->estudiante);
        if(is_array($lsCursosDisponibles)){

        }else{
            $this->redireccionar("error/sql/" . $lsCursosDisponibles);
            exit;
        }
        if(count($lsCursosDisponibles)){
            for($i=0;$i<count($lsCursosDisponibles);$i++){
                //Parámetro de máximas asignaciones por curso
                $parametroMaxAsignCurso = $this->_ajax->valorParametro(CONS_PARAM_CARRERA_MAXASIGNPORCURSO, $this->carrera, $_SESSION["centrounidad"]);
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
                    $datosCursoPensum = $this->_asign->getDatosCursoPensum($lsCursosDisponibles[$i]['curso'], $this->carrera, $this->estudiante);
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
                                        $cursoAprobado = $this->_asign->getDatosCursoAprobado($this->estudiante,$idCurso,$this->carrera);
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
                                        //Obtener total de créditos por estudiante por carrera
                                        $creditos = $this->_ajax->getCreditosEstudianteCarrera($this->estudiante,$this->carrera);
                                        if(is_array($creditos)){
                                            $creditos = $creditos[0]['creditos'];
                                        }else{
                                            $this->redireccionar("error/sql/" . $creditos);
                                            exit;
                                        }
                                        //Si el total de créditos es menor al prerrequisito, no mostrar curso como disponible
                                        if($creditos < $prerrequisitos[$a]['valor']){
                                            $requisitosAprobados = false;
                                        }
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
        return $cursosDisponiblesEstudiante;
    }
    
    public function indexRetrasada(){
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $this->_view->estudiante = $this->estudiante;
            $this->_view->carrera = $this->carrera;
        }
        
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
        
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            $tipoAs = ASIGN_JUNTADIRECTIVA;
        }
        else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
            $tipoAs = ASIGN_OTRAS;
        }
        $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_1RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
        if(is_array($periodo)){
            if(isset($periodo[0]['periodo'])){
                //Hacer estas validaciones en rol estudiante
                if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                    //Si hay período activo, validar intentos de asignación
                    $intentoAsign = $this->_asign->getIntentoAsignacion($ciclo, $this->estudiante, $this->carrera, PERIODO_ASIGNACION_CURSOS, $periodo[0]['tipoasign']);
                    if(is_array($intentoAsign)){
                        $intentoAsign = (isset($intentoAsign[0]['intento']) ? $intentoAsign[0]['intento'] : 0);
                    }else{
                        $this->redireccionar("error/sql/" . $intentoAsign);
                        exit;
                    }
                    //Parámetro de máximo intento de asignaciones por ciclo
                    $parametroMaxIntentosAsign = $this->_ajax->valorParametro(CONS_PARAM_APP_MAXINTENTOSASIGN, -1, -1);
                    if(is_array($parametroMaxIntentosAsign)){
                        $parametroMaxIntentosAsign = (isset($parametroMaxIntentosAsign[0]['valorparametro']) ? $parametroMaxIntentosAsign[0]['valorparametro'] : 1);
                    }else{
                        $this->redireccionar("error/sql/" . $parametroMaxIntentosAsign);
                        exit;
                    }
                    //Si ha alcanzado o superado el máximo de intentos redirigir a boleta
                    if ($intentoAsign >= $parametroMaxIntentosAsign) {
                        $this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                        exit;
                    }
                }
                //Sino continuar
                //Mostrar cursos disponibles para asignación
                
                //TODO: Marlen: agregar listado de cursos
                $this->_view->asignacion = $periodo[0]['periodo'];
                $this->_view->lstCursos = $this->cursosDisponiblesRetrasada($ciclo, $periodo[0]['periodo']);
                
            }
            else{
                //TODO: Marlen: mostrar boleta de asignación de cursos
                //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                //exit;
                //Si no hay de primera retrasada, buscar de segunda
                $periodo = $this->_asign->getPeriodo($ciclo, PERIODO_ASIGNACION_2RETRASADA, $tipoAs, $_SESSION["centrounidad"]);
                if(is_array($periodo)){
                    if(isset($periodo[0]['periodo'])){
                        //Hacer estas validaciones en rol estudiante
                        if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
                            //Si hay período activo, validar intentos de asignación
                            $intentoAsign = $this->_asign->getIntentoAsignacion($ciclo, $this->estudiante, $this->carrera, PERIODO_ASIGNACION_CURSOS, $periodo[0]['tipoasign']);
                            if(is_array($intentoAsign)){
                                $intentoAsign = (isset($intentoAsign[0]['intento']) ? $intentoAsign[0]['intento'] : 0);
                            }else{
                                $this->redireccionar("error/sql/" . $intentoAsign);
                                exit;
                            }
                            //Parámetro de máximo intento de asignaciones por ciclo
                            $parametroMaxIntentosAsign = $this->_ajax->valorParametro(CONS_PARAM_APP_MAXINTENTOSASIGN, -1, -1);
                            if(is_array($parametroMaxIntentosAsign)){
                                $parametroMaxIntentosAsign = (isset($parametroMaxIntentosAsign[0]['valorparametro']) ? $parametroMaxIntentosAsign[0]['valorparametro'] : 1);
                            }else{
                                $this->redireccionar("error/sql/" . $parametroMaxIntentosAsign);
                                exit;
                            }
                            //Si ha alcanzado o superado el máximo de intentos redirigir a boleta
                            if ($intentoAsign >= $parametroMaxIntentosAsign) {
                                $this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                                exit;
                            }
                        }
                        //Sino continuar
                        //Mostrar cursos disponibles para asignación

                        //TODO: Marlen: agregar listado de cursos
                        $this->_view->asignacion = $periodo[0]['periodo'];
                        $this->_view->lstCursos = $this->cursosDisponiblesRetrasada($ciclo);

                    }
                    else{
                        //TODO: Marlen: mostrar boleta de asignación de cursos
                        //$this->redireccionar("asignacion/boletaAsignacion/".$anio."/".$ciclo);
                        //exit;
                    }
                }else{
                    $this->redireccionar("error/sql/" . $periodo);
                    exit;
                }
            }
        }else{
            $this->redireccionar("error/sql/" . $periodo);
            exit;
        }
        
        if($_SESSION["rol"] == ROL_ESTUDIANTE){
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
                $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
        }
        
            $infoGeneral = $this->_ajax->getInfoGeneralEstudiante($_SESSION["usuario"]);
            if(is_array($infoGeneral)){
                $this->carnet = (isset($infoGeneral[0]['carnet']) ? $infoGeneral[0]['carnet'] : -1);
            }else{
                $this->redireccionar("error/sql/" . $infoGeneral);
                exit;
            }
        
        $boleta = $this->_asign->getBoletasPago($this->estudiante,$this->_view->asignacion ,$_SESSION["carrera"]);
        if(is_array($boleta)){
                $this->boleta = isset($boleta[0]['boleta']);
                if(isset($boleta[0]['boleta'])&&$this->boleta!=""&&$this->boleta!=null&&$this->boleta!=0)
                {
                    $this->_generaorden = new wsGeneraOrdenPago();
                    $prueba = $this->_generaorden->confirmacionPago($this->boleta,$this->carnet);
                    $cadena = implode(',', $prueba);

                    if ($this->_generaorden->parsear_resultado($cadena,"CODIGO_RESP") == "1") {
                        $this->_view->existePago = 1;
                    }
                    else {
                        $this->_view->existePago = 2;
                    }
                }
            }else{
                $this->redireccionar("error/sql/" . $boleta);
                exit;
            }
        
        $this->_view->setJs(array('asignarRetrasada'));
        $this->_view->renderizar('asignarRetrasada');
    }
    
    public function cursosDisponiblesRetrasada($ciclo,$periodo){
        $lsCursosDisponibles = $this->_asign->getCursosDisponiblesRetrasada($ciclo, $this->carrera, $this->estudiante, $periodo);
        if(is_array($lsCursosDisponibles)){

        }else{
            $this->redireccionar("error/sql/" . $lsCursosDisponibles);
            exit;
        }
        return $lsCursosDisponibles;
    }
    
    public function asignarRetrasada(){
        try{
        
        if ($this->getInteger('slCursos')) {
            $asignacion = $this->getInteger('slCursos'); 
            $res = $this->_asign->agregarAsignacionCursoRetrasada($asignacion, "1", "1");
            if(is_array($res)){
                $this->redireccionar("gestionRetrasadas/inicio");
                exit;
            }else{
                $this->redireccionar("error/sql/" . $res);
                exit;
            }
        }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            exit;
        }
    }
    
    
}

    if(!function_exists("array_column")){

        function array_column($array,$column_name){

            return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

        }

    }
?>
