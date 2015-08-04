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
        $nombreUsr='';
        $correoUsr='';
        $fotoUsr='';
        $claveAleatorioa='';
        $crearUsr = false;
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarUsuario'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        if($this->getInteger('hdEnvio') == 1){
            $this->_view->datos = $_POST;
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
            
            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = true;
            
        }
        elseif($this->getInteger('hdEnvio') == 2){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreCat1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoCat')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoCat1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoCat')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = true;
            
        }
        elseif($this->getInteger('hdEnvio') == 3){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreEmp1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEmp')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEmp1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoEmp')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreEmp1');
            $correoUsr = $this->getTexto('txtCorreoEmp');
            $fotoUsr = $this->getTexto('txtFotoEmp');
            $crearUsr = true;
        }
        
        if($crearUsr){
            $claveAleatorioa = $this->_encriptar->keyGenerator();
            $claveAleatoria = $this->_encriptar->encrypt($claveAleatorioa, UNIDAD_ACADEMICA);
            $this->_post->agregarUsuario($nombreUsr,$correoUsr, $claveAleatoria, 0,'USAC', 5, 
                                         $fotoUsr, UNIDAD_ACADEMICA);
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