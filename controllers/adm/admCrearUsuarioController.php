<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo
 */

class admCrearUsuarioController extends Controller{
    
    private $_post;
    
     public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel(ADM_FOLDER,'admCrearUsuario');
    }

    public function index(){
        $this->_view->posts = $this->_post->getDepartamentos();
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('admCrearUsuario', 'post');
    }
    
    public function agregarUsuario(){
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->renderizarAdm('agregarUsuario', 'post');
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>