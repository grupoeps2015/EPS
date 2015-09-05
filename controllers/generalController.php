<?php

class generalController extends Controller{
    
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index(){
        
    }
    
    public function seleccionarCentroUnidad($url = ""){
        session_start();
        if (isset($_SESSION["rol"]) && $_SESSION["rol"] == ROL_ADMINISTRADOR){
            $this->_view->lstCentros = $this->_ajax->getCentro();
            $this->_view->titulo = 'Seleccionar Centro y Unidad - ' . APP_TITULO;
            $this->_view->url = $url;
            $this->_view->setJs(array('seleccionarCentroUnidad'));
            $this->_view->renderizar('seleccionarCentroUnidad');
        }
        else {
            $this->redireccionar($url);
        }    
        
    }
    

}
?>