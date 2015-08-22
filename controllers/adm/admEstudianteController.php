<?php

class admEstudianteController extends Controller{
    
    private $_post;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        //$this->_post = $this->loadModel(ADM_FOLDER,'admEstudiante');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->clave = $this->_encriptar->encrypt("admin", UNIDAD_ACADEMICA);
        $this->_view->renderizarAdm('admEstudiante');
    }
}

?>