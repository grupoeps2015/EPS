<?php

class ajaxController extends Controller{
    
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax=$this->loadGenericModel('ajax');
    }
    
    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->setJs("", array('ajax'));
        $this->_view->deptos = $this->_ajax->getDeptos();
        $this->_view->renderizar("",'index');
    }
    
    public function getMunicipio(){
        if($this->getInteger('Depto')){
            echo json_encode($this->_ajax->getMunicipio($this->getInteger('Depto')));
        }
    }
    
}

?>