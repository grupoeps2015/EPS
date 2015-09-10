<?php

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
        $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->setJs(array('gestionNotas'));
        $this->_view->renderizar('gestionNotas');
    }
    
    public function actividades(){
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
    }
    
}
