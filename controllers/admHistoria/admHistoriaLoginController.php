<?php

class admHistoriaLoginController extends Controller{
    
    private $_post;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADMH_FOLDER,'admHistoriaAutenticarUsuario');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdmHistoria('admHistoriaLogin');
    }
    
    public function autenticar(){
        $this->_view->titulo = APP_TITULO;
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $this->_post->getUsuarios();
        echo $usuario . " - " . $pass;
        //crear y llamar metodo que autentique en el model
        //si esta bien redireccionar a la pagina de inicio
        //si no de vuelta al index
        //$this->redireccionar('admHistoriaLogin');
    }
}
?>