<?php

class admHistoriaLoginController extends Controller{
    
    private $_post;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ALL_FOLDER,'allAutenticarUsuario');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdmHistoria('admHistoriaLogin');
    }
    
    public function autenticar(){
        $this->_view->titulo = APP_TITULO;
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $tipo = $this->getInteger('tipo');
        $passEncrypt = $this->_encriptar->encrypt($pass, UNIDAD_ACADEMICA);
        //$this->_post->autenticarUsuario($usuario,$pass,$tipo);
        echo $this->_post->autenticarUsuario($tipo,$usuario,$pass);
        //crear y llamar metodo que autentique en el model
        //si esta bien redireccionar a la pagina de inicio
        //si no de vuelta al index
        //$this->redireccionar('admHistoriaLogin');
    }
}
?>