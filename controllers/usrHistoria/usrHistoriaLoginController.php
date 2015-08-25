<?php

class usrHistoriaLoginController extends Controller{
    
    private $_post;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ALL_FOLDER,'allAutenticarUsuario');
    }

    public function index(){
        $this->_view->titulo = 'Escuela de Historia - USAC';
        $this->_view->setJs(USRH_FOLDER,array('logearUsuario'));
        $this->_view->renderizar(USRH_FOLDER ,'usrHistoriaLogin','usrHistoriaLogin');
    }
    
        public function autenticar(){
        $this->_view->titulo = APP_TITULO;
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $tipo = $this->getInteger('tipo');
        $passEncrypt = $this->_encriptar->encrypt($pass, UNIDAD_ACADEMICA);
        //$this->_post->autenticarUsuario($usuario,$pass,$tipo);
        $respuesta = $this->_post->autenticarUsuario($tipo,$usuario,$passEncrypt);
        if (isset($respuesta) && count($respuesta) == 1){
            session_start();
                $_SESSION["usuario"] = $respuesta[0]['usuario'];
                $_SESSION["rol"] = $respuesta[0]['rol'];
                $_SESSION["nombre"] = $respuesta[0]['nombre'];
//                echo $_SESSION["usuario"];
//                echo $_SESSION["rol"];
//                echo $respuesta[0]['estado'];
//                $this->_view->renderizar(USRH_FOLDER, 'inicio');
                echo "Credenciales correctas";
        }
        else{
            echo "Credenciales incorrectas";
        }
        //echo $respuesta;
        //crear y llamar metodo que autentique en el model
        //si esta bien redireccionar a la pagina de inicio
        //si no de vuelta al index
        //$this->redireccionar('inicio');
        
    }
}
?>