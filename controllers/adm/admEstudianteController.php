<?php

class admEstudianteController extends Controller{
    
    private $_est;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_est = $this->loadModel(ADM_FOLDER,'admEstudiante');
        $this->_ajax = $this->loadModel("",'ajax');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->deptos = $this->_ajax->getDeptos();
        $this->_view->setJs(ADM_FOLDER, array('admEstudiante'));
        $this->_view->renderizar(ADM_FOLDER,'admEstudiante');
    }
}
