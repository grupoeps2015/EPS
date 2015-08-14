<?php

class admLoginController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('admLogin');
    }
    
    public function inicio(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('inicio','admLogin');
    }
    
}
?>