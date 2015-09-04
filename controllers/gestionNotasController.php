<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class gestionNotasController extends Controller{
    
    private $_notas;
    
    public function __construct() {
        parent::__construct();
        $this->_notas = $this->loadModel('gestionNotas');
    }
    
    public function index(){
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('gestionNotas'));
        $this->_view->renderizar('gestionNotas');
    }
    
    public function actividades(){
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
    }
    
}
