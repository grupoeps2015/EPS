<?php

/**
 * Description of menuController
 *
 * @author Gerson
 */
class menuController extends Controller{
    
     private $_post;
    
    public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel('menu');
    }

    public function index(){
        $this->_view->lstMenuPadre = $this->_post->consultarFuncionMenuPadre(0);
        //$this->_view->lstMenuHijo = $this->_post->consultarFuncionMenuHijo();
        $this->_view->titulo = 'Menú - ' . APP_TITULO;
        
        //Se agregan los archivos JS, CSS, locales y publicos
        $this->_view->setJs(array('menu'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        //se renderiza la vista a mostrar
        $this->_view->renderizar('menu');
    }   
    
}