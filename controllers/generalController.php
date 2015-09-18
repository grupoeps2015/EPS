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
        session_start();
        if (isset($_SESSION["rol"]) && $_SESSION["rol"] == ROL_ADMINISTRADOR){
            if($this->getInteger('hdCentroUnidad')){
                $_SESSION["centrounidad"] = $this->getInteger('hdCentroUnidad');
                $this->redireccionar($url);
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
        else {
            $this->redireccionar($url);
        }
    }
    
    public function seleccionarCarreraEstudiante(){
        session_start();
        if($this->getInteger('slCarreras')){
            $_SESSION["carrera"] = $this->getInteger('slCarreras');
            $this->redireccionar("login/inicio");
        }
        else{
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if(is_array($estudiante)){
            }else{
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
            if(!isset($estudiante[0]['id'])){
                $this->redireccionar("login/salir");
                exit;
            }
            $carreras = $this->_ajax->getCarrerasEstudiante($estudiante[0]['id']);
            if(is_array($carreras)){
                if(count($carreras) > 1){
                    $this->_view->lstCarreras = $carreras;
                }else if(count($carreras) == 1){
                    $_SESSION["carrera"] = $carreras[0]['codigo'];
                    $this->redireccionar("login/inicio");
                }else{
                    $this->redireccionar("login/salir");
                    exit;
                }
                
            }else{
                $this->redireccionar("error/sql/" . $carreras);
                exit;
            }
            $this->_view->titulo = 'Seleccionar Carrera - ' . APP_TITULO;
            $this->_view->setJs(array('seleccionarCarreraEstudiante'));
            $this->_view->renderizar('seleccionarCarreraEstudiante');
        }
    }
    
}
?>