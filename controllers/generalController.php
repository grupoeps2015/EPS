<?php

/**
 * Description of gestionCursoController
 *
 * @author Arias
 */
class generalController extends Controller{
    
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index(){
        
    }
    
    public function seleccionarCentroUnidad(){
        $url = "";
        $numargs = func_num_args();
        if($numargs > 0){
            for($i =0; $i < $numargs; $i++){
                $url .= func_get_arg($i) . "/" ;
            }
        }
        if (isset($_SESSION["rol"]) && $_SESSION["rol"] == ROL_ADMINISTRADOR){
            if($this->getInteger('hdCentroUnidad')){
                $_SESSION["centrounidad"] = $this->getInteger('hdCentroUnidad');
                $tipociclo = $this->_ajax->valorParametro(CONS_PARAM_CENTROUNIDAD_TIPOCICLO, -1, $_SESSION["centrounidad"]);
                if(!is_array($tipociclo)){
                    $this->redireccionar("error/sql/" . $tipociclo);
                    exit;
                }
                $_SESSION["tipociclo"] = (isset($tipociclo[0]['valorparametro']) ? $tipociclo[0]['valorparametro'] : NULL);
                $this->redireccionar($url);
                exit;
            }
            $lstCentros = $this->_ajax->getCentro();
            if(is_array($lstCentros)){
                $this->_view->lstCentros = $lstCentros;
            }else{
                $this->redireccionar("error/sql/" . $lstCentros);
                exit;
            }
            
            $this->_view->titulo = 'Seleccionar Centro y Unidad - ' . APP_TITULO;
            $this->_view->url = 'general/seleccionarCentroUnidad/'.$url;
            $this->_view->setJs(array('seleccionarCentroUnidad'));
            $this->_view->renderizar('seleccionarCentroUnidad');
        }
        else if(!isset($_SESSION["centrounidad"])){
            if($this->getInteger('hdCentroUnidad')){
                $centroUnidad = $this->getInteger('hdCentroUnidad');
                $lstCentroUnidad = $this->_ajax->getCentroUnidadUsuario($_SESSION["usuario"]);
                if(is_array($lstCentroUnidad)){
                }else{
                    $this->redireccionar("error/sql/" . $lstCentroUnidad);
                    exit;
                }
                if(in_array($centroUnidad, array_column($lstCentroUnidad, 'centrounidad'))){
                    $_SESSION["centrounidad"] = $centroUnidad;
                    $tipociclo = $this->_ajax->valorParametro(CONS_PARAM_CENTROUNIDAD_TIPOCICLO, -1, $_SESSION["centrounidad"]);
                    if(!is_array($tipociclo)){
                        $this->redireccionar("error/sql/" . $tipociclo);
                        exit;
                    }
                    $_SESSION["tipociclo"] = (isset($tipociclo[0]['valorparametro']) ? $tipociclo[0]['valorparametro'] : NULL);
                    $this->redireccionar($url);
                    exit;
                }
            }
            $lstCentros = $this->_ajax->getCentrosUsuario($_SESSION["usuario"]);
            if(is_array($lstCentros)){
                $this->_view->lstCentros = $lstCentros;
            }else{
                $this->redireccionar("error/sql/" . $lstCentros);
                exit;
            }
            
            //TODO: Marlen: validar que el escogido este en el listado de centrounidad asignados al usuario
            $this->_view->titulo = 'Seleccionar Centro y Unidad - ' . APP_TITULO;
            $this->_view->url = 'general/seleccionarCentroUnidad/'.$url;
            $this->_view->setJs(array('seleccionarCentroUnidad'));
            $this->_view->renderizar('seleccionarCentroUnidad');
        }
        else {
            $this->redireccionar($url);
        }
    }
    
    public function seleccionarCarreraEstudiante(){
        $url = "";
        $numargs = func_num_args();
        if($numargs > 0){
            for($i =0; $i < $numargs; $i++){
                $url .= func_get_arg($i) . "/" ;
            }
        }
        if ($_SESSION["rol"] == ROL_ADMINISTRADOR || $_SESSION["rol"] == ROL_EMPLEADO) {
            if (strpos($url,"asignacion/boletaAsignacion") !== false ) {
                $this->_view->busquedaID = 1;
            }
            $this->_view->url = 'general/seleccionarCarreraEstudiante/'.$url;
            $anios = $this->_ajax->getAniosInscripcion();
            if(is_array($anios)){
                if(count($anios)){
                    
                    $this->_view->lstAnios = $anios;
                    $this->_view->url = $url;
                }else{
                    $this->redireccionar("login/salir");
                    exit;
                }

            }else{
                $this->redireccionar("error/sql/" . $anios);
                exit;
            }
            
            if($this->getInteger('slCarreras')){
               
                $carreraEstudiante = $this->getInteger('slCarreras');
                
                if(in_array($carreraEstudiante, array_column($carreras, 'codigo'))){
                    $_SESSION["carrera"] = $this->getInteger('slCarreras');
                     
                    $this->redireccionar($url);
                    exit;
                }
            }
        }
        else if ($_SESSION["rol"] == ROL_ESTUDIANTE) {
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
                if(!isset($estudiante[0]['id'])){
                    $this->redireccionar("login/salir");
                    exit;
                }
                else{
                    $estudiante = $estudiante[0]['id'];
                }
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
            $carreras = $this->_ajax->getCarrerasEstudiante($estudiante,$_SESSION["centrounidad"]);
            if(is_array($carreras)){
                if(count($carreras) > 1){
                    $this->_view->lstCarreras = $carreras;
                    $this->_view->url = 'general/seleccionarCarreraEstudiante/'.$url;
                }else if(count($carreras) == 1){
                    $_SESSION["carrera"] = $carreras[0]['codigo'];
                    $this->redireccionar($url);
                    exit;
                }else{
                    $this->redireccionar("login/salir");
                    exit;
                }

            }else{
                $this->redireccionar("error/sql/" . $carreras);
                exit;
            }
            if($this->getInteger('slCarreras')){
                $carreraEstudiante = $this->getInteger('slCarreras');
                if(in_array($carreraEstudiante, array_column($carreras, 'codigo'))){
                    $_SESSION["carrera"] = $this->getInteger('slCarreras');
                    $this->redireccionar($url);
                    exit;
                }
            }
        }
        
        $this->_view->titulo = 'Seleccionar Carrera - ' . APP_TITULO;
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");
        $this->_view->setJs(array('seleccionarCarreraEstudiante'));
        $this->_view->renderizar('seleccionarCarreraEstudiante');
    }
    
}

    if(!function_exists("array_column")){

        function array_column($array,$column_name){

            return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

        }

    }
?>