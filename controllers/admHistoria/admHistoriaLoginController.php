<?php

class admHistoriaLoginController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdmHistoria('admHistoriaLogin');
    }
    
}
?>