<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of asignacionController
 *
 * @author ARIAS
 */
class asignacionController extends Controller{
    private $_asign;
    
    public function __construct() {
        parent::__construct();
        $this->_asign=$this->loadModel('asignacion');
    }
    
    public function index(){
        $this->_view->setJs(array('inicio'));
        $this->_view->renderizar('inicio');
    }
}

?>
