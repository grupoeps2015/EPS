<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo
 */

class admCrearUsuarioController extends Controller{
    
    private $_post;
    private $_encriptar;
    
     public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER,'admCrearUsuario');
    }

    public function index(){
        $this->_view->posts = $this->_post->getUsuarios();
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('admCrearUsuario', 'admCrearUsuario');
    }
    
    public function agregarUsuario(){
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarUsuario'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        if($this->getInteger('btnAgregarEst') == 1){
            $this->_view->prueba = "Hola";
        }else{
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreEst1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEst')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEst1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCarnetEst')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $claveAleatorioa = $this->_encriptar->keyGenerator();
            $claveAleatoria = $this->_encriptar->encrypt($claveAleatorioa, UNIDAD_ACADEMICA);
            
            $this->_view->query = $this->_post->agregarUsuario($this->getTexto('txtNombreEst1'),
                                         $this->getTexto('txtCorreoEst'),
                                         $claveAleatoria,
                                         $this->getInteger('txtPregunta'),
                                         $this->getTexto('txtRespuesta'),
                                         $this->getInteger('txtIntentos'),
                                         $this->getTexto('txtFoto'),
                                         $this->getTexto('txtUnidadAcademica')
                    );
            $this->redireccionar('admCrearUsuario');
        }
            
        $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>