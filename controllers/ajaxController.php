<?php

class ajaxController extends Controller{
    
    public function __construct() {
        parent::__construct();
        //$this->_view->loadGenericModel();
    }
    
    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizar('index');
    }
    
}

?>