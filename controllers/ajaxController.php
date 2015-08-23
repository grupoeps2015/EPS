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
        $this->_view->paises = $this->_ajax->getPaises();
        $this->_view->renderizar('index');
    }
    
    public function getMunicipio(){
        //$this->_view->munis = $this->_ajax->getMunicipio(1);
        echo json_encode($this->_ajax->getMunicipio('depto'));
    }
    
}

?>