<?php

class usrHistoriaLoginController extends Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->_view->titulo = 'Escuela de Historia - USAC';
        $this->_view->renderizarUsrHistoria('usrHistoriaLogin');
    }
    
}
?>