<?php

class admEstudianteController extends Controller{
    
    private $_post;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER,'admEstudiante');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->deptos = $this->_post->getDeptos();
        $this->_view->setJs(ADM_FOLDER, array('admEstudiante'));
        $this->_view->renderizar(ADM_FOLDER,'admEstudiante');
    }
}

?>