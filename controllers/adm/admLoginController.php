<?php

class admLoginController extends Controller{
    
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
        
        //Se agregan los archivos JS locales y publicos
        $this->_view->setJs(ADM_FOLDER, array('admLogin'));
        $this->_view->setJs("public",array('jquery.validate'));
        
        //se renderiza la vista a mostrar
        $this->_view->renderizar(ADM_FOLDER,'admLogin');
    }
    
    public function inicio(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('inicio','admLogin');
    }
    
    public function autenticar(){
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $tipo = $this->getInteger('tipo');
        
        $passEncrypt = $this->_encriptar->encrypt($pass, UNIDAD_ACADEMICA);
        $respuesta = $this->_post->autenticarUsuario($tipo,$usuario,$passEncrypt);
        if (isset($respuesta) && count($respuesta) == 1){
            session_start();
            $_SESSION["usuario"] = $respuesta[0]['usuario'];
            $_SESSION["rol"] = $respuesta[0]['rol'];
            $_SESSION["nombre"] = $respuesta[0]['nombre'];
            $this->_view->renderizar(ADM_FOLDER,'inicio');
        }
        else{
            echo "<script>alert('Credenciales incorrectas');</script>";
            $this->_view->renderizarAdm('admLogin');
        }
    }
}
?>